<?php
include('bdd.php');

$sql = "SELECT a.*, b.ndoctor as s, c.nnurse as book, d.department_name as de, e.fullname as pt
        FROM surgery_bookings as a
        LEFT JOIN doctor b ON b.iddoctor = a.surgeon
        LEFT JOIN nurse c ON c.idnurse = a.booked_by
        LEFT JOIN departments d ON d.id = a.department 
        LEFT JOIN patients e ON a.patient_id = e.id";
$bdd->exec("SET NAMES utf8");
$req = $bdd->prepare($sql);
$req->execute();
$events = $req->fetchAll();

$color_map = [
    'สูตินรีเวช' => '#FF69B4',
    'ศัลยกรรม' => '#008000',
    'ออร์โธปิดิกส์' => '#FFD700',
    'ฉุกเฉิน' => '#FF0000'
];
include('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body class="skin-blue">
   
    <div class="wrapper">
        <header class="main-header">
            <a href="index.php" class="logo">
                <span class="logo-mini"><b>A</b>LT</span>
                <span class="logo-lg"><b>PDH Smart OR</b></span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </nav>
        </header>

        <?php include('side.php'); ?>
        <?php include('wrapper.php'); ?>
        <?php include('footer.php'); ?>

        <div class="control-sidebar-bg"></div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/adminlte.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
            eventLimit: true,
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                $('#ModalAdd #start_datetime').val(moment(start).format('YYYY-MM-DDTHH:mm'));
                $('#ModalAdd #end_datetime').val(moment(end).format('YYYY-MM-DDTHH:mm'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function(event, element) {
                var surgeonInfo = event.s ? 'แพทย์: ' + event.s : '';
                var departmentInfo = event.de ? 'แผนกที่จอง: ' + event.de : '';
                var bookedInfo = event.book ? 'ผู้จอง: ' + event.book : '';
                var ptname = event.pt ? 'ผู้ป่วยชื่อ: ' + event.pt : '';
                var casetitle = event.title ? 'ลักษณะเคส: ' + event.title : '';
                var departmentOrInfo = event.department_or ? 'เคสผ่าตัด: ' + event.department_or : '';
                var postSurgeryBooking = event.post_surgery_booking ? 'จองหลังผ่าตัด: ' + event.post_surgery_booking : '';

                element.find('.fc-title').html(
                    ptname + '<br>' + 
                    surgeonInfo + '<br>' + 
                    departmentInfo + '@' + bookedInfo + '<br>' + 
                    // casetitle + '<br>' + 
                    departmentOrInfo + '<br>' + 
                    postSurgeryBooking
                );

                element.bind('dblclick', function() {
                    // Debug: Log the event object to verify data
                    console.log('Event Data:', event);

                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(event.title);
                    $('#ModalEdit #patient_id').val(event.patient_id);
                    $('#ModalEdit #booking_type').val(event.booking_type);

                    // Surgery Type
                    if (event.surgery_type === 'Elective') {
                        $('#ModalEdit #surgery_type_elective').prop('checked', true);
                    } else if (event.surgery_type === 'Emergency') {
                        $('#ModalEdit #surgery_type_emergency').prop('checked', true);
                    }

                    // Patient Type
                    if (event.patient_type === 'OPD') {
                        $('#ModalEdit #patient_type_opd').prop('checked', true);
                    } else if (event.patient_type === 'IPD') {
                        $('#ModalEdit #patient_type_ipd').prop('checked', true);
                    }

                    // Anesthesia
                    if (event.anesthesia === 'LA') {
                        $('#ModalEdit #anesthesia_la').prop('checked', true);
                    } else if (event.anesthesia === 'Anesthesia') {
                        $('#ModalEdit #anesthesia_anesthesia').prop('checked', true);
                    }

                    // Basic Fields
                    $('#ModalEdit #dx').val(event.dx);
                    $('#ModalEdit #op').val(event.op);
                    $('#ModalEdit #surgeon').val(event.surgeon);
                    $('#ModalEdit #note').val(event.note);
                    $('#ModalEdit #booked_by').val(event.booked_by);
                    $('#ModalEdit #department').val(event.department);
                    $('#ModalEdit #department_or').val(event.department_or);

                    // Post Surgery Booking
                    if (event.post_surgery_booking === 'ICU') {
                        $('#ModalEdit #icu_edit').prop('checked', true);
                    } else if (event.post_surgery_booking === 'IPD') {
                        $('#ModalEdit #ipd_edit').prop('checked', true);
                    } else if (event.post_surgery_booking === 'OPD') {
                        $('#ModalEdit #opd_edit').prop('checked', true);
                    } else if (event.post_surgery_booking === 'Chantara') {
                        $('#ModalEdit #chantara_edit').prop('checked', true);
                    } else if (event.post_surgery_booking === 'Home') {
                        $('#ModalEdit #home_edit').prop('checked', true);
                    }

                    // Start and End Datetime
                    $('#ModalEdit #start_datetime_modal').val(moment(event.start).format('YYYY-MM-DDTHH:mm'));
                    $('#ModalEdit #end_datetime_modal').val(moment(event.end).format('YYYY-MM-DDTHH:mm'));

                    // Investigation Section
                    if (event.investigations) {
                        try {
                            let investigations = JSON.parse(event.investigations); // Parse JSON string to array
                            console.log('Parsed Investigations:', investigations); // Debug
                            $('#ModalEdit .investigation-checkbox').prop('checked', false); // Reset all checkboxes
                            investigations.forEach(function(invest) {
                                if (invest === 'CBC') $('#ModalEdit #cbc_edit').prop('checked', true);
                                if (invest === 'BUN_CR') $('#ModalEdit #bun_cr_edit').prop('checked', true);
                                if (invest === 'Electrolyte') $('#ModalEdit #electrolyte_edit').prop('checked', true);
                                if (invest === 'FBS') $('#ModalEdit #fbs_edit').prop('checked', true);
                                if (invest === 'PT_PTT_INR') $('#ModalEdit #pt_ptt_inr_edit').prop('checked', true);
                                if (invest === 'LFT') $('#ModalEdit #lft_edit').prop('checked', true);
                                if (invest === 'Anti_HIV') $('#ModalEdit #anti_hiv_edit').prop('checked', true);
                                if (invest === 'CXR') $('#ModalEdit #cxr_edit').prop('checked', true);
                                if (invest === 'EKG') $('#ModalEdit #ekg_edit').prop('checked', true);
                                if (invest === 'HBA1C') $('#ModalEdit #hba1c_edit').prop('checked', true);
                                if (invest === 'Other') {
                                    $('#ModalEdit #invest_other_edit').prop('checked', true);
                                    $('#ModalEdit #invest_other_text_edit').show().val(event.invest_other_text || '');
                                }
                            });
                        } catch (e) {
                            console.error('Error parsing investigations:', e);
                        }
                    }

                    // Consult Department
                    $('#ModalEdit #consult_department_edit').val(event.consult_department || '');
                    console.log('Consult Department:', event.consult_department); // Debug

                    // Blood Booking
                    if (event.blood_booking) {
                        try {
                            let bloodBooking = JSON.parse(event.blood_booking); // Parse JSON string to object
                            console.log('Parsed Blood Booking:', bloodBooking); // Debug
                            $('#ModalEdit .blood-checkbox').prop('checked', false); // Reset all checkboxes
                            if (bloodBooking.PRC) {
                                $('#ModalEdit #blood_prc_edit').prop('checked', true);
                                $('#ModalEdit #blood_prc_unit_edit').show().val(bloodBooking.PRC);
                            }
                            if (bloodBooking.FFP) {
                                $('#ModalEdit #blood_ffp_edit').prop('checked', true);
                                $('#ModalEdit #blood_ffp_unit_edit').show().val(bloodBooking.FFP);
                            }
                            if (bloodBooking.other) {
                                $('#ModalEdit #blood_other_edit').prop('checked', true);
                                $('#ModalEdit #blood_other_text_edit').show().val(bloodBooking.other);
                            }
                        } catch (e) {
                            console.error('Error parsing blood_booking:', e);
                        }
                    }

                    // Show the modal
                    $('#ModalEdit').modal('show');

                    // Trigger the change event on surgery_type to ensure the investigation section is toggled
                    $('#ModalEdit input[name="surgery_type"]:checked').trigger('change');
                    console.log('Triggered change event on surgery_type'); // Debug
                });
            },
            eventDrop: function(event, delta, revertFunc) {
                edit(event);
            },
            eventResize: function(event, dayDelta, minuteDelta, revertFunc) {
                edit(event);
            },
            locale: 'th',
            buttonText: {
                today: 'วันนี้',
                month: 'เดือน',
                week: 'สัปดาห์',
                day: 'วัน'
            },
            titleFormat: {
                month: 'MMMM YYYY',
                week: 'D MMMM YYYY',
                day: 'D MMMM YYYY'
            },
            events: [
                <?php 
                foreach ($events as $event):
                    $start = explode(" ", $event['start_datetime']);
                    $end = explode(" ", $event['end_datetime']);
                    if ($start[1] == '00:00:00') {
                        $start = $start[0];
                    } else {
                        $start = $event['start_datetime'];
                    }
                    if ($end[1] == '00:00:00') {
                        $end = $end[0];
                    } else {
                        $end = $event['end_datetime'];
                    }
                    $event_color = isset($color_map[$event['department_or']]) ? $color_map[$event['department_or']] : '#000000';
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
                    department_or: '<?php echo $event['department_or']; ?>',
                    post_surgery_booking: '<?php echo $event['post_surgery_booking']; ?>',
                    investigations: '<?php echo $event['investigations']; ?>',
                    consult_department: '<?php echo $event['consult_department']; ?>',
                    blood_booking: '<?php echo $event['blood_booking']; ?>',
                    s: '<?php echo $event['s']; ?>',
                    book: '<?php echo $event['book']; ?>',
                    de: '<?php echo $event['de']; ?>',
                    pt: '<?php echo $event['pt']; ?>',
                    backgroundColor: '<?php echo $event_color; ?>',
                    borderColor: '<?php echo $event_color; ?>'
                },
                <?php endforeach; ?>
            ]
        });

        function edit(event) {
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if (event.end) {
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            } else {
                end = start;
            }
            id = event.id;
            Event = [];
            Event[0] = id;
            Event[1] = start;
            Event[2] = end;
            
            $.ajax({
                url: 'editEventDate1.php',
                type: "POST",
                data: {Event: Event},
                success: function(rep) {
                    if (rep == 'OK') {
                        alert('Saved');
                    } else {
                        alert('Could not be saved. Try again.');
                    }
                }
            });
        }
    });
    </script>
</body>
</html>