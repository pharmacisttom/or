<?php
require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // ตรวจสอบว่าแพทย์เป็นสถานะ Inactive ก่อนลบ
    $check_sql = "SELECT status FROM doctor WHERE iddoctor = $id";
    $check_result = mysqli_query($conn, $check_sql);
    $row = mysqli_fetch_assoc($check_result);

    if ($row && $row['status'] == 0) {
        $delete_sql = "DELETE FROM doctor WHERE iddoctor = $id";
        if (mysqli_query($conn, $delete_sql)) {
            echo "<script>alert('ลบแพทย์เรียบร้อยแล้ว'); window.location.href='doctor.php';</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล'); window.location.href='doctor.php';</script>";
        }
    } else {
        echo "<script>alert('ไม่สามารถลบแพทย์ที่ยัง Active ได้'); window.location.href='doctor.php';</script>";
    }

    mysqli_close($conn);
}
?>
