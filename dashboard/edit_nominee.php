<?php
require_once '../config/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $nomineeId = $_POST['nominee_id'];
    $nomineeName = $_POST['nominee_name'];
    $nomineeGender = $_POST['gender'];
    $nomineeStatus = $_POST['status'];

    // Prepare and execute the SQL query to update the nominee
    $sql = "UPDATE tbl_nominee SET nominee_name = '$nomineeName', nominee_gender = '$nomineeGender', nominee_status = '$nomineeStatus' WHERE nominee_id = $nomineeId";
    $result = mysqli_query($db, $sql);

    if ($result) {
        // Data updated successfully
        $_SESSION['success_message'] = "Nominee updated successfully.";
        header("Location: nominee-list.php?success=1");
        exit();
    } else {
        // Error in executing the query
        echo "Error: " . mysqli_error($db);
    }

    mysqli_close($db);
}

// Check if the nominee ID is provided in the URL
if (isset($_GET['id'])) {
    $nomineeId = $_GET['id'];

    // Retrieve the nominee data based on the ID
    $sql = "SELECT * FROM tbl_nominee WHERE nominee_id = $nomineeId";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $nomineeData = mysqli_fetch_assoc($result);
    } else {
        // Error in executing the query
        echo "Error: " . mysqli_error($db);
        exit();
    }
} else {
    // No nominee ID provided
    echo "Nominee ID is missing.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Edit Nominee</title>
</head>
<body>
    <div class="container">
        <h2>Edit Nominee</h2>
        <form action="edit_nominee.php" method="POST">
            <input type="hidden" name="nominee_id" value="<?php echo $nomineeData['nominee_id']; ?>">
            <div class="mb-3">
                <label for="nominee_name" class="form-label">Nominee Name:</label>
                <input type="text" name="nominee_name" class="form-control" id="nominee_name" value="<?php echo $nomineeData['nominee_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="maleRadio" value="Male" <?php if ($nomineeData['nominee_gender'] == 'Male') echo 'checked'; ?>>
                    <label class="form-check-label" for="maleRadio">Male</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="femaleRadio" value="Female" <?php if ($nomineeData['nominee_gender'] == 'Female') echo 'checked'; ?>>
                    <label class="form-check-label" for="femaleRadio">Female</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-select" name="status" id="status">
                     <option value="" <?php if (empty($nomineeData['nominee_status'])) echo 'selected'; ?>>Please select</option>
                    <option value="leading_committee" <?php if ($nomineeData['nominee_status'] == 'leading_committee') echo 'selected'; ?>>leading_committee</option>
                    <option value="chairperson" <?php if ($nomineeData['nominee_status'] == 'chairperson') echo 'selected'; ?>>chairperson</option>
                    <option value="secretary" <?php if ($nomineeData['nominee_status'] == 'secretary') echo 'selected'; ?>>secretary</option>
                    <option value="treasurer" <?php if ($nomineeData['nominee_status'] == 'treasurer') echo 'selected'; ?>>treasurer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</body>
</html>
