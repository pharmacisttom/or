
<?php
require 'config2.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

$search = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($search)) {
    $sql = "SELECT DISTINCT a.hn, a.an, b.fullname, b.yage, b.weight, b.high, 
                   b.sign, b.cardid, a.regdate 
            FROM ipd.ipd a
            LEFT JOIN opd.opd b ON a.hn = b.hn AND a.regdate = b.regdate
            WHERE (a.an LIKE ? OR a.hn LIKE ?) 
            AND a.regdate BETWEEN 20241001 AND CURDATE()
            AND a.datedsc = '0000-00-00'
            LIMIT 10";

    $stmt = $conn->prepare($sql);
    $param = "%{$search}%";
    $stmt->bind_param("ss", $param, $param);
    $stmt->execute();
    $result = $stmt->get_result();

    $patients = [];
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }

    echo json_encode($patients);
}
?>
