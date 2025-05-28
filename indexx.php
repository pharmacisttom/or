<?php
require_once('bdd.php');
$sql = "SELECT * FROM surgery_bookings ";
$bdd->exec("SET NAMES utf8");
$req = $bdd->prepare($sql);
$req->execute();

$events = $req->fetchAll();

?> 

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ระบบจองห้องผ่าตัด</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- FullCalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- โหลด moment.js ภาษาไทย -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/th.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js"></script>


    <!-- Custom CSS -->
<style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
	#calendar {
		/* max-width: 800px; */
		width: 100%;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
	h1, p.lead {
    color: green;
    }
	.modal-dialog {
    max-width: 80%; /* ปรับขนาด modal ตามหน้าจอ */
    width: auto;
    }

    .modal-body {
    max-height: auto; /* กำหนดความสูงสูงสุด */
    overflow-y: auto; /* ทำให้สามารถเลื่อนดูเนื้อหาได้ถ้ายาวเกิน */
    }
  .modal-body .form-control {
  font-size: 14px;
  padding: 6px 10px;
}
.btn-container {
            margin-top: 20px;
            display: flex;
            justify-content: center; /* จัดให้อยู่ตรงกลาง */
            gap: 15px; /* กำหนดช่องว่างระหว่างปุ่ม */
            flex-wrap: wrap; /* ให้ปุ่มขึ้นบรรทัดใหม่ถ้าจอกว้างไม่พอ */
        }
.modal-body select.form-control {
  height: auto; /* ปรับให้ dropdown ไม่สูงเกินไป */
}
.modal-body textarea.form-control {
  resize: vertical; /* อนุญาตให้ปรับขนาด textarea เฉพาะแนวตั้ง */
}
.btn-container button {
        margin-right: 5px; /* ปรับระยะห่างระหว่างปุ่ม */
    }

    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="#">Free Calendar</a> -->
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <!-- <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Menu</a>
                    </li>
                </ul>
            </div> -->
          
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <!-- <div class="col-lg-12 text-center"> -->
    <h1 class="text-success">ระบบจองห้องผ่าตัด โรงพยาบาลปลวกแดง</h1>
    
    <div class="btn-container">
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1">ข้อมูลคนไข้ 1</button>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2">ข้อมูลคนไข้ 2</button>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal3">ข้อมูลคนไข้ 3</button>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal4">ข้อมูลคนไข้ 4</button>
    </div>
</div>

