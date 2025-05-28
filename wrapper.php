<div class="content-wrapper">
  <section class="content-header">
    <h1>
      ระบบจองคิวห้องผ่าตัด
      <small>(PDH smart OR)</small>
    </h1>
  </section>

  <section class="content container-fluid">
    <div id="calendar" class="col-md-12">
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <form class="form-horizontal" method="POST" action="addEvent1.php" id="addEventForm">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">เพิ่มการจองห้องผ่าตัด</h4>
            </div>
            <div class="modal-body">
              <!-- <div class="form-group row">
                <label for="title" class="col-md-3 col-form-label">ลักษณะการผ่าตัด</label>
                <div class="col-md-9">
                  <select class="form-control" name="title" disabled>
                    <option value="">โปรดเลือกประเภทการผ่าตัด</option>
                    <option value="การผ่าตัดทั่วไป">การผ่าตัดทั่วไป</option>
                    <option value="การผ่าตัดเฉพาะทาง">การผ่าตัดเฉพาะทาง</option>
                    <option value="การผ่าตัดฉุกเฉิน">การผ่าตัดฉุกเฉิน</option>
                    <option value="การผ่าตัดด้วยเทคนิคส่องกล้อง">การผ่าตัดด้วยเทคนิคส่องกล้อง</option>
                    <option value="การผ่าตัดประยุกต์">การผ่าตัดประยุกต์</option>
                    <option value="การผ่าตัดความงาม">การผ่าตัดความงาม</option>
                    <option value="การทำแผล">การทำแผล</option>
                  </select>
                </div>
              </div> -->

              <!-- <div class="form-group row">
                <label for="booking_type" class="col-md-3 col-form-label">ลักษณะการจอง</label>
                <div class="col-md-9">
                  <select class="form-control" name="booking_type" disabled>
                    <option value="">โปรดเลือก</option>
                    <option value="1">แบบกำหนดเวลา</option>
                    <option value="2">แบบผ่าตัดจนเสร็จสิ้น</option>
                  </select>
                </div>
              </div> -->

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
                    <input class="form-check-input" type="radio" name="surgery_type" id="elective_add" value="Elective" required>
                    <label class="form-check-label" for="elective_add">Elective</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="surgery_type" id="emergency_add" value="Emergency" required>
                    <label class="form-check-label" for="emergency_add">Emergency</label>
                  </div>
                </div>
              </div>

              <!-- Investigation Section -->
              <div class="form-group row elective-investigation" style="display: none;">
                <label class="col-md-3 col-form-label">Investigation</label>
                <div class="col-md-9" style="max-height: 400px; overflow-y: auto; padding-right: 15px;">
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="CBC" id="cbc_add">
                    <label class="form-check-label" for="cbc_add">CBC</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="BUN_CR" id="bun_cr_add">
                    <label class="form-check-label" for="bun_cr_add">(BUN,CR)</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="Electrolyte" id="electrolyte_add">
                    <label class="form-check-label" for="electrolyte_add">Electrolyte</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="FBS" id="fbs_add">
                    <label class="form-check-label" for="fbs_add">FBS</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="PT_PTT_INR" id="pt_ptt_inr_add">
                    <label class="form-check-label" for="pt_ptt_inr_add">(PT,PTT,INR)</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="LFT" id="lft_add">
                    <label class="form-check-label" for="lft_add">LFT</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="Anti_HIV" id="anti_hiv_add">
                    <label class="form-check-label" for="anti_hiv_add">Anti-HIV</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="CXR" id="cxr_add">
                    <label class="form-check-label" for="cxr_add">CXR</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="EKG" id="ekg_add">
                    <label class="form-check-label" for="ekg_add">EKG</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="HBA1C" id="hba1c_add">
                    <label class="form-check-label" for="hba1c_add">HBA1C</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="Other" id="invest_other_add">
                    <label class="form-check-label" for="invest_other_add">อื่นๆ</label>
                    <input type="text" class="form-control mt-2" name="invest_other_text" id="invest_other_text_add" style="display: none;">
                  </div>

                  <div class="form-group mt-3">
                    <label>ปรึกษาแผนก</label>
                    <select class="form-control" name="consult_department" id="consult_department_add">
                      <option value="">-- ไม่ต้องปรึกษา --</option>
                      <?php
                      require_once('bdd.php');
                      $sql1 = "SELECT id, department_name FROM departments ORDER BY department_name ASC";
                      $bdd->exec("SET NAMES utf8");
                      $req1 = $bdd->prepare($sql1);
                      $req1->execute();
                      while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $pt['id'] . "'>" . $pt['department_name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group mt-3">
                    <label>จองเลือด</label>
                    <div class="form-check">
                      <input class="form-check-input blood-checkbox" type="checkbox" name="blood_prc" id="blood_prc_add" value="1">
                      <label class="form-check-label" for="blood_prc_add">PRC/LPRC</label>
                      <input type="number" class="form-control d-inline-block w-auto ml-2" name="blood_prc_unit" id="blood_prc_unit_add" min="1" style="display: none;">
                      <span class="ml-2">unit</span>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input blood-checkbox" type="checkbox" name="blood_ffp" id="blood_ffp_add" value="1">
                      <label class="form-check-label" for="blood_ffp_add">FFP</label>
                      <input type="number" class="form-control d-inline-block w-auto ml-2" name="blood_ffp_unit" id="blood_ffp_unit_add" min="1" style="display: none;">
                      <span class="ml-2">unit</span>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input blood-checkbox" type="checkbox" name="blood_other" id="blood_other_add" value="1">
                      <label class="form-check-label" for="blood_other_add">อื่นๆ</label>
                      <input type="text" class="form-control mt-2" name="blood_other_text" id="blood_other_text_add" style="display: none;">
                    </div>
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
                  <select class="form-control" id="surgeon" name="surgeon" required>
                    <option value="">-- กรุณาเลือกแพทย์ผ่าตัด --</option>
                    <?php
                    require_once('bdd.php');
                    $sql1 = "SELECT iddoctor,ndoctor FROM doctor ORDER BY ndoctor ASC";
                    $bdd->exec("SET NAMES utf8");
                    $req1 = $bdd->prepare($sql1);
                    $req1->execute();
                    while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $pt['iddoctor'] . "'>" . $pt['ndoctor'] . "</option>";
                    }
                    ?>
                  </select>
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
                <label class="col-md-3 col-form-label">การจองแผนกหลังผ่าตัด</label>
                <div class="col-md-9">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="icu" value="ICU" required>
                    <label class="form-check-label" for="icu">จอง ICU</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="ipd_post" value="IPD" required>
                    <label class="form-check-label" for="ipd_post">IPD</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="opd_post" value="OPD" required>
                    <label class="form-check-label" for="opd_post">OPD</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="chantara" value="Chantara" required>
                    <label class="form-check-label" for="chantara">ตึกจันทรประสิทธิ์</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="home" value="Home" required>
                    <label class="form-check-label" for="home">ให้ผู้ป่วยกลับบ้าน</label>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="booked_by" class="col-md-3 col-form-label">ชื่อผู้จอง</label>
                <div class="col-md-9">
                  <select class="form-control" id="booked_by" name="booked_by" required>
                    <option value="">-- กรุณาเลือกผู้จอง --</option>
                    <?php
                    require_once('bdd.php');
                    $sql1 = "SELECT idnurse,nnurse FROM nurse ORDER BY nnurse ASC";
                    $bdd->exec("SET NAMES utf8");
                    $req1 = $bdd->prepare($sql1);
                    $req1->execute();
                    while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $pt['idnurse'] . "'>" . $pt['nnurse'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="department" class="col-md-3 col-form-label">แผนกที่จอง</label>
                <div class="col-md-9">
                  <select class="form-control" id="department" name="department" required>
                    <option value="">-- กรุณาเลือกแผนกที่จอง --</option>
                    <?php
                    require_once('bdd.php');
                    $sql1 = "SELECT id,department_name FROM departments ORDER BY id ASC";
                    $bdd->exec("SET NAMES utf8");
                    $req1 = $bdd->prepare($sql1);
                    $req1->execute();
                    while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $pt['id'] . "'>" . $pt['department_name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="department_or" class="col-md-3 col-form-label">แผนกห้องผ่าตัด</label>
                <div class="col-md-9">
                  <select name="department_or" class="form-control" id="department_or" required>
                    <option value="">-- กรุณาเลือกแผนกห้องผ่าตัด --</option>
                    <option style="color:#FF69B4;" value="สูตินรีเวช">◼ สูตินรีเวช (สีชมพู)</option>
                    <option style="color:#008000;" value="ศัลยกรรม">◼ ศัลยกรรม (สีเขียว)</option>
                    <option style="color:#FFD700;" value="ออร์โธปิดิกส์">◼ ออร์โธปิดิกส์ (สีเหลือง)</option>
                    <option style="color:#FF0000;" value="ฉุกเฉิน">◼ ฉุกเฉิน (สีแดง)</option>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <form class="form-horizontal" method="POST" action="editEventTitle1.php" id="editEventForm">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
            </div>
            <div class="modal-body">
              <!-- <div class="form-group row">
                <label for="title" class="col-md-3 col-form-label">ลักษณะการผ่าตัด</label>
                <div class="col-md-9">
                  <select class="form-control" name="title" id="title" required>
                    <option value="">โปรดเลือกประเภทการผ่าตัด</option>
                    <option value="การผ่าตัดทั่วไป">การผ่าตัดทั่วไป</option>
                    <option value="การผ่าตัดเฉพาะทาง">การผ่าตัดเฉพาะทาง</option>
                    <option value="การผ่าตัดฉุกเฉิน">การผ่าตัดฉุกเฉิน</option>
                    <option value="การผ่าตัดด้วยเทคนิคส่องกล้อง">การผ่าตัดด้วยเทคนิคส่องกล้อง</option>
                    <option value="การผ่าตัดประยุกต์">การผ่าตัดประยุกต์</option>
                    <option value="การผ่าตัดความงาม">การผ่าตัดความงาม</option>
                    <option value="การทำแผล">การทำแผล</option>
                  </select>
                </div>
              </div> -->

              <!-- <div class="form-group row">
                <label for="booking_type" class="col-md-3 col-form-label">ลักษณะการจอง</label>
                <div class="col-md-9">
                  <select class="form-control" name="booking_type" id="booking_type" required>
                    <option value="">โปรดเลือก</option>
                    <option value="1">แบบกำหนดเวลา</option>
                    <option value="2">แบบผ่าตัดจนเสร็จสิ้น</option>
                  </select>
                </div>
              </div> -->

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
                    <input class="form-check-input" type="radio" name="surgery_type" id="surgery_type_elective" value="Elective" required>
                    <label class="form-check-label" for="surgery_type_elective">Elective</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="surgery_type" id="surgery_type_emergency" value="Emergency" required>
                    <label class="form-check-label" for="surgery_type_emergency">Emergency</label>
                  </div>
                </div>
              </div>

              <!-- Investigation Section -->
              <div class="form-group row elective-investigation" style="display: none;">
                <label class="col-md-3 col-form-label">Investigation</label>
                <div class="col-md-9" style="max-height: 400px; overflow-y: auto; padding-right: 15px;">
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="CBC" id="cbc_edit">
                    <label class="form-check-label" for="cbc_edit">CBC</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="BUN_CR" id="bun_cr_edit">
                    <label class="form-check-label" for="bun_cr_edit">(BUN,CR)</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="Electrolyte" id="electrolyte_edit">
                    <label class="form-check-label" for="electrolyte_edit">Electrolyte</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="FBS" id="fbs_edit">
                    <label class="form-check-label" for="fbs_edit">FBS</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="PT_PTT_INR" id="pt_ptt_inr_edit">
                    <label class="form-check-label" for="pt_ptt_inr_edit">(PT,PTT,INR)</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="LFT" id="lft_edit">
                    <label class="form-check-label" for="lft_edit">LFT</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="Anti_HIV" id="anti_hiv_edit">
                    <label class="form-check-label" for="anti_hiv_edit">Anti-HIV</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="CXR" id="cxr_edit">
                    <label class="form-check-label" for="cxr_edit">CXR</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="EKG" id="ekg_edit">
                    <label class="form-check-label" for="ekg_edit">EKG</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="HBA1C" id="hba1c_edit">
                    <label class="form-check-label" for="hba1c_edit">HBA1C</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input investigation-checkbox" type="checkbox" name="investigations[]" value="Other" id="invest_other_edit">
                    <label class="form-check-label" for="invest_other_edit">อื่นๆ</label>
                    <input type="text" class="form-control mt-2" name="invest_other_text" id="invest_other_text_edit" style="display: none;">
                  </div>

                  <div class="form-group mt-3">
                    <label>ปรึกษาแผนก</label>
                    <select class="form-control" name="consult_department" id="consult_department_edit">
                      <option value="">-- ไม่ต้องปรึกษา --</option>
                      <?php
                      require_once('bdd.php');
                      $sql1 = "SELECT id, department_name FROM departments ORDER BY department_name ASC";
                      $bdd->exec("SET NAMES utf8");
                      $req1 = $bdd->prepare($sql1);
                      $req1->execute();
                      while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $pt['id'] . "'>" . $pt['department_name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group mt-3">
                    <label>จองเลือด</label>
                    <div class="form-check">
                      <input class="form-check-input blood-checkbox" type="checkbox" name="blood_prc" id="blood_prc_edit" value="1">
                      <label class="form-check-label" for="blood_prc_edit">PRC/LPRC</label>
                      <input type="number" class="form-control d-inline-block w-auto ml-2" name="blood_prc_unit" id="blood_prc_unit_edit" min="1" style="display: none;">
                      <span class="ml-2">unit</span>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input blood-checkbox" type="checkbox" name="blood_ffp" id="blood_ffp_edit" value="1">
                      <label class="form-check-label" for="blood_ffp_edit">FFP</label>
                      <input type="number" class="form-control d-inline-block w-auto ml-2" name="blood_ffp_unit" id="blood_ffp_unit_edit" min="1" style="display: none;">
                      <span class="ml-2">unit</span>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input blood-checkbox" type="checkbox" name="blood_other" id="blood_other_edit" value="1">
                      <label class="form-check-label" for="blood_other_edit">อื่นๆ</label>
                      <input type="text" class="form-control mt-2" name="blood_other_text" id="blood_other_text_edit" style="display: none;">
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
                  <select class="form-control" id="surgeon" name="surgeon" required>
                    <option value="">-- กรุณาเลือกแพทย์ผ่าตัด --</option>
                    <?php
                    require_once('bdd.php');
                    $sql1 = "SELECT iddoctor,ndoctor FROM doctor ORDER BY ndoctor ASC";
                    $bdd->exec("SET NAMES utf8");
                    $req1 = $bdd->prepare($sql1);
                    $req1->execute();
                    while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $pt['iddoctor'] . "'>" . $pt['ndoctor'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="start_datetime_modal" class="col-md-3 col-form-label">วันเวลาเริ่มจอง</label>
                <div class="col-md-9">
                  <input type="datetime-local" class="form-control rounded-0" name="start_datetime" id="start_datetime_modal" required>
                </div>
              </div>

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
                <label class="col-md-3 col-form-label">การจองแผนกหลังผ่าตัด</label>
                <div class="col-md-9">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="icu_edit" value="ICU" required>
                    <label class="form-check-label" for="icu_edit">จอง ICU</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="ipd_edit" value="IPD" required>
                    <label class="form-check-label" for="ipd_edit">IPD</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="opd_edit" value="OPD" required>
                    <label class="form-check-label" for="opd_edit">OPD</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="chantara_edit" value="Chantara" required>
                    <label class="form-check-label" for="chantara_edit">ตึกจันทรประสิทธิ์</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="post_surgery_booking" id="home_edit" value="Home" required>
                    <label class="form-check-label" for="home_edit">ให้ผู้ป่วยกลับบ้าน</label>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="booked_by" class="col-md-3 col-form-label">ชื่อผู้จอง</label>
                <div class="col-md-9">
                  <select class="form-control" id="booked_by" name="booked_by" required>
                    <option value="">-- กรุณาเลือกผู้จอง --</option>
                    <?php
                    require_once('bdd.php');
                    $sql1 = "SELECT idnurse,nnurse FROM nurse ORDER BY nnurse ASC";
                    $bdd->exec("SET NAMES utf8");
                    $req1 = $bdd->prepare($sql1);
                    $req1->execute();
                    while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $pt['idnurse'] . "'>" . $pt['nnurse'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="department" class="col-md-3 col-form-label">แผนกที่จอง</label>
                <div class="col-md-9">
                  <select class="form-control" id="department" name="department" required>
                    <option value="">-- กรุณาเลือกแผนกที่จอง --</option>
                    <?php
                    require_once('bdd.php');
                    $sql1 = "SELECT id,department_name FROM departments ORDER BY id ASC";
                    $bdd->exec("SET NAMES utf8");
                    $req1 = $bdd->prepare($sql1);
                    $req1->execute();
                    while ($pt = $req1->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $pt['id'] . "'>" . $pt['department_name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="department_or" class="col-md-3 col-form-label">แผนกห้องผ่าตัด</label>
                <div class="col-md-9">
                  <select name="department_or" class="form-control" id="department_or" required>
                    <option value="">-- กรุณาเลือกแผนกห้องผ่าตัด --</option>
                    <option style="color:#FF69B4;" value="สูตินรีเวช">◼ สูตินรีเวช (สีชมพู)</option>
                    <option style="color:#008000;" value="ศัลยกรรม">◼ ศัลยกรรม (สีเขียว)</option>
                    <option style="color:#FFD700;" value="ออร์โธปิดิกส์">◼ ออร์โธปิดิกส์ (สีเหลือง)</option>
                    <option style="color:#FF0000;" value="ฉุกเฉิน">◼ ฉุกเฉิน (สีแดง)</option>
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
  </section>
</div>

<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Modal Add: Toggle Investigation Section
    $('#ModalAdd input[name="surgery_type"]').change(function() {
        var $investigationSection = $('#ModalAdd .elective-investigation');
        if ($(this).val() === 'Elective') {
            $investigationSection.show();
        } else {
            $investigationSection.hide();
            $('#ModalAdd .investigation-checkbox').prop('checked', false);
            $('#ModalAdd #invest_other_text_add').val('').hide();
            $('#ModalAdd #consult_department_add').val('');
            $('#ModalAdd .blood-checkbox').prop('checked', false);
            $('#ModalAdd #blood_prc_unit_add, #ModalAdd #blood_ffp_unit_add').val('').hide();
            $('#ModalAdd #blood_other_text_add').val('').hide();
        }
    });

    // Modal Edit: Toggle Investigation Section
    $('#ModalEdit input[name="surgery_type"]').change(function() {
        var $investigationSection = $('#ModalEdit .elective-investigation');
        if ($(this).val() === 'Elective') {
            $investigationSection.show();
            console.log('Investigation Section Shown in ModalEdit');
        } else {
            $investigationSection.hide();
            $('#ModalEdit .investigation-checkbox').prop('checked', false);
            $('#ModalEdit #invest_other_text_edit').val('').hide();
            $('#ModalEdit #consult_department_edit').val('');
            $('#ModalEdit .blood-checkbox').prop('checked', false);
            $('#ModalEdit #blood_prc_unit_edit, #ModalEdit #blood_ffp_unit_edit').val('').hide();
            $('#ModalEdit #blood_other_text_edit').val('').hide();
            console.log('Investigation Section Hidden in ModalEdit');
        }
    });

    // Checkbox Handlers for Modal Add
    $('#ModalAdd #invest_other_add').change(function() {
        $('#ModalAdd #invest_other_text_add').toggle(this.checked);
    });
    $('#ModalAdd #blood_prc_add').change(function() {
        $('#ModalAdd #blood_prc_unit_add').toggle(this.checked);
    });
    $('#ModalAdd #blood_ffp_add').change(function() {
        $('#ModalAdd #blood_ffp_unit_add').toggle(this.checked);
    });
    $('#ModalAdd #blood_other_add').change(function() {
        $('#ModalAdd #blood_other_text_add').toggle(this.checked);
    });

    // Checkbox Handlers for Modal Edit
    $('#ModalEdit #invest_other_edit').change(function() {
        $('#ModalEdit #invest_other_text_edit').toggle(this.checked);
    });
    $('#ModalEdit #blood_prc_edit').change(function() {
        $('#ModalEdit #blood_prc_unit_edit').toggle(this.checked);
    });
    $('#ModalEdit #blood_ffp_edit').change(function() {
        $('#ModalEdit #blood_ffp_unit_edit').toggle(this.checked);
    });
    $('#ModalEdit #blood_other_edit').change(function() {
        $('#ModalEdit #blood_other_text_edit').toggle(this.checked);
    });

    // Debug Form Submission
    $('#addEventForm').submit(function(e) {
        console.log('Add Form Submitted');
        console.log($(this).serialize());
    });

    $('#editEventForm').submit(function(e) {
        console.log('Edit Form Submitted');
        console.log($(this).serialize());
    });
});
</script>

