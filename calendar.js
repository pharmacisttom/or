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