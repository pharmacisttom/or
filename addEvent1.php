<?php
require_once('bdd.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$log_file = __DIR__ . '/add_event_log.txt';
file_put_contents($log_file, "POST Data: " . print_r($_POST, true) . "\n", FILE_APPEND);

$required_fields = [
    'patient_id', 'surgery_type', 'patient_type', 'anesthesia',
    'dx', 'op', 'surgeon', 'start_datetime', 'end_datetime', 'note', 'booked_by',
    'department', 'department_or', 'post_surgery_booking'
];

$all_fields_present = true;
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $all_fields_present = false;
        file_put_contents($log_file, "Missing or empty field: $field\n", FILE_APPEND);
        break;
    }
}

if ($all_fields_present) {
    $patient_id = $_POST['patient_id'];
    $surgery_type = $_POST['surgery_type'];
    $patient_type = $_POST['patient_type'];
    $anesthesia = $_POST['anesthesia'];
    $dx = $_POST['dx'];
    $op = $_POST['op'];
    $surgeon = $_POST['surgeon'];
    $start_datetime = str_replace('T', ' ', $_POST['start_datetime']) . ':00';
    $end_datetime = str_replace('T', ' ', $_POST['end_datetime']) . ':00';
    $note = $_POST['note'];
    $booked_by = $_POST['booked_by'];
    $department = $_POST['department'];
    $department_or = $_POST['department_or'];
    $post_surgery_booking = $_POST['post_surgery_booking'];

    // Process investigations
    $investigations = [];
    if (isset($_POST['investigations']) && is_array($_POST['investigations'])) {
        $investigations = $_POST['investigations'];
        if (in_array('Other', $investigations) && !empty($_POST['invest_other_text'])) {
            $investigations[] = $_POST['invest_other_text'];
            $key = array_search('Other', $investigations);
            if ($key !== false) {
                unset($investigations[$key]);
            }
        }
    }
    $investigations_json = json_encode(array_values($investigations), JSON_UNESCAPED_UNICODE);
    file_put_contents($log_file, "Investigations JSON: $investigations_json\n", FILE_APPEND);

    // Process consult department
    $consult_department = !empty($_POST['consult_department']) ? $_POST['consult_department'] : null;
    file_put_contents($log_file, "Consult Department: $consult_department\n", FILE_APPEND);

    // Process blood booking
    $blood_booking = [];
    if ($surgery_type === 'Elective') {
        if (isset($_POST['blood_prc']) && !empty($_POST['blood_prc_unit'])) {
            $blood_booking['PRC'] = (int)$_POST['blood_prc_unit'];
        }
        if (isset($_POST['blood_ffp']) && !empty($_POST['blood_ffp_unit'])) {
            $blood_booking['FFP'] = (int)$_POST['blood_ffp_unit'];
        }
        if (isset($_POST['blood_other']) && !empty($_POST['blood_other_text'])) {
            $blood_booking['Other'] = $_POST['blood_other_text'];
        }
    }
    $blood_booking_json = json_encode($blood_booking, JSON_UNESCAPED_UNICODE);
    file_put_contents($log_file, "Blood Booking JSON: $blood_booking_json\n", FILE_APPEND);

    $sql = "INSERT INTO surgery_bookings (
            patient_id, surgery_type, patient_type, anesthesia, dx, op, surgeon, 
            start_datetime, end_datetime, note, booked_by, department, department_or, post_surgery_booking, 
            investigations, consult_department, blood_booking
        ) VALUES (
            :patient_id, :surgery_type, :patient_type, :anesthesia, :dx, :op, :surgeon, 
            :start_datetime, :end_datetime, :note, :booked_by, :department, :department_or, :post_surgery_booking, 
            :investigations, :consult_department, :blood_booking
        )";

    $bdd->exec("SET NAMES utf8");
    $query = $bdd->prepare($sql);
    
    $query->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
    $query->bindParam(':surgery_type', $surgery_type, PDO::PARAM_STR);
    $query->bindParam(':patient_type', $patient_type, PDO::PARAM_STR);
    $query->bindParam(':anesthesia', $anesthesia, PDO::PARAM_STR);
    $query->bindParam(':dx', $dx, PDO::PARAM_STR);
    $query->bindParam(':op', $op, PDO::PARAM_STR);
    $query->bindParam(':surgeon', $surgeon, PDO::PARAM_STR);
    $query->bindParam(':start_datetime', $start_datetime, PDO::PARAM_STR);
    $query->bindParam(':end_datetime', $end_datetime, PDO::PARAM_STR);
    $query->bindParam(':note', $note, PDO::PARAM_STR);
    $query->bindParam(':booked_by', $booked_by, PDO::PARAM_STR);
    $query->bindParam(':department', $department, PDO::PARAM_STR);
    $query->bindParam(':department_or', $department_or, PDO::PARAM_STR);
    $query->bindParam(':post_surgery_booking', $post_surgery_booking, PDO::PARAM_STR);
    $query->bindParam(':investigations', $investigations_json, PDO::PARAM_STR);
    $query->bindParam(':consult_department', $consult_department, PDO::PARAM_STR);
    $query->bindParam(':blood_booking', $blood_booking_json, PDO::PARAM_STR);
    
    if ($query->execute()) {
        file_put_contents($log_file, "Success: Data inserted\n", FILE_APPEND);
        echo "OK";
    } else {
        $error = "Error: " . implode(", ", $query->errorInfo());
        file_put_contents($log_file, "$error\n", FILE_APPEND);
        echo $error;
    }
} else {
    $error = "Error: Missing required fields.";
    file_put_contents($log_file, "$error\n", FILE_APPEND);
    echo $error;
}

header('Location: index.php');
exit;
?>