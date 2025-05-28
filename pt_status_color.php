<?php
include("bdd.php"); // ดึงข้อมูลจากฐานข้อมูลจริง

function getStatusClassByCode($code) {
    switch ($code) {
        case '1':
            return 'btn-warning'; // รอผ่าตัด
        case '2':
            return 'btn-success'; // ผ่าตัดแล้ว
        case '3':
            return 'btn-primary'; // เลื่อนผ่าตัด
        case '4':
            return 'btn-danger'; // ยกเลิกผ่าตัด
        case '5':
            return 'btn-info'; // นัดผ่าตัด
        default:
            return 'btn-secondary'; // ไม่ระบุ
    }
}

$stmt = $bdd->prepare("SELECT hn, fullname, pp FROM patients ORDER BY id DESC");
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>HN</th>
      <th>ชื่อ</th>
      <th>สถานะ</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($patients as $patient): ?>
      <tr>
        <td><?php echo htmlspecialchars($patient['hn']); ?></td>
        <td><?php echo htmlspecialchars($patient['fullname']); ?></td>
        <td>
          <button class="btn <?php echo getStatusClassByCode($patient['pp']); ?>">
            <?php
            $labels = [
              "1" => "รอผ่าตัด",
              "2" => "ผ่าตัดแล้ว",
              "3" => "เลื่อนผ่าตัด",
              "4" => "ยกเลิกผ่าตัด",
              "5" => "นัดผ่าตัด"
            ];
            echo $labels[$patient['pp']] ?? "ไม่ระบุ";
            ?>
          </button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
