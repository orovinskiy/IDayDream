<?php

// Start a session
session_start();

// If user is not logged in, reroute them to the login page
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}

// Included files
include('debugging.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
    <link rel="shortcut icon" href="images/favicon.png" />

    <title>Admin Page</title>
</head>
<body class="bg-color">

<div class="jumbotron banner mb-0 rounded-0 shadow">
    <h1 class="display-4 text-white font-weight-bold">ADMIN RESOURCES</h1>
</div>

<?php
require('nav.php');
?>

<div class="container width">

    <div class="row mt-5">
        <div class="col-10 offset-1 col-sm-5 offset-sm-1 mb-3 mb-sm-0">
            <section class="card shadow">

                <h3 class="card-title titleColor text-white text-center mb-4 py-2"><abbr title="Links to your forms">Forms</abbr></h3>

                <div class="card-body">
                    <!-- Volunteer Form -->
                    <a class="btn btn-dark mt-0 mb-1" href="../volunteerFrm.html" role="button">Volunteer</a>

                    <!-- Welcome Form -->
                    <a class="btn btn-dark mt-0 mb-1" href="../welcome.html" role="button">Dreamer</a>
                </div><!-- Card Body -->
            </section><!-- Card -->
        </div><!-- Column -->

        <div class="col-10 offset-1 col-sm-5 offset-sm-0 pb-5">
            <section class="card shadow">

                <h3 class="card-title titleColor text-white text-center mb-4 py-2"><abbr title="Links to the databases of each form">Databases</abbr></h3>

                <div class="card-body">
                    <!-- Volunteer Database -->
                    <a class="btn btn-dark mt-0 mb-1" href="volunteers.php" role="button">Volunteer</a>

                    <!-- Dreamers -->
                    <a class="btn btn-dark mt-0 mb-1" href="dreamers.php" role="button">Dreamer</a>
                </div><!-- Card Body -->
            </section><!-- Card -->
        </div><!-- Column -->
    </div><!-- Row -->
</div><!-- Container -->


<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>
<script src="javascript/welcomeFrm.js"></script>
</body>
</html>
