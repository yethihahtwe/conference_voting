<?php
session_start();

include 'config/config.php';

// Check if the user has already voted
$hasSecretaryVoted = isset($_SESSION['hasSecretaryVoted']) && $_SESSION['hasSecretaryVoted'] === true;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['vote'])) {
    if (!$hasSecretaryVoted) {
        // Get the selected nominee from the radio button
        $selectedNominee = $_POST['nominee'];

        // Prepare the INSERT statement
        $query = "INSERT INTO tbl_vote (vote_nominee, vote_position) VALUES (?, 'secretary')";

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

                // Set $hasSecretaryVoted to true if the voting process is successful
                $hasSecretaryVoted = true;
                $_SESSION['hasSecretaryVoted'] = true;

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