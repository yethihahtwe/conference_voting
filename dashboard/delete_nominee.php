<?php
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['id'])) {
        $nomineeId = $_GET['id'];

        // Prepare and execute the SQL query
        $sql = "DELETE FROM tbl_nominee WHERE nominee_id = '$nomineeId'";
        $result = mysqli_query($db, $sql);

        if ($result) {
            // Nominee deleted successfully
            mysqli_close($db);
            header("Location: nominee-list.php?success=1");
            exit();
        } else {
            // Error in executing the query
            echo "Error: " . mysqli_error($db);
        }
    }
    else {
        // Nominee ID not provided
        echo "Nominee ID not provided.";
    }
}
?>