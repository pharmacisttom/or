<?php
require 'config.php'; // เชื่อมต่อฐานข้อมูล

if (!isset($_POST['an'])) {
    echo json_encode(["status" => "error", "message" => "ไม่พบข้อมูล AN"]);
    exit;
}

$an = $_POST['an'];

// ดึงข้อมูลผู้ป่วยจาก `ipd`
$sql = "SELECT DISTINCT a.hn, a.an, b.fullname, b.yage, b.weight, b.high AS height, 
                   b.sign, b.cardid, a.regdate 
            FROM ipd.ipd a
            LEFT JOIN opd.opd b ON a.hn = b.hn AND a.regdate = b.regdate
            WHERE a.an = ? 
            AND a.regdate BETWEEN 20241001 AND CURDATE()
            AND a.datedsc = '0000-00-00'
            LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $an);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    echo json_encode(["status" => "error", "message" => "ไม่พบข้อมูลผู้ป่วย"]);
    exit;
}

$hn = $patient['hn'];

// ตรวจสอบว่าผู้ป่วยมีอยู่ใน `patients` หรือยัง
$check_sql = "SELECT * FROM orpdh.patients WHERE hn = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $hn);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(["status" => "warning", "message" => "ผู้ป่วยรายนี้ถูกเพิ่มเข้าฐานข้อมูลห้องผ่าตัดแล้ว"]);
    exit;
}

// บันทึกข้อมูลเข้า `patients`
$insert_sql = "INSERT INTO orpdh.patients (hn, an, fullname, yage, regdate, weight, height) 
               VALUES (?, ?, ?, ?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param(
    "sssisss", 
    $hn, 
    $an, 
    $patient['fullname'], 
    $patient['yage'], 
    $patient['regdate'], 
    $patient['weight'], 
    $patient['height']
);

if ($insert_stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "เพิ่มผู้ป่วยเข้าบริการห้องผ่าตัดเรียบร้อย", "redirect" => "pt.php"]);
} else {
    echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในการบันทึกข้อมูล"]);
}
?>

