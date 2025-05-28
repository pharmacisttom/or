<?php
require 'config1.php';

// ดึงข้อมูลผู้ป่วยทั้งหมด
$sql = "SELECT * FROM patients ORDER BY regdate DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html> 
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายชื่อผู้ป่วย</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="icon" href="img/pdh.ico" type="image/ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">รายชื่อผู้ป่วย</h2>
    <a href="ss.php" class="btn btn-primary mb-3">เพิ่มผู้ป่วยใหม่</a>

    <input type="text" id="searchInput" class="form-control mb-3" placeholder="ค้นหาผู้ป่วย...">

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>HN</th>
                <th>AN</th>
                <th>ชื่อ-สกุล</th>
                <th>อายุ</th>
                <th>น้ำหนัก</th>
                <th>ส่วนสูง</th>
                <th>โรคเรื้อรัง</th>
                <th>เบอร์โทร</th>
                <th>วันที่ลงทะเบียน</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody id="patientTable">
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= isset($row['hn']) ? htmlspecialchars($row['hn']) : "" ?></td>
                <td><?= isset($row['an']) ? htmlspecialchars($row['an']) : "" ?></td>
                <td><?= isset($row['fullname']) ? htmlspecialchars($row['fullname']) : "" ?></td>
                <td><?= isset($row['yage']) ? htmlspecialchars($row['yage']) : "" ?></td>
                <td><?= isset($row['weight']) ? htmlspecialchars($row['weight']) : "" ?></td>
                <td><?= isset($row['height']) ? htmlspecialchars($row['height']) : "" ?></td>
                <td><?= isset($row['chronic_disease']) ? htmlspecialchars($row['chronic_disease']) : "" ?></td>
                <td><?= isset($row['phone']) ? htmlspecialchars($row['phone']) : "" ?></td>
                <td><?= isset($row['regdate']) ? htmlspecialchars($row['regdate']) : "" ?></td>
                <td>
                    <a href="addpt.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                    <a href="deletept.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบผู้ป่วยนี้?');">ลบ</a>
                    <a href="index.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">จองห้องผ่าตัด</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#patientTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

</body>
</html>
