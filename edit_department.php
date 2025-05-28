<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch the department data
    $sql = "SELECT * FROM departments WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Update the department in the database
    $sql = "UPDATE departments 
            SET department_name = '$department_name', description = '$description', status = '$status'
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('อัปเดตแผนกเรียบร้อยแล้ว'); window.location.href='departments.php';</script>";
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
    <title>แก้ไขแผนก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>แก้ไขแผนก</h2>
        <form action="edit_department.php?id=<?= $row['id'] ?>" method="POST">
            <div class="mb-3">
                <label for="department_name" class="form-label">ชื่อแผนก</label>
                <input type="text" class="form-control" id="department_name" name="department_name" value="<?= htmlspecialchars($row['department_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">คำอธิบาย</label>
                <textarea class="form-control" id="description" name="description"><?= htmlspecialchars($row['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1" <?= $row['status'] == '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $row['status'] == '0' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="departments.php" class="btn btn-secondary">ยกเลิก</a>
        </form>
    </div>
</body>
</html>
