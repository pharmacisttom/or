<?php
require 'config1.php';

if (!isset($_GET['hn'])) {
    die("ไม่พบข้อมูล");
}

$patient_id = $_GET['hn'];

// ดึงข้อมูลผู้ป่วย
$sql = "SELECT * FROM opd WHERE hn = ? and regdate = date(now())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    die("ไม่พบข้อมูลผู้ป่วย");
}

// // ดึงข้อมูลการแอดมิต
// $sql_admit = "SELECT * FROM ipd.ipd WHERE hn = ?";
// $stmt = $conn->prepare($sql_admit);
// $stmt->bind_param("s", $patient_id);
// $stmt->execute();
// $admit_result = $stmt->get_result();
// $admissions = $admit_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลผู้ป่วย</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>ข้อมูลผู้ป่วย</h2>
    <table class="table table-bordered">
        <tr><th>รหัสผู้ป่วย</th><td><?= htmlspecialchars($patient['hn']) ?></td></tr>
        <tr><th>ชื่อ</th><td><?= htmlspecialchars($patient['fullname']) ?></td></tr>
        <tr><th>หมายเลขบัตร</th><td><?= htmlspecialchars($patient['cardid']) ?></td></tr>
        <tr><th>วันที่เข้ารับบริการ</th><td><?= htmlspecialchars($patient['regdate']) ?></td></tr>
        <tr><th>น้ำหนัก</th><td><?= htmlspecialchars($patient['weight']) ?></td></tr>
        <tr><th>ส่วนสูง</th><td><?= htmlspecialchars($patient['high']) ?></td></tr>
        <tr><th>วันที่เข้ารับบริการ</th><td><?= htmlspecialchars($patient['regdate']) ?></td></tr>
        <tr><th>อาการ</th><td><?= htmlspecialchars($patient['sign']) ?></td></tr>
    </table>

    <!-- <h3 class="mt-4">ประวัติการแอดมิต</h3>
    <?php if (!empty($admissions)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>คลินิก</th>
                    <th>วันที่แอดมิต</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admissions as $admit): ?>
                    <tr>
                        <td><?= htmlspecialchars($admit['clinic']) ?></td>
                        <td><?= htmlspecialchars($admit['admit_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-warning">ไม่มีประวัติการแอดมิต</p>
    <?php endif; ?> -->

    <a href="index.php" class="btn btn-secondary mt-3">กลับ</a>
    <a href="adtoor.php?hn=<?= urlencode($patient['hn']) ?>" class="btn btn-success mt-3">เพิ่มเข้าระบบห้องผ่าตัด</a>
</div>
</body>
</html>
