<?php
include 'config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>BPHWT Election | 2023</title>
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
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="vote_leading_committee.php">Vote Leading Committee</a>
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
        <div class="row"><h4>Backpack Health Worker Group (BPHWT) Election Results | June 2, 2023.</h4></div>
        <div class="row">
            <div class="col-md-3">
                <?php
                // Perform the database query
                $query = "SELECT (SELECT nominee_name FROM tbl_nominee WHERE nominee_id=vote_nominee) AS nominee_name, COUNT(vote_nominee) AS vote_count FROM tbl_vote WHERE vote_position ='leading_committee' GROUP BY vote_nominee ORDER BY COUNT(vote_nominee) DESC LIMIT 11";
                $result = mysqli_query($db, $query);

                // Check if the query was successful
                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        // Start creating the table
                        echo '<table class="table">';
                        echo '<thead><tr><th>Leading Committee Voting Results</th><th>Voted Count</th></tr></thead>';
                        echo '<tbody>';

                        // Loop through the query results and display the data in table rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['nominee_name'] . '</td>';
                            echo '<td style="text-align:right;">' . $row['vote_count'] . '</td>';
                            echo '</tr>';
                        }

                        // End the table
                        echo '</tbody></table>';
                    } else {
                        // Display a message when no data is available
                        echo 'Voting for the leading committee has not completed.';
                    }

                    // Free the result set
                    mysqli_free_result($result);
                } else {
                    // Display an error message if the query failed
                    echo 'Error executing query: ' . mysqli_error($db);
                }
                ?>

            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chairperson</h5>
                        <p class="card-text">Elected To:
                            <?php
                            $query = "SELECT nominee_name FROM tbl_nominee WHERE nominee_status='chairperson'";
                            $result = mysqli_query($db, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                echo $row['nominee_name'];
                            } else {
                                echo "<i>Election not completed</i>";
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div>
                    <?php
                    // Perform the database query
                    $chairpersonQuery = "SELECT (SELECT nominee_name FROM tbl_nominee WHERE nominee_id=vote_nominee) AS nominee_name, COUNT(vote_nominee) AS vote_count FROM tbl_vote WHERE vote_position='chairperson' GROUP BY vote_nominee ORDER BY COUNT(vote_nominee) DESC";
                    $chairpersonResult = mysqli_query($db, $chairpersonQuery);


                    // Check if the query was successful
                    if ($chairpersonResult) {
                        if (mysqli_num_rows($chairpersonResult) > 0) {
                            // Start creating the table
                            echo '<table class="table">';
                            echo '<thead><tr><th>Chairperson Voting Results</th><th>Voted Count</th></tr></thead>';
                            echo '<tbody>';

                            // Loop through the query results and display the data in table rows
                            while ($row = mysqli_fetch_assoc($chairpersonResult)) {
                                echo '<tr>';
                                echo '<td>' . $row['nominee_name'] . '</td>';
                                echo '<td style="text-align:right;">' . $row['vote_count'] . '</td>';
                                echo '</tr>';
                            }

                            // End the table
                            echo '</tbody></table>';
                        } else {
                            // Display a message when no data is available
                            echo 'Voting for the chairperson has not completed.';
                        }

                        // Free the result set
                        mysqli_free_result($chairpersonResult);
                    } else {
                        // Display an error message if the query failed
                        echo 'Error executing query: ' . mysqli_error($db);
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Secretary</h5>
                        <p class="card-text">Elected To:
                            <?php
                            $query = "SELECT nominee_name FROM tbl_nominee WHERE nominee_status='secretary'";
                            $result = mysqli_query($db, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                echo $row['nominee_name'];
                            } else {
                                echo "<i>Election not completed</i>";
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div>
                    <?php
                    // Perform the database query
                    $query = "SELECT (SELECT nominee_name FROM tbl_nominee WHERE nominee_id=vote_nominee) AS nominee_name, COUNT(vote_nominee) AS vote_count FROM tbl_vote WHERE vote_position='secretary' GROUP BY vote_nominee ORDER BY COUNT(vote_nominee) DESC";
                    $result = mysqli_query($db, $query);

                    // Check if the query was successful
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            // Start creating the table
                            echo '<table class="table">';
                            echo '<thead><tr><th>Secretary Voting Results</th><th>Voted Count</th></tr></thead>';
                            echo '<tbody>';

                            // Loop through the query results and display the data in table rows
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['nominee_name'] . '</td>';
                                echo '<td style="text-align:right;">' . $row['vote_count'] . '</td>';
                                echo '</tr>';
                            }

                            // End the table
                            echo '</tbody></table>';
                        } else {
                            // Display a message when no data is available
                            echo 'Voting for the secretary has not completed.';
                        }

                        // Free the result set
                        mysqli_free_result($result);
                    } else {
                        // Display an error message if the query failed
                        echo 'Error executing query: ' . mysqli_error($db);
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Treasurer</h5>
                        <p class="card-text">Elected To:
                            <?php
                            $query = "SELECT nominee_name FROM tbl_nominee WHERE nominee_status='treasurer'";
                            $result = mysqli_query($db, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                echo $row['nominee_name'];
                            } else {
                                echo "<i>Election not completed</i>";
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div>
                    <?php
                    // Perform the database query
                    $query = "SELECT (SELECT nominee_name FROM tbl_nominee WHERE nominee_id=vote_nominee) AS nominee_name, COUNT(vote_nominee) AS vote_count FROM tbl_vote WHERE vote_position='treasurer' GROUP BY vote_nominee ORDER BY COUNT(vote_nominee) DESC";
                    $result = mysqli_query($db, $query);

                    // Check if the query was successful
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            // Start creating the table
                            echo '<table class="table">';
                            echo '<thead><tr><th>Treasurer Voting Results</th><th>Voted Count</th></tr></thead>';
                            echo '<tbody>';

                            // Loop through the query results and display the data in table rows
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['nominee_name'] . '</td>';
                                echo '<td style="text-align:right;">' . $row['vote_count'] . '</td>';
                                echo '</tr>';
                            }

                            // End the table
                            echo '</tbody></table>';
                        } else {
                            // Display a message when no data is available
                            echo 'Voting for the treasurer has not completed.';
                        }

                        // Free the result set
                        mysqli_free_result($result);
                    } else {
                        // Display an error message if the query failed
                        echo 'Error executing query: ' . mysqli_error($db);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-dark text-center text-lg-start">
  <!-- Copyright -->
  <div class="text-center p-3 text-light" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2023 Copyright:
    <a class="text-light" href="https://backpackteam.org/">Backpack Health Worker Group</a>. Powered by <a class="text-light" href="https://ehssg.org">Ethnic Health Systems Strengthening Group (EHSSG)</a>
  </div>
  <!-- Copyright -->
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>