<?php

//files to help the page run
include 'debugging.php';
require('/home/notfound/connect.php');
require("functionsIDD.php");

//captured variables from input
$from = trim($_POST['from']);
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Send Emails</title>
</head>
<body>
<div class="container">
    <div class="jumbotron banner">
        <h1>Confirmation</h1>
    </div>

    <?php
    //Makes sure all the fields are not empty
        if(!validReqText($from)){
            echo "<p>Error: The From field was left empty</p>";
            $isValid = false;
        }
        else{
            echo "<p>From: $from</p>";
        }

        if(!validReqText($subject)){
            echo "<p>Error: The Subject field was left empty</p>";
            $isValid = false;
        }
        else{
            echo "<p>Subject: $subject</p>";
        }

        if(!validReqText($compose)){
            echo "<p>Error: The Compose field was left empty</p>";
            $isValid = false;
        }
        else{
            echo "<p>Message: $compose</p>";
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

                $headers = "from: $from\r\n";
                $headers.= "Reply-to: $from \r\n";
                $count++;

                $success = mail($to, $email_subject, $email_body, $headers);

                /*
                $msg = $success ? "Your form was successfully submitted."
                    : "We're sorry. There was a problem with your form.";
                echo "<p>$msg</p>";*/
            }
            echo "<h6>$count emails were sent</h6>";
        }
    ?>

</div>

</body>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>
