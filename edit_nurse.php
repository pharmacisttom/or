<?php
require_once 'config.php';

if (isset($_GET['idnurse'])) {
    $idnurse = mysqli_real_escape_string($conn, $_GET['idnurse']);
    $sql = "SELECT * FROM nurse WHERE idnurse = '$idnurse'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $nnurse = mysqli_real_escape_string($conn, $_POST['nnurse']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $dateupdate = date("Y-m-d H:i:s"); // Set the current date and time for update

    // Update the nurse data in the database
    $sql = "UPDATE nurse SET nnurse='$nnurse', position='$position', email='$email', department='$department', status='$status', dateupdate='$dateupdate' WHERE idnurse='$idnurse'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('ข้อมูลพยาบาลอัปเดตเรียบร้อย'); window.location.href='nurse.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลพยาบาล</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>แก้ไขข้อมูลพยาบาล</h2>
        <form action="edit_nurse.php?idnurse=<?= $row['idnurse'] ?>" method="POST">
            <div class="mb-3">
                <label for="nnurse" class="form-label">ชื่อพยาบาล</label>
                <input type="text" class="form-control" id="nnurse" name="nnurse" value="<?= htmlspecialchars($row['nnurse']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">ตำแหน่ง</label>
                <select class="form-control" id="position" name="position" required>
                    <option value="1" <?= $row['position'] == '1' ? 'selected' : '' ?>>พยาบาลวิชาชีพ</option>
                    <option value="2" <?= $row['position'] == '2' ? 'selected' : '' ?>>พยาบาลเทคนิค</option>
                    <option value="3" <?= $row['position'] == '3' ? 'selected' : '' ?>>ผู้ช่วยเหลือคนไข้</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">แผนกที่ทำงาน</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="ห้องฉุกเฉิน" <?= $row['department'] == 'ห้องฉุกเฉิน' ? 'selected' : '' ?>>ห้องฉุกเฉิน</option>
                    <option value="ผู้ป่วยใน" <?= $row['department'] == 'ผู้ป่วยใน' ? 'selected' : '' ?>>ผู้ป่วยใน</option>
                    <option value="ICU" <?= $row['department'] == 'ICU' ? 'selected' : '' ?>>ICU</option>
                    <option value="ห้องคลอด" <?= $row['department'] == 'ห้องคลอด' ? 'selected' : '' ?>>ห้องคลอด</option>
                    <option value="ตึกจันทรประสิทธิ์" <?= $row['department'] == 'ตึกจันทรประสิทธิ์' ? 'selected' : '' ?>>ตึกจันทรประสิทธิ์</option>
                    <option value="แอดมิดเซ็นเตอร์" <?= $row['department'] == 'แอดมิดเซ็นเตอร์' ? 'selected' : '' ?>>แอดมิดเซ็นเตอร์</option>
                    <option value="OPD" <?= $row['department'] == 'OPD' ? 'selected' : '' ?>>OPD</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1" <?= $row['status'] == '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $row['status'] == '0' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">อัปเดต</button>
            <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
        </form>
    </div>
</body>
</html>
