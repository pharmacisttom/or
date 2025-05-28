<div class="content-wrapper">
    <section class="content-header">
        <h1>
            พยาบาลในระบบจองคิวห้องผ่าตัด
            <small>(PDH smart OR)</small>
        </h1>
    </section>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h4 class="h3 mb-0 text-gray-800">รายชื่อพยาบาล</h4>
            <a href="./addnurse.php" class="btn btn-success">+ เพิ่มพยาบาล</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">รายชื่อพยาบาลที่ใช้ห้องผ่าตัด</h3>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">ข้อมูลพยาบาล ณ วันที่ <?php echo date("d/m/Y"); ?></li>
            </ol>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>รหัสพยาบาล</th>
                                <th>ชื่อพยาบาล</th>
                                <th>ตำแหน่ง</th>
                                <th>Email</th>
                                <th>แผนก</th> <!-- Added department column -->
                                <th>สถานะ</th>
                                <th>วันที่อัปเดต</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once 'config.php';
                            $sql = "SELECT * FROM nurse ORDER BY dateupdate DESC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Map position values to names
                                switch ($row['position']) {
                                    case '1':
                                        $positionName = 'พยาบาลวิชาชีพ';
                                        break;
                                    case '2':
                                        $positionName = 'พยาบาลเทคนิค';
                                        break;
                                    case '3':
                                        $positionName = 'ผู้ช่วยเหลือคนไข้';
                                        break;
                                    default:
                                        $positionName = 'ไม่ระบุ';
                                }
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['idnurse']) ?></td>
                                    <td><?= htmlspecialchars($row['nnurse']) ?></td>
                                    <td><?= $positionName ?></td> <!-- Display position name -->
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['department']) ?></td> <!-- Displaying department -->
                                    <td>
                                        <?= ($row['status'] == '1') ? "<b style='color:green'>Active</b>" : "<b style='color:red'>Inactive</b>"; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['dateupdate']) ?></td>
                                    <td>
                                        <a href="edit_nurse.php?idnurse=<?= $row['idnurse'] ?>" class="btn btn-success">แก้ไข</a>

                                        <?php if ($row['status'] == '0') : ?>
                                            <a href="delete_nurse.php?id=<?= $row['idnurse'] ?>" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบพยาบาลนี้?');">
                                                ลบ
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

