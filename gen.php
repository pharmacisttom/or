<?php
$hashed_password = ''; // กำหนดค่าเริ่มต้น
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])) {
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างรหัสผ่าน Hashed - โรงพยาบาลปลวกแดง</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'TH Sarabun New', Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .card-header {
            background-color: #3498db;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            border-radius: 8px 8px 0 0;
            padding: 15px;
        }
        .card-body {
            padding: 20px;
        }
        .form-group label {
            font-weight: bold;
            font-size: 16px;
        }
        .btn-generate {
            background-color: #3498db;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
        }
        .btn-generate:hover {
            background-color: #2980b9;
        }
        .result {
            background-color: #f9f9f9;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            word-wrap: break-word;
            position: relative;
        }
        .copy-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #27ae60;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .copy-button:hover {
            background-color: #219653;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                สร้างรหัสผ่าน Hashed
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="password">รหัสผ่าน</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="กรอกรหัสผ่านที่ต้องการ" required>
                    </div>
                    <button type="submit" class="btn btn-generate">สร้าง Hashed Password</button>
                </form>

                <?php if ($hashed_password): ?>
                    <div class="result">
                        <strong>Hashed Password:</strong><br>
                        <?php echo htmlspecialchars($hashed_password); ?>
                        <button class="copy-button" onclick="copyToClipboard()">คัดลอก</button>
                    </div>
                <?php endif; ?>
                <p class="text-muted mt-2">คัดลอก hashed password เพื่อใช้ใน SQL INSERT สำหรับตาราง users</p>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const text = <?php echo json_encode($hashed_password); ?>;
            if (text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('คัดลอก Hashed Password เรียบร้อยแล้ว');
                }).catch(() => {
                    alert('ไม่สามารถคัดลอกได้ กรุณาคัดลอกด้วยตนเอง');
                });
            } else {
                alert('ไม่มี Hashed Password ให้คัดลอก');
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>