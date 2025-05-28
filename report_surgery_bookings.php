<?php
require_once('bdd.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// รับค่าฟิลเตอร์จากฟอร์ม (ถ้ามี)
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$surgeon = isset($_GET['surgeon']) ? $_GET['surgeon'] : '';
$department_or = isset($_GET['department_or']) ? $_GET['department_or'] : '';

// สร้างเงื่อนไข SQL สำหรับฟิลเตอร์
$conditions = [];
$params = [];
if (!empty($start_date)) {
    $conditions[] = "DATE(sb.start_datetime) >= :start_date";
    $params[':start_date'] = $start_date;
}
if (!empty($end_date)) {
    $conditions[] = "DATE(sb.start_datetime) <= :end_date";
    $params[':end_date'] = $end_date;
}
if (!empty($surgeon)) {
    $conditions[] = "sb.surgeon = :surgeon";
    $params[':surgeon'] = $surgeon;
}
if (!empty($department_or)) {
    $conditions[] = "sb.department_or = :department_or";
    $params[':department_or'] = $department_or;
}

$where_clause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

// Query สำหรับดึงข้อมูลการจอง โดยจัดกลุ่มตาม ปี, เดือน, แพทย์, แผนก
$sql = "
    SELECT 
        YEAR(sb.start_datetime) AS year,
        MONTH(sb.start_datetime) AS month,
        sb.surgeon,
        d.ndoctor AS surgeon_name,
        sb.department_or,
        sb.id,
        sb.patient_id,
        p.fullname AS patient_name,
        sb.surgery_type,
        sb.patient_type,
        sb.anesthesia,
        sb.dx,
        sb.op,
        sb.start_datetime,
        sb.end_datetime,
        sb.note,
        sb.post_surgery_booking,
        sb.investigations,
        sb.consult_department,
        sb.blood_booking
    FROM surgery_bookings sb
    LEFT JOIN patients p ON sb.patient_id = p.id
    LEFT JOIN doctor d ON sb.surgeon = d.iddoctor
    $where_clause
    ORDER BY 
        year DESC, month DESC, sb.surgeon, sb.department_or, sb.start_datetime
";

$bdd->exec("SET NAMES utf8");
$stmt = $bdd->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ดึงรายชื่อแพทย์และแผนกสำหรับฟอร์มฟิลเตอร์
$surgeons_sql = "SELECT iddoctor, ndoctor FROM doctor ORDER BY ndoctor ASC";
$surgeons_stmt = $bdd->prepare($surgeons_sql);
$surgeons_stmt->execute();
$surgeons = $surgeons_stmt->fetchAll(PDO::FETCH_ASSOC);

$departments = ['สูตินรีเวช', 'ศัลยกรรม', 'ออร์โธปิดิกส์', 'ฉุกเฉิน'];

// วันที่สร้างรายงาน
$report_date = date('d/m/Y');
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/pdh.ico"  type="image/ico">
    <title>รายงานการจองห้องผ่าตัด - โรงพยาบาลปลวกแดง</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'TH Sarabun New', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-header img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .report-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0;
        }
        .report-header p {
            font-size: 16px;
            color: #7f8c8d;
            margin: 5px 0;
        }
        h2, h3, h4, h5 {
            color: #2c3e50;
            font-weight: bold;
        }
        h2 { font-size: 22px; margin-top: 20px; }
        h3 { font-size: 20px; margin-top: 15px; }
        h4 { font-size: 18px; margin-top: 10px; }
        h5 { font-size: 16px; margin-top: 10px; }
        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-size: 14px;
            vertical-align: middle;
        }
        .table th {
            background-color: #3498db;
            color: #fff;
            font-weight: bold;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tr:hover {
            background-color: #e8f4f8;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .print-button {
            background-color: #27ae60;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .print-button:hover {
            background-color: #219653;
        }
        @media print {
            .no-print {
                display: none;
            }
            .container {
                padding: 0;
            }
            .report-header {
                margin-bottom: 10px;
            }
            .report-header img {
                max-width: 80px;
            }
            .report-header h1 {
                font-size: 20px;
            }
            .report-header p {
                font-size: 14px;
            }
            h2 { font-size: 18px; }
            h3 { font-size: 16px; }
            h4 { font-size: 14px; }
            h5 { font-size: 12px; }
            .table {
                font-size: 12px;
                box-shadow: none;
            }
            .table th, .table td {
                border: 1px solid #000;
                padding: 6px;
            }
            .table th {
                background-color: #3498db;
                color: #fff;
            }
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- ส่วนหัวรายงาน -->
        <div class="report-header">
            <img src="img/pdh.ico"" alt="โลโก้โรงพยาบาลปลวกแดง">
           
            <h1>รายงานการจองห้องผ่าตัด</h1>
            <p>โรงพยาบาลปลวกแดง</p>
            <p>วันที่สร้างรายงาน: <?php echo $report_date; ?></p>
        </div>

        <!-- ฟอร์มฟิลเตอร์ -->
        <div class="card mb-4 no-print">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="start_date">วันที่เริ่มต้น</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="end_date">วันที่สิ้นสุด</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="surgeon">แพทย์ผ่าตัด</label>
                            <select class="form-control" id="surgeon" name="surgeon">
                                <option value="">-- ทุกแพทย์ --</option>
                                <?php foreach ($surgeons as $surg): ?>
                                    <option value="<?php echo htmlspecialchars($surg['iddoctor']); ?>" <?php echo $surgeon == $surg['iddoctor'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($surg['ndoctor']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="department_or">แผนกที่จอง</label>
                            <select class="form-control" id="department_or" name="department_or">
                                <option value="">-- ทุกแผนก --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo htmlspecialchars($dept); ?>" <?php echo $department_or == $dept ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($dept); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                </form>
            </div>
        </div>

        <!-- ปุ่มพิมพ์ -->
        <button class="btn print-button no-print" onclick="window.print()">พิมพ์รายงาน</button>

        <!-- รายงาน -->
        <?php
        $current_year = null;
        $current_month = null;
        $current_surgeon = null;
        $current_department = null;

        foreach ($bookings as $booking) {
            $year = $booking['year'];
            $month = sprintf("%02d", $booking['month']);
            $surgeon_id = $booking['surgeon'];
            $surgeon_name = $booking['surgeon_name'] ?: 'ไม่ระบุ';
            $department_or = $booking['department_or'] ?: 'ไม่ระบุ';

            // แปลง JSON
            $investigations = json_decode($booking['investigations'], true);
            $blood_booking = json_decode($booking['blood_booking'], true);

            // เริ่มส่วนใหม่สำหรับปี
            if ($year !== $current_year) {
                if ($current_year !== null) {
                    echo '</tbody></table>';
                }
                $current_year = $year;
                $current_month = null;
                $current_surgeon = null;
                $current_department = null;
                ?>
                <h2>ปี <?php echo $year; ?></h2>
                <?php
            }

            // เริ่มส่วนใหม่สำหรับเดือน
            if ($month !== $current_month) {
                if ($current_month !== null) {
                    echo '</tbody></table>';
                }
                $current_month = $month;
                $current_surgeon = null;
                $current_department = null;
                ?>
                <h3>เดือน <?php echo $month; ?></h3>
                <?php
            }

            // เริ่มส่วนใหม่สำหรับแพทย์
            if ($surgeon_id !== $current_surgeon) {
                if ($current_surgeon !== null) {
                    echo '</tbody></table>';
                }
                $current_surgeon = $surgeon_id;
                $current_department = null;
                ?>
                <h4>แพทย์: <?php echo htmlspecialchars($surgeon_name); ?></h4>
                <?php
            }

            // เริ่มส่วนใหม่สำหรับแผนก
            if ($department_or !== $current_department) {
                if ($current_department !== null) {
                    echo '</tbody></table>';
                }
                $current_department = $department_or;
                ?>
                <h5>แผนก: <?php echo htmlspecialchars($department_or); ?></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>ชื่อผู้ป่วย</th>
                            <th>ประเภทการผ่าตัด</th>
                            <th>ประเภทผู้ป่วย</th>
                            <th>ยาสลบ</th>
                            <th>DX</th>
                            <th>OP</th>
                            <th>เวลาเริ่ม</th>
                            <th>เวลาสิ้นสุด</th>
                            <th>หมายเหตุ</th>
                            <th>จองหลังผ่าตัด</th>
                            <th>Investigations</th>
                            <th>ปรึกษาแผนก</th>
                            <th>จองเลือด</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
            }
            ?>
            <tr>
                <td><?php echo date('d/m/Y', strtotime($booking['start_datetime'])); ?></td>
                <td><?php echo htmlspecialchars($booking['patient_name'] ?: 'ไม่ระบุ'); ?></td>
                <td><?php echo htmlspecialchars($booking['surgery_type']); ?></td>
                <td><?php echo htmlspecialchars($booking['patient_type']); ?></td>
                <td><?php echo htmlspecialchars($booking['anesthesia']); ?></td>
                <td><?php echo htmlspecialchars($booking['dx']); ?></td>
                <td><?php echo htmlspecialchars($booking['op']); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($booking['start_datetime'])); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($booking['end_datetime'])); ?></td>
                <td><?php echo htmlspecialchars($booking['note'] ?: '-'); ?></td>
                <td><?php echo htmlspecialchars($booking['post_surgery_booking'] ?: '-'); ?></td>
                <td><?php echo is_array($investigations) ? implode(', ', $investigations) : '-'; ?></td>
                <td><?php echo htmlspecialchars($booking['consult_department'] ?: '-'); ?></td>
                <td>
                    <?php
                    if (is_array($blood_booking)) {
                        $blood_items = [];
                        if (isset($blood_booking['PRC'])) $blood_items[] = "PRC: {$blood_booking['PRC']} unit";
                        if (isset($blood_booking['FFP'])) $blood_items[] = "FFP: {$blood_booking['FFP']} unit";
                        if (isset($blood_booking['Other'])) $blood_items[] = "Other: {$blood_booking['Other']}";
                        echo implode(', ', $blood_items);
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
            </tr>
            <?php
        }

        // ปิดตารางสุดท้ายถ้ามี
        if ($current_department !== null) {
            echo '</tbody></table>';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>