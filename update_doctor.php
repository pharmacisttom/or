<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iddoctor = $_POST['iddoctor'];
    $ndoctor = $_POST['ndoctor'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    $sql = "UPDATE doctor SET ndoctor=?, position=?, email=?, status=?, dateupdate=NOW() WHERE iddoctor=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $ndoctor, $position, $email, $status, $iddoctor);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ'); window.location='doctor.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
