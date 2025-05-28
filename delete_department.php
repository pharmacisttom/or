<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete the department from the database
    $sql = "DELETE FROM departments WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('ลบแผนกเรียบร้อยแล้ว'); window.location.href='departments.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
