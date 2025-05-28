<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Insert new department into the database
    $sql = "INSERT INTO departments (department_name, description, status) 
            VALUES ('$department_name', '$description', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('เพิ่มแผนกเรียบร้อยแล้ว'); window.location.href='departments.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มแผนก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>เพิ่มแผนก</h2>
        <form action="adddepartment.php" method="POST">
            <div class="mb-3">
                <label for="department_name" class="form-label">ชื่อแผนก</label>
                <input type="text" class="form-control" id="department_name" name="department_name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">คำอธิบาย</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="departments.php" class="btn btn-secondary">ยกเลิก</a>
        </form>
    </div>
</body>
</html>
