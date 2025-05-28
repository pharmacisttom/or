<?php
require_once 'config.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $iddoctor = mysqli_real_escape_string($conn, $_POST['iddoctor']);
    $ndoctor = mysqli_real_escape_string($conn, $_POST['ndoctor']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $status = '1'; // ตั้งค่าเริ่มต้นเป็น Active
    $dateupdate = date('Y-m-d H:i:s');

    $sql = "INSERT INTO doctor (iddoctor, ndoctor, position, email, status, dateupdate) VALUES ('$iddoctor', '$ndoctor', '$position', '$email', '$status', '$dateupdate')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('เพิ่มแพทย์สำเร็จ!'); window.location.href='doctor.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด: " . mysqli_error($conn) . "');</script>";
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มแพทย์</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>เพิ่มแพทย์</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label">รหัสแพทย์</label>
                <input type="text" class="form-control" name="iddoctor" required>
            </div>
            <div class="mb-3">
                <label class="form-label">ชื่อแพทย์</label>
                <input type="text" class="form-control" name="ndoctor" required>
            </div>
            <div class="mb-3">
                <label class="form-label">ตำแหน่ง</label>
                <select class="form-control" name="position" required>
                    <option value="" disabled selected>-- กรุณาเลือก --</option>
                    <option value="แพทย์ทั่วไป">แพทย์ทั่วไป</option>
                    <option value="ศัลยแพทย์">ศัลยแพทย์</option>
                    <option value="อายุรแพทย์">อายุรแพทย์</option>
                    <option value="กุมารแพทย์">กุมารแพทย์</option>
                    <option value="สูตินรีแพทย์">สูตินรีแพทย์</option>
                    <option value="จิตแพทย์">จิตแพทย์</option>
                    <option value="รังสีแพทย์">รังสีแพทย์</option>
                    <option value="วิสัญญีแพทย์">วิสัญญีแพทย์</option>
                    <option value="แพทย์เวชศาสตร์ฉุกเฉิน">แพทย์เวชศาสตร์ฉุกเฉิน</option>
                    <option value="แพทย์ออร์โธปิดิกส์ (ศัลยกรรมกระดูก)">แพทย์ออร์โธปิดิกส์ (ศัลยกรรมกระดูก)</option>
                    <option value="แพทย์โรคหัวใจ">แพทย์โรคหัวใจ</option>
                    <option value="แพทย์โรคปอด">แพทย์โรคปอด</option>
                    <option value="แพทย์โรคไต">แพทย์โรคไต</option>
                    <option value="แพทย์โรคต่อมไร้ท่อ">แพทย์โรคต่อมไร้ท่อ</option>
                    <option value="แพทย์โรคผิวหนัง">แพทย์โรคผิวหนัง</option>
                    <option value="แพทย์โสต ศอ นาสิก">แพทย์โสต ศอ นาสิก (หู คอ จมูก)</option>
                    <option value="แพทย์จักษุ">แพทย์จักษุ (ตา)</option>
                    <option value="แพทย์เวชศาสตร์ฟื้นฟู">แพทย์เวชศาสตร์ฟื้นฟู</option>
                    <option value="แพทย์มะเร็งวิทยา">แพทย์มะเร็งวิทยา</option>
                    <option value="แพทย์ประสาทวิทยา">แพทย์ประสาทวิทยา</option>
                    <option value="แพทย์ศัลยกรรมประสาท">แพทย์ศัลยกรรมประสาท</option>
                    <option value="แพทย์เวชศาสตร์ครอบครัว">แพทย์เวชศาสตร์ครอบครัว</option>
                    <option value="แพทย์เวชศาสตร์การกีฬา">แพทย์เวชศาสตร์การกีฬา</option>
                    <option value="แพทย์เวชปฏิบัติทั่วไป">แพทย์เวชปฏิบัติทั่วไป</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="doctor.php" class="btn btn-secondary">ย้อนกลับ</a>
        </form>
    </div>
</body>
</html>