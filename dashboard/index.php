<?php
session_start();

// Check if the session variable exists
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page or any other appropriate page
    header("Location: ../login.php");
    exit();
}

// The user is logged in, continue with the rest of the file's code
require_once '../config/config.php';

$isVotingEnabled = isVotingEnabledFromConfigTable();
$isChairpersonVotingEnabled = isChairpersonVotingEnabledFromConfigTable();
$isSecretaryVotingEnabled = isSecretaryVotingEnabledFromConfigTable();
$isTreasurerVotingEnabled = isTreasurerVotingEnabledFromConfigTable();

// Function to check if leading committee voting is enabled from the configuration table
function isVotingEnabledFromConfigTable()
{
    global $db;

    $query = "SELECT config_status FROM tbl_config WHERE config_name = 'leading_committee'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $votingStatus = $row['config_status'];

        return ($votingStatus == 1);
    }

    return false;
}

// Function to check if chairperson voting is enabled from the configuration table
function isChairpersonVotingEnabledFromConfigTable()
{
    global $db;

    $query = "SELECT config_status FROM tbl_config WHERE config_name = 'chairperson'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $votingStatus = $row['config_status'];

        return ($votingStatus == 1);
    }

    return false;
}

// Function to check if secretary voting is enabled from the configuration table
function isSecretaryVotingEnabledFromConfigTable()
{
    global $db;

    $query = "SELECT config_status FROM tbl_config WHERE config_name = 'secretary'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $votingStatus = $row['config_status'];

        return ($votingStatus == 1);
    }

    return false;
}

// Function to check if treasurer voting is enabled from the configuration table
function isTreasurerVotingEnabledFromConfigTable()
{
    global $db;

    $query = "SELECT config_status FROM tbl_config WHERE config_name = 'treasurer'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $votingStatus = $row['config_status'];

        return ($votingStatus == 1);
    }

    return false;
}

// Handle form submission to enable/disable voting
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enable_voting'])) {
        setVotingStatus(true);
        header("Refresh:0");
    } elseif (isset($_POST['disable_voting'])) {
        setVotingStatus(false);
        header("Refresh:0");
    } elseif (isset($_POST['enable_chairperson_voting'])) {
        setChairpersonVotingStatus(true);
        header("Refresh:0");
    } elseif (isset($_POST['disable_chairperson_voting'])) {
        setChairpersonVotingStatus(false);
        header("Refresh:0");
    } elseif (isset($_POST['enable_secretary_voting'])) {
        setSecretaryVotingStatus(true);
        header("Refresh:0");
    } elseif (isset($_POST['disable_secretary_voting'])) {
        setSecretaryVotingStatus(false);
        header("Refresh:0");
    } elseif (isset($_POST['enable_treasurer_voting'])) {
        setTreasurerVotingStatus(true);
        header("Refresh:0");
    } elseif (isset($_POST['disable_treasurer_voting'])) {
        setTreasurerVotingStatus(false);
        header("Refresh:0");
    }
}

// Function to set the voting status in the configuration table
function setVotingStatus($status)
{
    global $db;

    $votingStatus = $status ? 1 : 0;

    $query = "UPDATE tbl_config SET config_status = '$votingStatus' WHERE config_name='leading_committee'";
    $result = mysqli_query($db, $query);

    if (!$result) {
        die("Error updating voting status: " . mysqli_error($db));
    }
}

// Function to set the chairperson voting status in the configuration table
function setChairpersonVotingStatus($chairpersonStatus)
{
    global $db;

    $votingStatus = $chairpersonStatus ? 1 : 0;

    $query = "UPDATE tbl_config SET config_status = '$votingStatus' WHERE config_name='chairperson'";
    $result = mysqli_query($db, $query);

    if (!$result) {
        die("Error updating chairperson voting status: " . mysqli_error($db));
    }
}

// Function to set the secretary voting status in the configuration table
function setSecretaryVotingStatus($secretaryStatus)
{
    global $db;

    $votingStatus = $secretaryStatus ? 1 : 0;

    $query = "UPDATE tbl_config SET config_status = '$votingStatus' WHERE config_name='secretary'";
    $result = mysqli_query($db, $query);

    if (!$result) {
        die("Error updating secretary voting status: " . mysqli_error($db));
    }
}

// Function to set the treasurer voting status in the configuration table
function setTreasurerVotingStatus($treasurerStatus)
{
    global $db;

    $votingStatus = $treasurerStatus ? 1 : 0;

    $query = "UPDATE tbl_config SET config_status = '$votingStatus' WHERE config_name='treasurer'";
    $result = mysqli_query($db, $query);

    if (!$result) {
        die("Error updating secretary voting status: " . mysqli_error($db));
    }
}

mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>BPHWT Election Admin Panel</title>
</head>
<body> 
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark" data-bs-theme="dark" style="margin-bottom:20px;">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">BPHWT Election Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="nominee-list.php">Nominees</a>
                </li>
            </ul>
             <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Leading Committee</h5>
                        <p class="card-text">Voting Status: <?php echo $isVotingEnabled ? "Enabled" : "Disabled"; ?></p>
                        <form method="post">
                            <?php if ($isVotingEnabled): ?>
                                <button type="submit" class="btn btn-danger" name="disable_voting">Disable Voting</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-success" name="enable_voting">Enable Voting</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chairperson</h5>
                        <p class="card-text">Voting Status: <?php echo $isChairpersonVotingEnabled ? "Enabled" : "Disabled"; ?></p>
                        <form method="post">
                            <?php if ($isChairpersonVotingEnabled): ?>
                                <button type="submit" class="btn btn-danger" name="disable_chairperson_voting">Disable Voting</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-success" name="enable_chairperson_voting">Enable Voting</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Secretary</h5>
                        <p class="card-text">Voting Status: <?php echo $isSecretaryVotingEnabled ? "Enabled" : "Disabled"; ?></p>
                        <form method="post">
                            <?php if ($isSecretaryVotingEnabled): ?>
                                <button type="submit" class="btn btn-danger" name="disable_secretary_voting">Disable Voting</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-success" name="enable_secretary_voting">Enable Voting</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Treasurer</h5>
                        <p class="card-text">Voting Status: <?php echo $isTreasurerVotingEnabled ? "Enabled" : "Disabled"; ?></p>
                        <form method="post">
                            <?php if ($isTreasurerVotingEnabled): ?>
                                <button type="submit" class="btn btn-danger" name="disable_treasurer_voting">Disable Voting</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-success" name="enable_treasurer_voting">Enable Voting</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
