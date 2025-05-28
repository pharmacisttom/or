<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ผู้ป่วยในระบบจองคิวห้องผ่าตัด
            <small>(PDH smart OR)</small>
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
        </ol> -->
    </section>
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h4 class="h3 mb-0 text-gray-800">กิจกรรมที่เกี่ยวข้องกับผู้ป่วย</h4>
            <a href="./opdpt.php" type="button" class="btn btn-success">+เพิ่มคนไข้จากเคสOPD</a> 
            <a href="./ipdpt.php" type="button" class="btn btn-warning">+เพิ่มคนไข้จากเคสiPD</a> 
        </div>
        <!-- <p class="mb-4"> ข้อมูลในการกรองมาจากข้อมูล opd.opd และ ipd.ipd </a>.</p> -->


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">รายชื่อผู้ป่วยที่รับบริการห้องผ่าตัด(คนไข้ยกเลิกผ่าตัด)</h3>
            </div>
            <a href="./pt.php" type="button" class="btn btn-info">คนไข้ทั้งหมด</a>
            <a href="./pt1.php" type="button" class="btn btn-info">ยังไม่ได้ระบุสถานะ</a> 
            <a href="./pt2.php" type="button" class="btn btn-warning">คนไข้ที่รอผ่าตัด</a> 
            <a href="./pt3.php" type="button" class="btn btn-success">คนไข้ที่ผ่าตัดเสร็จแล้ว</a> 
            <a href="./pt4.php" type="button" class="btn btn-primary">คนไข้เลื่อนผ่าตัด</a> 
            <a href="./pt5.php" type="button" class="btn btn-danger">คนไข้ยกเลิกผ่าตัด</a>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">ข้อมูลผู้รับบริการ ณ วันที่ <?php echo " : " . date("d/m/Y") . "<br>"; ?></li>
            </ol>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>HN</th>
                                <th>AN</th>
                                <th>ชื่อผู้ป่วย</th>
                                <th>อายุ</th>
                                <th>น้ำหนัก</th>
                                <th>ส่วนสูง</th>
                                <th>บันทึกโรคเรื้อรัง</th>
                                <th>ติดต่อโทร</th>
                                <th>วันที่ลงทะเบียน</th>
                                <th>สถานะ</th>
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <!-- <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot> -->
                        <tbody>
                            <?php
                            $sql6 = "select * from patients where pp = 4";
                            $result6 = mysqli_query($conn, $sql6);
                            $conn->query("set names utf8");
                            while ($row6 = mysqli_fetch_array($result6)) {
                            ?>
                                <tr>
                                    <td><?= $row6['hn'] ?></td>
                                    <td><?= $row6['an'] ?></td>
                                    <td><?= $row6['fullname'] ?></td>
                                    <td><?= $row6['yage'] ?></td>
                                    <td><?= $row6['weight'] ?></td>
                                    <td><?= $row6['height'] ?></td>
                                    <td><?= $row6['chronic_disease'] ?></td>
                                    <td><?= $row6['phone'] ?></td>
                                    <td><?= $row6['regdate'] ?></td>
                                    <td>
                                        <?php
                                        $pp_value = $row6['pp'];
                                        $pp_labels = [
                                            "1" => "<b style='color:red'>รอผ่าตัด</b>",
                                            "2" => "<b style='color:green'>ผ่าตัดแล้ว</b>",
                                            "3" => "<b style='color:orange'>เลื่อนผ่าตัด</b>",
                                            "4" => "<b style='color:gray'>ยกเลิกผ่าตัด</b>",
                                        ];

                                        if (isset($pp_labels[$pp_value])) {
                                            echo $pp_labels[$pp_value];
                                        } else {
                                            echo "<b style='color:black'>ไม่ระบุ</b>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="#" class="btn btn-success" data-toggle="modal" data-target="#edit1<?= $row6['id'] ?>">แก้ไข</a></td>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="edit1<?= $row6['id'] ?>"" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลผู้ป่วย</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editForm" method="POST" action="editpt.php">
                                                        <input type="hidden" value="<?php echo $row6["id"]; ?>" name="id">
                                                        <div class="form-group">
                                                            <label for="an">AN</label>
                                                            <input type="text" class="form-control" value="<?php echo $row6["an"]; ?>" id="an" name="an">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fullname">HN</label>
                                                            <input type="text" class="form-control" value="<?php echo $row6["hn"]; ?>" id="hn" name="hn">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fullname">ชื่อผู้ป่วย</label>
                                                            <input type="text" class="form-control" value="<?php echo $row6["fullname"]; ?>" id="fullname" name="fullname">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="yage">อายุ</label>
                                                            <input type="text" class="form-control" value="<?php echo $row6["yage"]; ?>" id="yage" name="yage">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="weight">น้ำหนัก</label>
                                                            <input type="text" class="form-control" value="<?php echo $row6["weight"]; ?>" id="weight" name="weight">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="height">ส่วนสูง</label>
                                                            <input type="text" class="form-control" value="<?php echo $row6["height"]; ?>" id="height" name="height">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="chronic_disease">บันทึกโรคเรื้อรัง</label>
                                                            <input type="text" class="form-control" value="<?php echo $row6["chronic_disease"]; ?>" id="chronic_disease" name="chronic_disease">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="phone">ติดต่อโทร</label>
                                                            <input type="text" class="form-control" value="<?php echo $row6["phone"]; ?>" id="phone" name="phone">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="regdate">วันที่ลงทะเบียน</label>
                                                            <input type="date" class="form-control" value="<?php echo $row6["regdate"]; ?>" id="regdate" name="regdate">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pp">สถานะ</label>
                                                            <select class="form-control" id="pp" name="pp">
                                                                <?php
                                                                $pp_value = $row6["pp"]; // Get the current value from the database
                                                                $pp_options = [
                                                                    "1" => "รอผ่าตัด",
                                                                    "2" => "ผ่าตัดแล้ว",
                                                                    "3" => "เลื่อนผ่าตัด",
                                                                    "4" => "ยกเลิกผ่าตัด",
                                                                ];


                                                                foreach ($pp_options as $value => $label) {
                                                                    $selected = ($pp_value == $value) ? "selected" : "";
                                                                    echo "<option value=\"$value\" $selected>$label</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <div class="checkbox">
                                                                <label class="text-danger">
                                                                    <input type="checkbox" name="delete"> Delete event
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                        <button type="submit" class="btn btn-primary">บันทึก+แก้ไข</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    <!-- Main content -->
    <section class="content container-fluid">

    </section>
    <!-- /.content -->
</div>
