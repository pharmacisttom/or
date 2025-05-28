<?php
// fetchEvent.php
require_once('bdd.php');

if (isset($_POST['id'])) {
  $id = (int)$_POST['id'];
  $sql = "SELECT * FROM surgery_bookings WHERE id = :id";
  $query = $bdd->prepare($sql);
  $query->bindParam(':id', $id, PDO::PARAM_INT);
  $query->execute();
  $data = $query->fetch(PDO::FETCH_ASSOC);

  if ($data) {
    echo json_encode(['success' => true, 'data' => $data]);
  } else {
    echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'ไม่พบ ID']);
}
?>