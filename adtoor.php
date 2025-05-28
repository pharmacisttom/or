<?php
require 'config.php';

if (!isset($_GET['hn'])) {
    die("ไม่พบข้อมูลผู้ป่วย");
}

$hn = $_GET['hn'];

// ดึงข้อมูลผู้ป่วยจาก `opd`
$sql = "SELECT * FROM opd.opd WHERE hn = ? and regdate=date(now())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hn);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    die("ไม่พบข้อมูลผู้ป่วย");
}

// ตรวจสอบว่าผู้ป่วยมีอยู่ใน `patients` หรือยัง
$check_sql = "SELECT * FROM orpdh.patients WHERE hn = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $hn);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "<script>alert('ผู้ป่วยรายนี้ถูกเพิ่มเข้าฐานข้อมูลห้องผ่าตัดแล้ว'); window.location.href='patient_detail.php?hn=$hn';</script>";
    exit;
}

// บันทึกข้อมูลเข้า `patients`
$insert_sql = "INSERT INTO patients (hn, fullname, yage, regdate, weight, height) 
               VALUES (?, ?, ?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param(
    "ssisss", 
    $hn, 
    $patient['fullname'], 
    $patient['yage'], 
    $patient['regdate'], 
    $patient['weight'], 
    $patient['high']
);

if ($insert_stmt->execute()) {
    echo "<script>alert('เพิ่มผู้ป่วยเข้าบริการห้องผ่าตัดเรียบร้อย'); window.location.href='pt.php';</script>";
} else {
    echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล'); window.location.href='pt.php';</script>";
}
?>
