<div class="content-wrapper">
    <section class="content-header">
        <h1>
            แผนกในระบบ
            <small>(PDH smart Department)</small>
        </h1>
    </section>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h4 class="h3 mb-0 text-gray-800">รายชื่อแผนก</h4>
            <a href="./adddepartment.php" type="button" class="btn btn-success">+ เพิ่มแผนก</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">รายชื่อแผนกในระบบ</h3>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">ข้อมูลแผนก ณ วันที่ <?php echo date("d/m/Y"); ?></li>
            </ol>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>รหัสแผนก</th>
                                <th>ชื่อแผนก</th>
                                <th>คำอธิบาย</th> <!-- Description Column -->
                                <th>สถานะ</th>
                                <th>วันที่สร้าง</th> <!-- Created Date Column -->
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once 'config.php'; // ไฟล์เชื่อมต่อฐานข้อมูล
                            
                            // Fetch departments
                            $sql = "SELECT * FROM departments ORDER BY datecreated DESC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['department_name']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td> <!-- Display department description -->
                                    <td>
                                        <?= ($row['status'] == '1') ? "<b style='color:green'>Active</b>" : "<b style='color:red'>Inactive</b>"; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['datecreated']) ?></td> <!-- Display the created date -->
                                    <td>
                                        <a href="edit_department.php?id=<?= $row['id'] ?>" class="btn btn-success">
                                            แก้ไข
                                        </a>

                                        <?php if ($row['status'] == '0') : ?>
                                            <a href="delete_department.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบแผนกนี้?');">
                                                ลบ
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

