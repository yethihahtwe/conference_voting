<?php
    include '../config/config.php';
    $query = "SELECT * FROM tbl_nominee";
    $result = mysqli_query($db, $query);
    if (!$result) {
    die("Database query failed: " . mysqli_error($db));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Nominees</title>
    <style>
         
 .loading-icon {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
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
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="nominee-list.php">Nominees</a>
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
    <div class="container" style="margin-top:20px;">
        <div class="table-header" style="margin-bottom:10px;">
        <button id="addNewButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewModal">Add Nominee</button>
        </div>
        <table id="dataTable" style="width:50%;">
            <thead>
                <tr>
                    <th>Nominee Name</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Loop through the query result and generate table rows
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['nominee_name'] . "</td>";
                echo "<td>" . $row['nominee_gender'] . "</td>";
                echo "<td>" . $row['nominee_status'] . "</td>";
                echo "<td><a href='edit_nominee.php?id={$row['nominee_id']}'>Edit</a></td>";
                echo "<td><a href='delete_nominee.php?id={$row['nominee_id']}' onclick='return confirm(\"Are you sure you want to delete this nominee?\")'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <!-- Add New Modal -->
    <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewModalLabel">Add New Nominee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="save_nominee.php" method="POST" onsubmit="return showSuccessMessage();">
            <div class="modal-body">
                <!-- Add your form fields here -->
                
                    <div class="form-group">
                        <label class="form-label">Name:</label>
						<input type="text" name="nominee_name" class="form-control rounded-left" placeholder="Name of the new nominee" required>
                    </div><br />
                    <div class="form-group">
                        <label class="form-label">Gender:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="maleRadio" value="Male">
                            <label class="form-check-label" for="maleRadio">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="femaleRadio" value="Female">
                            <label class="form-check-label" for="femaleRadio">Female</label>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    <div id="loadingIcon" class="loading-icon">
    <div class="spinner"></div>
    </div>
    <script>
    $(document).ready(function() {
        $('#saveButton').click(function() {
            // Show loading icon
            $('#loadingIcon').show();

            // Disable the "Save" button
            $(this).prop('disabled', true);

            // Submit the form
            $('form').submit();
        });
    });
</script>

<script>
    // Function to show success message and close modal
function showSuccessMessage() {
    // Display success message
    $('#successMessage').show();

    // Close modal after 1 seconds
    setTimeout(function() {
        $('#addNewModal').modal('hide');
        $('#dataTable').DataTable().ajax.reload(); // Reload DataTable
    }, 2000);

    return true; // Return true to submit the form
}
</script>
<div id="successMessage" class="alert alert-success" style="display: none;">
    Nominee saved successfully!
</div>
<script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                paging:false,
                });
        });
    </script>
</body>
</html>
