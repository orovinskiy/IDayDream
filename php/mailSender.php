<?php

// Start a session
session_start();

// If user is not logged in, reroute them to the login page
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}

//files to help the page run
include 'debugging.php';
require('/home/notfound/connect.php');
require("functionsIDD.php");

//captured variables from input
$subject = trim($_POST['subject']);
$compose = trim($_POST['compose']);
$pageType = $_POST['select'];
$isValid = true;

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
    <link rel="shortcut icon" href="../images/favicon.png"/>

    <title>Email Confirmation</title>
</head>
<body class="bg-color">

<!-- Header -->
<div class="jumbotron banner">
    <h1 class="display-4 text-white font-weight-bold">Email</h1>
</div>

<div class="container width">

    <section class="card shadow mb-5">
        <h3 class="card-title titleColor text-white text-center mb-4 py-2">Confirmation</h3>

        <fieldset class="m-0 p-4">
            <?php

            //Makes sure all the fields are not empty
            if(!validReqText($subject)){
                $subjectEcho = "<p>Error: The Subject field was left empty</p>";
                $isValid = false;
            }
            else{
                $subjectEcho = "<p class='h6'><b>Subject:</b> $subject</p>";
            }

            if(!validReqText($compose)){
                $composeEcho = "<p>Error: The Compose field was left empty</p>";
                $isValid = false;
            }
            else{
                $composeEcho = "<p class='h6'><b>Message:</b> $compose</p>";
            }

            //looks to see witch connection to use. 1 is described as active
            if($pageType === 'dream'){
                $sql = "SELECT email FROM `person` INNER JOIN participant ON participant.personId = person.personId WHERE activity = 1";

                $result = mysqli_query($cnxn, $sql);
            }
            else{
                $sql = "SELECT email FROM `person` INNER JOIN volunteer ON volunteer.personId = person.personId WHERE activity = 1";

                $result = mysqli_query($cnxn, $sql);
            }

            //as long there is a new row then a new email will be sent to the user
            if($isValid){
                $count = 0;
                while($row = mysqli_fetch_assoc($result)){

                    $email = $row['email'];

                    $email_body = "I Day Dream --\r\n";
                    $email_body .= "$compose \r\n";



                    $email_subject = $subject;
                    $to = $email;//The active user goes here

                $headers = "from: IDayDream@gmail.com\r\n";
                $headers.= "Reply-to: IDayDream@gmail.com \r\n";
                $count++;

                    $success = mail($to, $email_subject, $email_body, $headers);

                    /*
                    $msg = $success ? "Your form was successfully submitted."
                        : "We're sorry. There was a problem with your form.";
                    echo "<p>$msg</p>";*/
                }
            }

            echo "<p class='h6'><b>$count emails were sent</b></p>
                    <br>
                    $subjectEcho
                    <br>
                    $composeEcho";

            ?>
        </fieldset>
    </section>
</div>

</body>
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
</html>
