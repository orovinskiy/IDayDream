<?php

// Start a session
session_start();

$invalidLogin = "<p class='text-center mb-4 py-2'>&nbsp</p>";

// If the user is already logged in
if (isset($_SESSION['username'])) {
    header('location: index.php');
}

// Included files
include('debugging.php');

// Once the login form has been submitted
if (isset($_POST['submit'])) {

    // Include the file that contains the active credentials
    require('creds.php');


    // Get the username and password from the POST array
    $username = $_POST['username'];
    $password = $_POST['password'];


    // If the username and password are correct
    if (array_key_exists($username, $creds) && $creds["$username"] == $password) {
        // Store username in a session variable
        $_SESSION['username'] = $username;

        // Redirect to the database with valid credentials
        header('location: index.php');
    }

    // Login credentials are incorrect
    $invalidLogin = "<p class='text-center text-danger table-danger rounded-0 mb-4 py-2'>Invalid Login</p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/css/mdb.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/form.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.png"/>

    <title>Log In</title>
</head>
<body class="bg-color">
<div class="container widthLogin mt-5 pb-5">
    <section class="card shadow">
        <form method="post" action="#" class="">
            <h3 class="card-title titleColor text-white text-center py-2">Log In</h3>

            <div class="card-body">
                <?php echo $invalidLogin ?>

                <!--Username input field-->
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-control shadow-sm">
                </div>
                <br>

                <!--Password input field-->
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control shadow-sm">
                </div>
                <br>

                <!--Submit button-->
                <div class="text-center">
                    <input type="submit" name="submit" value="Submit" class="btn btn-dark shadow-sm rounded-0">
                </div>
                <br>

                <!--HINT-->
                <p class="text-center pb-4">
                    Username: admin<br>
                    Password: iD@yDr3@m<br>
                    (This will be removed)
                </p>
            </div><!-- Card Body -->
        </form>
    </section><!-- Card -->
</div><!-- Container -->


<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
