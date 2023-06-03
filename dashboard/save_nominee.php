<?php
require_once '../config/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $nomineeName = $_POST['nominee_name'];
    $nomineeGender = $_POST['gender'];

    // Prepare and execute the SQL query
    $sql = "INSERT INTO tbl_nominee (nominee_name, nominee_gender) VALUES ('$nomineeName', '$nomineeGender')";
    $result = mysqli_query($db, $sql);

    if ($result) {
        // Data inserted successfully
        mysqli_close($db);
        $_SESSION['success_message'] = "Data saved successfully.";
        header("Location: nominee-list.php?success=1");
        exit();
    } else {
        // Error in executing the query
        echo "Error: " . mysqli_error($db);
    }
}
?>