<!-- Modal 1 -->
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ข้อมูลคนไข้ 1</h4>
            </div>
            <div class="modal-body">
                <p>รายละเอียดคนไข้ 1</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2 -->
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ข้อมูลคนไข้ 2</h4>
            </div>
            <div class="modal-body">
                <p>รายละเอียดคนไข้ 2</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

			    <p class="lead text-success">สามารถจองห้องผ่าตัดได้แค่ 1 ห้อง</p>
                <div id="calendar" class="col-md-12">
                </div>
            </div>
			
        </div>
        <!-- /.row -->
		
		<!-- Modal -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="addEvent1.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">เพิ่มการจองห้องผ่าตัด</h4>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label for="title" class="col-md-3 col-form-label">ลักษณะการผ่าตัด</label>
            <div class="col-md-9">
			  <select class="form-control" name="title" required>
                <option value="">โปรดเลือก</option>
                <option value="ผ่าตัดเล็กแผล">ผ่าตัดเล็กแผล</option>
                <option value="ผ่าตัดใหญ่">ผ่าตัดใหญ่</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="booking_type" class="col-md-3 col-form-label">ลักษณะการจอง</label>
            <div class="col-md-9">
              <select class="form-control" name="booking_type" required>
                <option value="">โปรดเลือก</option>
                <option value="1">แบบกำหนดเวลา</option>
                <option value="2">แบบผ่าตัดจนเสร็จสิ้น</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
           <label class="col-md-3 col-form-label">เลือกผู้ป่วย</label>
           <div class="col-md-9">
           <select class="form-control" id="patient_id" name="patient_id" required>
          <option value="">-- กรุณาเลือกผู้ป่วย --</option>
        <?php
        require_once('bdd.php');

        $sql1 = "SELECT id, fullname as patient_name FROM patients ORDER BY patient_name ASC";
		$bdd->exec("SET NAMES utf8");
        $req1 = $bdd->prepare($sql1);
        $req1->execute();

        // Fetch results using a while loop
        while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
          echo "<option value='" . $pt['id'] . "'>" . $pt['patient_name'] . "</option>";
        }
      ?>
    </select>
  </div>
      </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">ประเภทของการผ่าตัด</label>
            <div class="col-md-9">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="surgery_type" id="elective" value="Elective" required>
                <label class="form-check-label" for="elective">Elective</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="surgery_type" id="emergency" value="Emergency" required>
                <label class="form-check-label" for="emergency">Emergency</label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">ประเภทผู้ป่วย</label>
            <div class="col-md-9">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="patient_type" id="opd" value="OPD" required>
                <label class="form-check-label" for="opd">OPD (ผ่าตัดแบบไม่นอน รพ.)</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="patient_type" id="ipd" value="IPD" required>
                <label class="form-check-label" for="ipd">IPD (นอน รพ.เพื่อผ่าตัด)</label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">ความต้องการ Anesthesia</label>
            <div class="col-md-9">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="anesthesia" id="la" value="LA" required>
                <label class="form-check-label" for="la">LA</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="anesthesia" id="anesth" value="Anesthesia" required>
                <label class="form-check-label" for="anesth">Anesthesia</label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="dx" class="col-md-3 col-form-label">DX</label>
            <div class="col-md-9">
              <textarea rows="3" class="form-control rounded-0" name="dx" id="dx" required></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label for="op" class="col-md-3 col-form-label">OP</label>
            <div class="col-md-9">
              <textarea rows="3" class="form-control rounded-0" name="op" id="op" required></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label for="surgeon" class="col-md-3 col-form-label">แพทย์ผ่าตัด</label>
            <div class="col-md-9">
              <input type="text" class="form-control rounded-0" name="surgeon" id="surgeon" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="start_datetime" class="col-md-3 col-form-label">วันเวลาเริ่มจอง</label>
            <div class="col-md-9">
              <input type="datetime-local" class="form-control rounded-0" name="start_datetime" id="start_datetime" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="end_datetime" class="col-md-3 col-form-label">วันเวลาสิ้นสุด</label>
            <div class="col-md-9">
              <input type="datetime-local" class="form-control rounded-0" name="end_datetime" id="end_datetime" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="note" class="col-md-3 col-form-label">หมายเหตุ (Position, อุปกรณ์พิเศษ, อื่นๆ)</label>
            <div class="col-md-9">
              <textarea rows="3" class="form-control rounded-0" name="note" id="note" required></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label for="booked_by" class="col-md-3 col-form-label">ชื่อผู้จอง</label>
            <div class="col-md-9">
              <input type="text" class="form-control rounded-0" name="booked_by" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="department" class="col-md-3 col-form-label">แผนกที่จอง</label>
            <div class="col-md-9">
              <input type="text" class="form-control rounded-0" name="department" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="color" class="col-md-3 col-form-label">Color</label>
            <div class="col-md-9">
              <select name="color" class="form-control" id="color">
                <option value="">Choose</option>
                <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                <option style="color:#008000;" value="#008000">&#9724; Green</option>
                <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                <option style="color:#000;" value="#000">&#9724; Black</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

		
			<!-- Modal -->
      
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="editEventTitle1.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="title" class="col-md-3 col-form-label">ลักษณะการผ่าตัด</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control rounded-0" name="title" id="title" required>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">เลือกผู้ป่วย</label>
                        <div class="col-md-9">
                            <select class="form-control" id="patient_id" name="patient_id" disabled>
                                <option value="">-- กรุณาเลือกผู้ป่วย --</option>
                                <?php
                                require_once('bdd.php');
                                $sql1 = "SELECT id, fullname as patient_name FROM patients ORDER BY patient_name ASC";
                                $bdd->exec("SET NAMES utf8");
                                $req1 = $bdd->prepare($sql1);
                                $req1->execute();
                                while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $pt['id'] . "'>" . $pt['patient_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                   <label class="col-md-3 col-form-label">ประเภทของการผ่าตัด</label>
                  <div class="col-md-9">
                  <div class="form-group row">
    <div class="col-md-9">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="surgery_type" id="surgery_type_elective" value="Elective" required>
            <label class="form-check-label" for="surgery_type_elective">Elective</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="surgery_type" id="surgery_type_emergency" value="Emergency" required>
            <label class="form-check-label" for="surgery_type_emergency">Emergency</label>
        </div>
    </div>
</div>
    </div>
</div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">ประเภทผู้ป่วย</label>
                        <div class="col-md-9">
                        <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="patient_type" id="patient_type_opd" value="OPD" required>
    <label class="form-check-label" for="patient_type_opd">OPD (ผ่าตัดแบบไม่นอน รพ.)</label>
</div>
<div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="patient_type" id="patient_type_ipd" value="IPD" required>
    <label class="form-check-label" for="patient_type_ipd">IPD (นอน รพ.เพื่อผ่าตัด)</label>
</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">ความต้องการ Anesthesia</label>
                        <div class="col-md-9">
<div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="anesthesia" id="anesthesia_la" value="LA" required>
    <label class="form-check-label" for="anesthesia_la">LA</label>
</div>
<div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="anesthesia" id="anesthesia_anesthesia" value="Anesthesia" required>
    <label class="form-check-label" for="anesthesia_anesthesia">Anesthesia</label>
</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dx" class="col-md-3 col-form-label">DX</label>
                        <div class="col-md-9">
                            <textarea rows="3" class="form-control rounded-0" name="dx" id="dx" placeholder="dx"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="op" class="col-md-3 col-form-label">OP</label>
                        <div class="col-md-9">
                            <textarea rows="3" class="form-control rounded-0" name="op" id="op" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="surgeon" class="col-md-3 col-form-label">แพทย์ผ่าตัด</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control rounded-0" name="surgeon" id="surgeon" required>
                        </div>
                    </div>

<!-- วันเวลาเริ่มจอง -->
<div class="form-group row">
    <label for="start_datetime_modal" class="col-md-3 col-form-label">วันเวลาเริ่มจอง</label>
    <div class="col-md-9">
        <input type="datetime-local" class="form-control rounded-0" name="start_datetime" id="start_datetime_modal" required>
    </div>
</div>

<!-- วันเวลาสิ้นสุด -->
<div class="form-group row">
    <label for="end_datetime_modal" class="col-md-3 col-form-label">วันเวลาสิ้นสุด</label>
    <div class="col-md-9">
        <input type="datetime-local" class="form-control rounded-0" name="end_datetime" id="end_datetime_modal" required>
    </div>
</div>

                    <div class="form-group row">
                        <label for="note" class="col-md-3 col-form-label">หมายเหตุ (Position, อุปกรณ์พิเศษ, อื่นๆ)</label>
                        <div class="col-md-9">
                            <textarea rows="3" class="form-control rounded-0" name="note" id="note" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="booked_by" class="col-md-3 col-form-label">ชื่อผู้จอง</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control rounded-0" name="booked_by" id="booked_by"  required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="department" class="col-md-3 col-form-label">แผนกที่จอง</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control rounded-0" name="department"  id="department"  required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="color" class="col-md-3 col-form-label">Color</label>
                        <div class="col-md-9">
                            <select name="color" class="form-control" id="color">
                                <option value="">Choose</option>
                                <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                <option style="color:#000;" value="#000">&#9724; Black</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label class="text-danger">
                                    <input type="checkbox" name="delete"> Delete event
                                </label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" class="form-control" id="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
		  </div>
		</div>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- FullCalendar -->
	<script src='js/moment.min.js'></script>
	<script src='js/fullcalendar.min.js'></script>
	
	<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: new Date(),
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
		
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
    // เพิ่มข้อมูลแพทย์ผ่าตัดและแผนกใน title
    var surgeonInfo = event.surgeon ? 'แพทย์: ' + event.surgeon : '';
    var departmentInfo = event.department ? 'แผนก: ' + event.department : '';
    var bookedInfo = event.booked_by ? 'ผู้จอง: ' + event.booked_by: '';

    // แสดงข้อมูลใน title ของ event
    element.find('.fc-title').html(surgeonInfo + '<br>' + departmentInfo+'@'+bookedInfo);

				element.bind('dblclick', function() {
    // ตั้งค่าฟิลด์ต่างๆ ใน modal
    $('#ModalEdit #id').val(event.id);
    $('#ModalEdit #title').val(event.title);
    $('#ModalEdit #patient_id').val(event.patient_id);
    $('#ModalEdit #booking_type').val(event.booking_type);
    if(event.surgery_type === 'Elective') {
        $('#ModalEdit #surgery_type_elective').prop('checked', true);
    } else if(event.surgery_type === 'Emergency') {
        $('#ModalEdit #surgery_type_emergency').prop('checked', true);
    }
     // Set patient_type radio buttons
     if(event.patient_type === 'OPD') {
        $('#ModalEdit #patient_type_opd').prop('checked', true);
    } else if(event.patient_type === 'IPD') {
        $('#ModalEdit #patient_type_ipd').prop('checked', true);
    }
    


   // Set anesthesia radio buttons
    if(event.anesthesia === 'LA') {
        $('#ModalEdit #anesthesia_la').prop('checked', true);
    } else if(event.anesthesia === 'Anesthesia') {
        $('#ModalEdit #anesthesia_anesthesia').prop('checked', true);
    }

    $('#ModalEdit #dx').val(event.dx);
    $('#ModalEdit #op').val(event.op);
    $('#ModalEdit #surgeon').val(event.surgeon);
    $('#ModalEdit #note').val(event.note);
    $('#ModalEdit #booked_by').val(event.booked_by);
    $('#ModalEdit #department').val(event.department);
    $('#ModalEdit #color').val(event.color);

    // Debugging: Check that event.start and event.end are being captured correctly
    console.log("Start: ", event.start);
    console.log("End: ", event.end);

    // ตั้งค่า start_datetime และ end_datetime ใน modal
    $('#ModalEdit #start_datetime_modal').val(moment(event.start).format('YYYY-MM-DDTHH:mm'));
    $('#ModalEdit #end_datetime_modal').val(moment(event.end).format('YYYY-MM-DDTHH:mm'));
    // เปิด ModalEdit
    $('#ModalEdit').modal('show');
});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			locale: 'th', // Set the locale to Thai
			buttonText: {
				today: 'วันนี้',
				month: 'เดือน',
				week: 'สัปดาห์',
				day: 'วัน'
			},
			titleFormat: {
				month: 'MMMM YYYY', // Show full month name and year
				week: 'D MMMM YYYY', // Show week with full month name and year
				day: 'D MMMM YYYY' // Show full day with month name and year
			},
      // titleFormat: {
      //               month: function(date) {
      //                   // แปลงชื่อเดือนและปีเป็น พ.ศ.
      //                   var monthName = date.format('MMMM'); // เดือนเป็นภาษาไทย
      //                   var year = date.year() + 543; // แปลงจาก ค.ศ. เป็น พ.ศ.
      //                   return monthName + ' ' + year; // คืนค่าเป็น "เดือน พ.ศ."
      //               },
      //               week: 'D MMMM YYYY', // สัปดาห์
      //               day: 'D MMMM YYYY' // วัน
      //           },
			events: [
			<?php 
     
      foreach($events as $event): 
  
				$start = explode(" ", $event['start_datetime']);
				$end = explode(" ", $event['end_datetime']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start_datetime'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end_datetime'];
				}
			?>
				{
    id: '<?php echo $event['id']; ?>',
    title: '<?php echo $event['title']; ?>',
    start: '<?php echo date('Y-m-d\TH:i:s', strtotime($event['start_datetime'])); ?>',
    end: '<?php echo date('Y-m-d\TH:i:s', strtotime($event['end_datetime'])); ?>',
    surgery_type: '<?php echo $event['surgery_type']; ?>',
    booking_type: '<?php echo $event['booking_type']; ?>',
    patient_id: '<?php echo $event['patient_id']; ?>',
    patient_type: '<?php echo $event['patient_type']; ?>',
    anesthesia: '<?php echo $event['anesthesia']; ?>',
    dx: '<?php echo $event['dx']; ?>',
    op: '<?php echo $event['op']; ?>',
    surgeon: '<?php echo $event['surgeon']; ?>',
    note: '<?php echo $event['note']; ?>',
    booked_by: '<?php echo $event['booked_by']; ?>',
    department: '<?php echo $event['department']; ?>',
    color: '<?php echo $event['color']; ?>',
},
			<?php endforeach; ?>
			]
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'editEventDate1.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else{
						alert('Could not be saved. try again.'); 
					}
				}
			});
		}
		
	});

</script>

</body>

</html>

