<?php
require_once('pdo.php');

if (isset($_POST['doctorId'])) {
    $doctorId = $_POST['doctorId'];

    $sql = "SELECT ndoctor FROM doctor WHERE iddoctor = :id";
    $query = $bdd->prepare($sql);
    $query->execute([':id' => $doctorId]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['status' => 'success', 'doctorName' => 'แพทย์: ' . $result['ndoctor']]);
    } else {
        // Specific error message if the ID doesn't exist:
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบแพทย์ที่มี ID: ' . $doctorId]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Doctor ID not provided']);
}
?>
