<?php
require_once('pdo.php');

if (isset($_POST['departmentId'])) {
    $departmentId = $_POST['departmentId'];

    $sql = "SELECT department_name FROM departments WHERE id = :id";
    $query = $bdd->prepare($sql);
    $query->execute([':id' => $departmentId]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['status' => 'success', 'departmentName' => 'แผนก: '.$result['department_name']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Department not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Department ID not provided']);
}
?>
