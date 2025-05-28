<?php
require 'config.php';

$searchTerm = isset($_GET["search"]) ? $_GET["search"] : '';

if ($searchTerm !== '') {
    $sql = "SELECT * FROM opd.opd WHERE (fullname LIKE ? OR cardid LIKE ? OR hn LIKE ?) AND regdate = DATE(NOW())";
    $stmt = $conn->prepare($sql);
    $likeSearch = "%$searchTerm%";
    $stmt->bind_param("sss", $likeSearch, $likeSearch, $likeSearch);
    $stmt->execute();
    $result = $stmt->get_result();
    $patients = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($patients);
} else {
    echo json_encode([]);
}
?>
