<?php
    include 'config/config.php';
    // Check if the leading_committee config status is 0
$query = "SELECT config_status FROM tbl_config WHERE config_name = 'leading_committee'";
$result = mysqli_query($db, $query);

if ($result) {
    $configData = mysqli_fetch_assoc($result);
    $configStatus = $configData['config_status'];

    // Redirect to another page or display an error message if config status is 0
    if ($configStatus == 0) {
        header("Location: disabled_page.php");
        exit();
    }

    mysqli_free_result($result);
} else {
    echo 'Error executing the query: ' . mysqli_error($db);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
    .checkbox-label {
        margin-left: 8px;
    }
    </style>

    <title>Vote leading committee</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark" style="margin-bottom:20px;">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">BPHWT Election | 2023</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Vote Leading Committe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="vote_chairperson.php">Vote Chairperson</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="vote_secretary.php">Vote Secretary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="vote_treasurer.php">Vote Treasurer</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="column"><h5>Vote for Leading Committee</h5>
            </div>
        </div>
        <?php
        // Check if a error message is present in the URL query parameters
        if (isset($_GET['error'])) {
            // Get the error message
            $errorMessage = $_GET['error'];

            // Display the error message
            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        }
        ?>
        <div class="row">
            <div class="col-md-3">
                <?php
                $query = "SELECT * FROM tbl_nominee";
                $result = mysqli_query($db, $query);

                // Check if the query was successful
                if ($result) {
                    // Fetch all rows from the result set
                    $nominees = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    // Check if any rows were returned
                    if (count($nominees) > 0) {
                        echo '<form method="post" action="insert_leading_committee_vote.php" onsubmit="return validateVote();">';
                        foreach ($nominees as $nominee) {
                            $nomineeId = $nominee['nominee_id'];
                            $nomineeName = $nominee['nominee_name'];
                            echo '<div>';
                            echo '<label>';
                            echo '<input type="checkbox" name="nominee[]" value="' . $nomineeId . '">';
                            echo '<span class="checkbox-label">' . $nomineeName . '</span>';
                            echo '</label>';
                            echo '</div>';
                        }
                        echo '<br /><button type="submit" name="vote" class="btn btn-primary">Vote</button>';
                        echo '</form>';
                    } else {
                        echo 'No nominees found.';
                    }

                    // Free the result set
                    mysqli_free_result($result);
                } else {
                    echo 'Error executing the query: ' . mysqli_error($db);
                }
                // Close the database connection
                mysqli_close($db);
                ?>
            </div>
            <div class="col-md-3">
                
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <script>
        function validateVote() {
            var checkboxes = document.getElementsByName('nominee[]');
            var checkedCount = 0;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkedCount++;
                }
            }

            if (checkedCount < 11 || checkedCount > 11) {
                alert('Please select exactly 11 checkboxes.');
                return false;
            }

            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>