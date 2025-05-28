
<?php
require 'config1.php';

if (!isset($_GET['id'])) {
    die("ไม่พบข้อมูลผู้ป่วย");
}

$id = $_GET['id'];

// ดึงข้อมูลผู้ป่วยจากฐานข้อมูล
$sql = "SELECT * FROM orpdh.patients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    die("ไม่พบข้อมูลผู้ป่วย");
}

// อัปเดตข้อมูลผู้ป่วย
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $yage = $_POST['yage'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $chronic_disease = $_POST['chronic_disease'];
    $phone = $_POST['phone'];

    $update_sql = "UPDATE patients SET fullname=?, yage=?, weight=?, height=?, chronic_disease=?, phone=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("siddssi", $fullname, $yage, $weight, $height, $chronic_disease, $phone, $id);

    if ($update_stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ'); window.location.href='ptlist.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลผู้ป่วย</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>แก้ไขข้อมูลผู้ป่วย</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">ชื่อ-นามสกุล</label>
            <input type="text" class="form-control" name="fullname" value="<?= htmlspecialchars($patient['fullname'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">อายุ</label>
            <input type="number" class="form-control" name="yage" value="<?= htmlspecialchars($patient['yage'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">น้ำหนัก (kg)</label>
            <input type="number" step="0.1" class="form-control" name="weight" value="<?= htmlspecialchars($patient['weight'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">ส่วนสูง (cm)</label>
            <input type="number" step="0.1" class="form-control" name="height" value="<?= htmlspecialchars($patient['height'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">โรคประจำตัว</label>
            <textarea class="form-control" name="chronic_disease"><?= htmlspecialchars($patient['chronic_disease'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">เบอร์โทร</label>
            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($patient['phone'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">บันทึก</button>
        <a href="ptlist.php" class="btn btn-secondary">ยกเลิก</a>
    </form>
</div>
</body>
</html>
