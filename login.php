<?php
require_once 'config/config.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted email and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query
    $sql = "SELECT * FROM tbl_user WHERE user_name = '$username'";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) == 1) {
        // User exists, verify the password
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['user_password'];

        if ($password === $storedPassword) {
            // Password is correct, set the session variables and redirect to the content page
            $_SESSION['username'] = $username;
            header("Location: dashboard/index.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid username or password.";
        }
    } else {
        // User does not exist
        echo "Invalid username or password.";
    }

    mysqli_close($con);
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Admin Panel Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">BPHWT Election Admin Panel Login</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-user-o"></span>
                    </div>
                    <h3 class="text-center mb-4">Sign In</h3>
                    <form action="" method="POST" class="login-form">
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                        <div class="form-group">
						<input type="text" name="username" class="form-control rounded-left" placeholder="Username" required>
                        </div>
                        <div class="form-group d-flex">
						<input type="password" name="password" class="form-control rounded-left" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="btn_login" class="form-control btn btn-primary rounded submit px-3">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
