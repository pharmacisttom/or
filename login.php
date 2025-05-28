<?php
session_start();

// ตรวจสอบว่าไฟล์ db_connect.php มีอยู่
if (!file_exists(__DIR__ . '/db_connect.php')) {
    die("ข้อผิดพลาด: ไม่พบไฟล์ db_connect.php ใน " . __DIR__);
}

require_once(__DIR__ . '/db_connect.php');

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน';
    } else {
        try {
            $sql = "SELECT id, username, password, role, full_name FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true); // ป้องกัน session fixation
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                header('Location: index.php');
                exit;
            } else {
                $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            }
        } catch (PDOException $e) {
            $error = 'ข้อผิดพลาดฐานข้อมูล: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจองห้องผ่าตัด โรงพยาบาลปลวกแดง</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', Arial, sans-serif;
            background-color: #E8F5E9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 450px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .login-container img.logo {
            max-width: 200px;
            width: 100%;
            height: auto;
            margin-bottom: 25px;
            animation: fadeIn 1.5s ease-in-out;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 26px;
            font-weight: 700;
        }
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #4CAF50;
            font-size: 18px;
        }
        .form-group input {
            padding-left: 40px;
            height: 45px;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            border-color: #388E3C;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
            outline: none;
        }
        .form-group label {
            font-weight: bold;
            color: #2c3e50;
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }
        .btn-login {
            background-color: #4CAF50;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        .btn-login:hover {
            background-color: #388E3C;
            transform: scale(1.05);
        }
        .btn-login:disabled {
            background-color: #B0BEC5;
            cursor: not-allowed;
        }
        .btn-login .spinner {
            display: none;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 3px solid #fff;
            border-top: 3px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        .btn-login.loading .spinner {
            display: block;
        }
        .btn-login.loading span {
            visibility: hidden;
        }
        .error {
            color: #D32F2F;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
            background-color: #FFEBEE;
            padding: 8px;
            border-radius: 5px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
                max-width: 90%;
            }
            .login-container img.logo {
                max-width: 150px;
            }
            .login-container h2 {
                font-size: 22px;
            }
            .form-group input {
                height: 40px;
                font-size: 14px;
            }
            .btn-login {
                padding: 10px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
    <img src="img/pdh.ico" alt="โลโก้โรงพยาบาลปลวกแดง" class="logo">
        <h2>ระบบจองห้องผ่าตัด<br>โรงพยาบาลปลวกแดง</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้</label>
                <i class="fas fa-user"></i>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <i class="fas fa-lock"></i>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-login" id="loginButton">
                <span>ล็อกอิน</span>
                <div class="spinner"></div>
            </button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function() {
                var $button = $('#loginButton');
                $button.addClass('loading').prop('disabled', true);
                setTimeout(function() {
                    $button.removeClass('loading').prop('disabled', false);
                }, 2000); // จำลองการโหลด 2 วินาที
            });
        });
    </script>
</body>
</html>

