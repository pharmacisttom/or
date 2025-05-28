<?php
require_once('pdo.php');

if (isset($_POST['nurseId'])) {
    $nurseId = $_POST['nurseId'];

    $sql = "SELECT nnurse FROM nurse WHERE idnurse = :id";
    $query = $bdd->prepare($sql);
    $query->execute([':id' => $nurseId]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['status' => 'success', 'nurseName' =>'ผู้จอง: '. $result['nnurse']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'nurse not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'nurse ID not provided']);
}
?>
