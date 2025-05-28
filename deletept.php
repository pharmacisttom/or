<?php
require 'config1.php';

if (!isset($_GET['id'])) {
    die("ไม่พบข้อมูล");
}

$id = $_GET['id'];
$sql = "DELETE FROM orpdh.patients WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ptlist.php");
    exit();
} else {
    echo "เกิดข้อผิดพลาด!";
}
?>
