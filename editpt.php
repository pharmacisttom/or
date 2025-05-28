<?php

require('config.php');
session_start(); // add this

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve data from the form (and sanitize if needed)
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0; // Get id and convert to integer. Default to 0 if not set.
    $an = isset($_POST['an']) ? trim($_POST['an']) : '';  // Sanitize by trimming whitespace
    $hn = isset($_POST['hn']) ? trim($_POST['hn']) : '';
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $yage = isset($_POST['yage']) ? trim($_POST['yage']) : '';
    $weight = isset($_POST['weight']) ? trim($_POST['weight']) : '';
    $height = isset($_POST['height']) ? trim($_POST['height']) : '';
    $chronic_disease = isset($_POST['chronic_disease']) ? trim($_POST['chronic_disease']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $regdate = isset($_POST['regdate']) ? trim($_POST['regdate']) : '';
    $pp = isset($_POST['pp']) ? trim($_POST['pp']) : '';

    // Check if ID is available
    if ($id == 0) {
        echo "Error: Patient ID is missing";
        exit;
    }

      // Check for duplicate 'an' only if it's not empty
      if (!empty($an)) {
        $check_duplicate_sql = "SELECT id FROM patients WHERE an = ? AND id != ?";
        $check_duplicate_stmt = mysqli_prepare($conn, $check_duplicate_sql);

        if (!$check_duplicate_stmt) {
            echo "Error preparing duplicate check statement: " . mysqli_error($conn);
            exit;
        }

        mysqli_stmt_bind_param($check_duplicate_stmt, "si", $an, $id); // 's' for string, 'i' for integer
        mysqli_stmt_execute($check_duplicate_stmt);
        mysqli_stmt_store_result($check_duplicate_stmt);

        if (mysqli_stmt_num_rows($check_duplicate_stmt) > 0) {
           echo "<script>alert('Error: Duplicate AN. AN already exists in the database.'); window.location.href='pt.php';</script>";
           mysqli_stmt_close($check_duplicate_stmt);
           exit; // exit
        }

        mysqli_stmt_close($check_duplicate_stmt);
    }else{
        $an = NULL; // Set AN to NULL if it's empty.
    }

    // Prepare the SQL statement (using placeholders)
    $sql = "UPDATE patients SET 
            an = ?, 
            hn = ?, 
            fullname = ?,
            yage = ?,
            weight = ?,
            height = ?, 
            chronic_disease = ?, 
            phone = ?, 
            regdate = ?, 
            pp = ? 
            WHERE id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "Error preparing statement: " . mysqli_error($conn);
        exit;
    }

    // Bind parameters (specify data types)
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssi", // Data types: s = string, i = integer
        $an,
        $hn,
        $fullname,
        $yage,
        $weight,
        $height,
        $chronic_disease,
        $phone,
        $regdate,
        $pp,
        $id
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Success!
        // header("location: pt.php"); // Remove this line
        $_SESSION['success'] = true; // Add success message in session
        header("location: pt.php?success=true"); // Redirect with success parameter
        exit(0);
    } else {
        // Error
         echo "<script>alert('Error updating data: " . mysqli_error($conn) . "'); window.location.href='pt.php';</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);

} else {
    echo "Form not submitted.";
}
?>
