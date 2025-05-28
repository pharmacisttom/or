<?php
// search_patient.php

// Database connection details (replace with your actual credentials)
$servername = "192.168.111.251";
$username = "root";
$password = "boom123";
$dbname_opd = "opd.opd"; // Replace with your OPD database name
$dbname_ipd = "ipd.ipd"; // Replace with your IPD database name

// Function to display results in a user-friendly way (e.g., a table)
function displayResults($results, $from_system) {
    if (empty($results)) {
        echo "<p>No results found.</p>";
        return;
    }
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>HN</th><th>ชื่อ-นามสกุล</th><th>อายุ</th><th>AN</th><th></th></tr></thead>";
    echo "<tbody>";
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>{$row['hn']}</td>";
        echo "<td>{$row['fullname']}</td>";
        echo "<td>{$row['yage']}</td>";
        echo "<td>{$row['an']}</td>";
        echo "<td><button class='btn btn-success' onclick='populateForm(" . json_encode($row) . ",\"$from_system\")'>เลือก</button></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}

// Handle search request by HN
if (isset($_POST['hn'])) {
    $hn = $_POST['hn'];

    // Search in OPD
    $conn_opd = new mysqli($servername, $username, $password, $dbname_opd);
    if ($conn_opd->connect_error) {
        die("Connection to OPD failed: " . $conn_opd->connect_error);
    }
    $sql_opd = "SELECT hn, fullname, yage , an FROM opd_table WHERE hn = '$hn'"; // Replace 'opd_table' with your OPD table name
    $result_opd = $conn_opd->query($sql_opd);
    if ($result_opd->num_rows > 0) {
        $results_opd = $result_opd->fetch_all(MYSQLI_ASSOC);
        displayResults($results_opd,"opd");
    }
   
     // Search in IPD
    $conn_ipd = new mysqli($servername, $username, $password, $dbname_ipd);
    if ($conn_ipd->connect_error) {
        die("Connection to IPD failed: " . $conn_ipd->connect_error);
    }
    $sql_ipd = "SELECT hn, fullname, yage , an FROM ipd_table WHERE hn = '$hn'"; // Replace 'ipd_table' with your IPD table name
    $result_ipd = $conn_ipd->query($sql_ipd);
    if ($result_ipd->num_rows > 0) {
        $results_ipd = $result_ipd->fetch_all(MYSQLI_ASSOC);
        displayResults($results_ipd,"ipd");
    }


    $conn_opd->close();
    $conn_ipd->close();

}else if(isset($_POST['fullName'])){
    // Handle search request by full name
    $fullName = $_POST['fullName'];

    // Search in OPD
    $conn_opd = new mysqli($servername, $username, $password, $dbname_opd);
    if ($conn_opd->connect_error) {
        die("Connection to OPD failed: " . $conn_opd->connect_error);
    }
    $sql_opd = "SELECT hn, fullname, yage , an FROM opd_table WHERE fullname LIKE '%$fullName%'"; // Replace 'opd_table' with your OPD table name
    $result_opd = $conn_opd->query($sql_opd);
     if ($result_opd->num_rows > 0) {
        $results_opd = $result_opd->fetch_all(MYSQLI_ASSOC);
        displayResults($results_opd,"opd");
    }
   
     // Search in IPD
    $conn_ipd = new mysqli($servername, $username, $password, $dbname_ipd);
    if ($conn_ipd->connect_error) {
        die("Connection to IPD failed: " . $conn_ipd->connect_error);
    }
    $sql_ipd = "SELECT hn, fullname, yage , an FROM ipd_table WHERE fullname LIKE '%$fullName%'"; // Replace 'ipd_table' with your IPD table name
    $result_ipd = $conn_ipd->query($sql_ipd);
     if ($result_ipd->num_rows > 0) {
        $results_ipd = $result_ipd->fetch_all(MYSQLI_ASSOC);
        displayResults($results_ipd,"ipd");
    }

    $conn_opd->close();
    $conn_ipd->close();
}else {
    echo ""; // Empty response
}
?>
