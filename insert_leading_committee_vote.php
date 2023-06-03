<?php
session_start();

include 'config/config.php';

// Check if the user has already voted
$hasVoted = isset($_SESSION['hasVoted']) && $_SESSION['hasVoted'] === true;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['vote'])) {
    if (!$hasVoted) {
        // Get the selected nominees from the checkboxes
        $selectedNominees = $_POST['nominee'];

        // Perform validation on the count of selected checkboxes
        $selectedCount = count($selectedNominees);
        if ($selectedCount !== 11) {
            // Redirect back to the voting page with an error message
            $errorMessage = 'Please select exactly 11 nominees.';
            header("Location: vote_leading_committee.php?error=" . urlencode($errorMessage));
            exit();
        }

        // Prepare the INSERT statement
        $query = "INSERT INTO tbl_vote (vote_nominee, vote_position) VALUES (?, 'leading_committee')";

        // Prepare the statement
        $stmt = mysqli_prepare($db, $query);

        if ($stmt) {
            // Bind the nominee ID parameter
            mysqli_stmt_bind_param($stmt, "i", $nomineeId);

            // Iterate over the selected nominees and execute the statement for each nominee
            foreach ($selectedNominees as $nomineeId) {
                // Execute the statement
                $result = mysqli_stmt_execute($stmt);

                // Check if the execution was successful
                if (!$result) {
                    echo 'Error inserting vote: ' . mysqli_error($db);
                    break;
                }
            }

            // Close the statement
            mysqli_stmt_close($stmt);

            // Set $hasVoted to true if the voting process is successful
            $hasVoted = true;
            $_SESSION['hasVoted'] = true;

            // Redirect to the success message page
            header("Location: vote_success.php");
            exit();
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
