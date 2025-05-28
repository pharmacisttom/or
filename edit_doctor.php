<?php
require_once 'config.php';

// ตรวจสอบว่ามีค่า iddoctor ถูกส่งมาหรือไม่
if (!isset($_GET['iddoctor'])) {
    echo "ไม่พบข้อมูลแพทย์ที่ต้องการแก้ไข";
    exit;
}

$iddoctor = $_GET['iddoctor'];
$sql = "SELECT * FROM doctor WHERE iddoctor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $iddoctor);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $ndoctor = $row['ndoctor'];
    $position = $row['position'];
    $email = $row['email'];
    $status = $row['status'];
} else {
    echo "ไม่พบข้อมูลแพทย์";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลแพทย์</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>แก้ไขข้อมูลแพทย์</h2>
        <form action="update_doctor.php" method="POST">
            <input type="hidden" name="iddoctor" value="<?= $iddoctor ?>">
            <div class="mb-3">
                <label class="form-label">ชื่อแพทย์</label>
                <input type="text" class="form-control" name="ndoctor" value="<?= $ndoctor ?>" required>
            </div>
            <div class="mb-3">
    <label class="form-label">ความเชี่ยวชาญ</label>
    <select class="form-control" name="position" required>
        <option value="" disabled>-- กรุณาเลือก --</option>
        <option value="แพทย์ทั่วไป" <?= ($position == 'แพทย์ทั่วไป') ? 'selected' : '' ?>>แพทย์ทั่วไป</option>
        <option value="ศัลยแพทย์" <?= ($position == 'ศัลยแพทย์') ? 'selected' : '' ?>>ศัลยแพทย์</option>
        <option value="อายุรแพทย์" <?= ($position == 'อายุรแพทย์') ? 'selected' : '' ?>>อายุรแพทย์</option>
        <option value="กุมารแพทย์" <?= ($position == 'กุมารแพทย์') ? 'selected' : '' ?>>กุมารแพทย์</option>
        <option value="สูตินรีแพทย์" <?= ($position == 'สูตินรีแพทย์') ? 'selected' : '' ?>>สูตินรีแพทย์</option>
        <option value="จิตแพทย์" <?= ($position == 'จิตแพทย์') ? 'selected' : '' ?>>จิตแพทย์</option>
        <option value="รังสีแพทย์" <?= ($position == 'รังสีแพทย์') ? 'selected' : '' ?>>รังสีแพทย์</option>
        <option value="วิสัญญีแพทย์" <?= ($position == 'วิสัญญีแพทย์') ? 'selected' : '' ?>>วิสัญญีแพทย์</option>
        <option value="แพทย์เวชศาสตร์ฉุกเฉิน" <?= ($position == 'แพทย์เวชศาสตร์ฉุกเฉิน') ? 'selected' : '' ?>>แพทย์เวชศาสตร์ฉุกเฉิน</option>
        <option value="แพทย์ออร์โธปิดิกส์ (ศัลยกรรมกระดูก)" <?= ($position == 'แพทย์ออร์โธปิดิกส์ (ศัลยกรรมกระดูก)') ? 'selected' : '' ?>>แพทย์ออร์โธปิดิกส์ (ศัลยกรรมกระดูก)</option>
        <option value="แพทย์โรคหัวใจ" <?= ($position == 'แพทย์โรคหัวใจ') ? 'selected' : '' ?>>แพทย์โรคหัวใจ</option>
        <option value="แพทย์โรคปอด" <?= ($position == 'แพทย์โรคปอด') ? 'selected' : '' ?>>แพทย์โรคปอด</option>
        <option value="แพทย์โรคไต" <?= ($position == 'แพทย์โรคไต') ? 'selected' : '' ?>>แพทย์โรคไต</option>
        <option value="แพทย์โรคต่อมไร้ท่อ" <?= ($position == 'แพทย์โรคต่อมไร้ท่อ') ? 'selected' : '' ?>>แพทย์โรคต่อมไร้ท่อ</option>
        <option value="แพทย์โรคผิวหนัง" <?= ($position == 'แพทย์โรคผิวหนัง') ? 'selected' : '' ?>>แพทย์โรคผิวหนัง</option>
        <option value="แพทย์โสต ศอ นาสิก" <?= ($position == 'แพทย์โสต ศอ นาสิก') ? 'selected' : '' ?>>แพทย์โสต ศอ นาสิก (หู คอ จมูก)</option>
        <option value="แพทย์จักษุ" <?= ($position == 'แพทย์จักษุ') ? 'selected' : '' ?>>แพทย์จักษุ (ตา)</option>
        <option value="แพทย์เวชศาสตร์ฟื้นฟู" <?= ($position == 'แพทย์เวชศาสตร์ฟื้นฟู') ? 'selected' : '' ?>>แพทย์เวชศาสตร์ฟื้นฟู</option>
        <option value="แพทย์มะเร็งวิทยา" <?= ($position == 'แพทย์มะเร็งวิทยา') ? 'selected' : '' ?>>แพทย์มะเร็งวิทยา</option>
        <option value="แพทย์ประสาทวิทยา" <?= ($position == 'แพทย์ประสาทวิทยา') ? 'selected' : '' ?>>แพทย์ประสาทวิทยา</option>
        <option value="แพทย์ศัลยกรรมประสาท" <?= ($position == 'แพทย์ศัลยกรรมประสาท') ? 'selected' : '' ?>>แพทย์ศัลยกรรมประสาท</option>
        <option value="แพทย์เวชศาสตร์ครอบครัว" <?= ($position == 'แพทย์เวชศาสตร์ครอบครัว') ? 'selected' : '' ?>>แพทย์เวชศาสตร์ครอบครัว</option>
        <option value="แพทย์เวชศาสตร์การกีฬา" <?= ($position == 'แพทย์เวชศาสตร์การกีฬา') ? 'selected' : '' ?>>แพทย์เวชศาสตร์การกีฬา</option>
        <option value="แพทย์เวชปฏิบัติทั่วไป" <?= ($position == 'แพทย์เวชปฏิบัติทั่วไป') ? 'selected' : '' ?>>แพทย์เวชปฏิบัติทั่วไป</option>
    </select>
</div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $email ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">สถานะ</label>
                <select class="form-control" name="status">
                    <option value="1" <?= ($status == '1') ? "selected" : "" ?>>Active</option>
                    <option value="0" <?= ($status == '0') ? "selected" : "" ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="doctor_list.php" class="btn btn-secondary">กลับ</a>
        </form>
    </div>
</body>
</html>
