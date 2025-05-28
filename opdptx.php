<?php
require 'config.php';

$searchTerm = "";
$patients = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST["search"];
    $sql = "SELECT * FROM opd.opd WHERE fullname  LIKE ? OR cardid LIKE ? OR hn LIKE ? and regdate = date(now())";
    $stmt = $conn->prepare($sql);
    $likeSearch = "%$searchTerm%";
    $stmt->bind_param("sss", $likeSearch, $likeSearch, $likeSearch);
    $stmt->execute();
    $result = $stmt->get_result();
    $patients = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาผู้ป่วย</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">ค้นหาผู้ป่วย</h2>
    <form method="POST" class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="ค้นหาด้วยชื่อ, หมายเลขบัตร, หรือรหัสผู้ป่วย" value="<?= htmlspecialchars($searchTerm) ?>" required>
        <button class="btn btn-primary" type="submit">ค้นหา</button>
    </form>

    <?php if (!empty($patients)): ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>รหัสผู้ป่วย</th>
                    <th>ชื่อ</th>
                    <th>หมายเลขบัตร</th>
                    <th>วันที่เข้ารับบริการ</th>
                    <th>ดูข้อมูลเพิ่มเติม</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= htmlspecialchars($patient['hn']) ?></td>
                        <td><?= htmlspecialchars($patient['fullname']) ?></td>
                        <td><?= htmlspecialchars($patient['cardid']) ?></td>
                        <td><?= htmlspecialchars($patient['regdate']) ?></td>
                        <td><a href="patient_detail.php?hn=<?= $patient['hn'] ?>" class="btn btn-info btn-sm">ดูข้อมูล</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p class="text-danger">ไม่พบข้อมูลผู้ป่วย</p>
    <?php endif; ?>
</div>
</body>
</html>


