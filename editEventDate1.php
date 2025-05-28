<?php

// Connexion à la base de données
require_once('bdd.php');

// ตรวจสอบว่ามีข้อมูลส่งมาจาก AJAX หรือไม่
if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])) {
    
    $id = $_POST['Event'][0];       // ID ของเหตุการณ์
    $start = $_POST['Event'][1];    // วันเวลาเริ่มต้นใหม่
    $end = $_POST['Event'][2];      // วันเวลาสิ้นสุดใหม่

    // เตรียมคำสั่ง SQL เพื่ออัปเดตวันที่ในตาราง surgery_bookings
    $sql = "UPDATE surgery_bookings SET start_datetime = :start, end_datetime = :end WHERE id = :id";
    
    // ตั้งค่า charset เป็น UTF-8
    $bdd->exec("SET NAMES utf8");
    
    // เตรียม query
    $query = $bdd->prepare($sql);
    if ($query === false) {
        print_r($bdd->errorInfo());
        die('Erreur prepare');
    }
    
    // Bind ค่าพารามิเตอร์
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':start', $start, PDO::PARAM_STR);
    $query->bindParam(':end', $end, PDO::PARAM_STR);
    
    // รัน query
    $sth = $query->execute();
    if ($sth === false) {
        print_r($query->errorInfo());
        die('Erreur execute');
    } else {
        die('OK'); // ส่ง "OK" กลับไปยัง AJAX เมื่อสำเร็จ
    }

} else {
    die('Missing event data'); // ถ้าข้อมูลไม่ครบ
}

// ไม่ต้อง redirect เพราะใช้ AJAX
// header('Location: ' . $_SERVER['HTTP_REFERER']);

?>