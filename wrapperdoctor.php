
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            แพทย์ในระบบจองคิวห้องผ่าตัด
            <small>(PDH smart OR)</small>
        </h1>
    </section>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h4 class="h3 mb-0 text-gray-800">รายชื่อแพทย์</h4>
            <a href="./addoctor.php" type="button" class="btn btn-success">+ เพิ่มแพทย์</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">รายชื่อแพทย์ที่ใช้ห้องผ่าตัด</h3>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">ข้อมูลแพทย์ ณ วันที่ <?php echo date("d/m/Y"); ?></li>
            </ol>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>รหัสแพทย์</th>
                                <th>ชื่อแพทย์</th>
                                <th>ตำแหน่ง</th>
                                <th>Email</th>
                                <th>สถานะ</th>
                                <th>วันที่อัปเดต</th>
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once 'config.php'; // ไฟล์เชื่อมต่อฐานข้อมูล
                            $sql = "SELECT * FROM doctor ORDER BY dateupdate DESC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['iddoctor']) ?></td>
                                    <td><?= htmlspecialchars($row['ndoctor']) ?></td>
                                    <td><?= htmlspecialchars($row['position']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td>
                                        <?= ($row['status'] == '1') ? "<b style='color:green'>Active</b>" : "<b style='color:red'>Inactive</b>"; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['dateupdate']) ?></td>
                                    <td>
                                    <a href="edit_doctor.php?iddoctor=<?= $row['iddoctor'] ?>" class="btn btn-success">
                                      แก้ไข
                                      </a>

                                    <?php if ($row['status'] == '0') : ?>
                                    <a href="delete_doctor.php?id=<?= $row['iddoctor'] ?>" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบแพทย์นี้?');">
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

