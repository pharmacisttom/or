<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $idnurse = mysqli_real_escape_string($conn, $_GET['id']);

    // Check if the nurse exists in the database
    $sql = "SELECT * FROM nurse WHERE idnurse = '$idnurse'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Proceed with deletion
        $deleteSql = "DELETE FROM nurse WHERE idnurse = '$idnurse'";
        if (mysqli_query($conn, $deleteSql)) {
            echo "<script>alert('ลบพยาบาลเรียบร้อยแล้ว'); window.location.href='nurse.php';</script>";
        } else {
            echo "Error: " . $deleteSql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('ไม่พบพยาบาลที่ต้องการลบ'); window.location.href='nurse.php';</script>";
    }
} else {
    echo "<script>alert('ไม่พบรหัสพยาบาล'); window.location.href='nurse.php';</script>";
}
?>
