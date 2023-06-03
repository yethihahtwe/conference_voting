<?php
session_start();

include 'config/config.php';

// Check if the user has already voted
$hasTreasurerVoted = isset($_SESSION['hasTreasurerVoted']) && $_SESSION['hasTreasurerVoted'] === true;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['vote'])) {
    if (!$hasTreasurerVoted) {
        // Get the selected nominee from the radio button
        $selectedNominee = $_POST['nominee'];

        // Prepare the INSERT statement
        $query = "INSERT INTO tbl_vote (vote_nominee, vote_position) VALUES (?, 'treasurer')";

        // Prepare the statement
        $stmt = mysqli_prepare($db, $query);

        if ($stmt) {
            // Bind the nominee ID parameter
            mysqli_stmt_bind_param($stmt, "i", $selectedNominee);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            // Check if the execution was successful
            if ($result) {
                // Close the statement
                mysqli_stmt_close($stmt);

                // Set $hasTreasurerVoted to true if the voting process is successful
                $hasTreasurerVoted = true;
                $_SESSION['hasTreasurerVoted'] = true;

                // Redirect to the success message page
                header("Location: vote_success.php");
                exit();
            } else {
                echo 'Error inserting vote: ' . mysqli_error($db);
            }
        } else {
            echo 'Error preparing statement: ' . mysqli_error($db);
        }
    } else {
        // User has already voted, handle the error or display a message
        // Redirect to the same page with an error message or display an error message here
        echo 'You have already voted.';
        echo '<a href="index.php" class="btn btn-primary">Go Back to Home Page</a>';
    }
}

// Close the database connection
mysqli_close($db);
?>