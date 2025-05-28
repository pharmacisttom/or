<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $idnurse = mysqli_real_escape_string($conn, $_POST['idnurse']);
    $nnurse = mysqli_real_escape_string($conn, $_POST['nnurse']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $dateupdate = date("Y-m-d H:i:s"); // Set the current date and time for update

    // Insert the new nurse data into the database
    $sql = "INSERT INTO nurse (idnurse, nnurse, position, email, department, status, dateupdate) 
            VALUES ('$idnurse', '$nnurse', '$position', '$email', '$department', '$status', '$dateupdate')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('เพิ่มพยาบาลเรียบร้อยแล้ว'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มพยาบาล</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>เพิ่มพยาบาล</h2>
        <form action="addnurse.php" method="POST">
            <div class="mb-3">
                <label for="idnurse" class="form-label">รหัสพยาบาล (เลขใบประกอบวิชาชีพ หรือเลขบัตรประชาชน)</label>
                <input type="text" class="form-control" id="idnurse" name="idnurse" required>
            </div>
            <div class="mb-3">
                <label for="nnurse" class="form-label">ชื่อพยาบาล</label>
                <input type="text" class="form-control" id="nnurse" name="nnurse" required>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">ตำแหน่ง</label>
                <select class="form-control" id="position" name="position" required>
                    <option value="">เลือกตำแหน่ง</option> <!-- Empty option as default -->
                    <option value="1">พยาบาลวิชาชีพ</option>
                    <option value="2">พยาบาลเทคนิค</option>
                    <option value="3">ผู้ช่วยเหลือคนไข้</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">แผนกที่ทำงาน</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="">เลือกแผนก</option> <!-- Empty option as default -->
                    <option value="ห้องฉุกเฉิน">ห้องฉุกเฉิน</option>
                    <option value="ผู้ป่วยใน">ผู้ป่วยใน</option>
                    <option value="ICU">ICU</option>
                    <option value="ห้องคลอด">ห้องคลอด</option>
                    <option value="ตึกจันทรประสิทธิ์">ตึกจันทรประสิทธิ์</option>
                    <option value="แอดมิดเซ็นเตอร์">แอดมิดเซ็นเตอร์</option>
                    <option value="OPD">OPD</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
        </form>
    </div>
</body>
</html>

