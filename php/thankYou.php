<?php

// Included files
include("debugging.php");
require("functionsIDD.php");
require('/home/notfound/connect.php');

/**
 * fields and validation
 */
// validation variables
$isValid = true;
$shirtArray = array('extra_small','small','medium','large','extra_large');
$stateArray = array('al', 'ak', 'as', 'az', 'ar', 'ca', 'co', 'ct', 'de', 'dc', 'fm', 'fl', 'ga', 'gu', 'hi', 'id', 'il', 'in', 'ia', 'ks', 'ky', 'la', 'me', 'mh', 'md', 'ma', 'mi', 'mn', 'ms', 'mo', 'mt', 'ne', 'nv', 'nh', 'nj', 'nm', 'ny', 'nc', 'nd', 'mp', 'oh', 'ok', 'or', 'pw', 'pa', 'pr', 'ri', 'sc', 'sd', 'tn', 'tx', 'ut', 'vt', 'vi', 'va', 'wa', 'wv', 'wi', 'wy');

//personal Info and validation
/**
 * Validates first/last name
 */
if(validName($_POST["firstName"]) === true){
    $firstName = mysqli_real_escape_string($cnxn, trim($_POST["firstName"]));
}
else{
    $isValid = false;
    $firstName = "Invalid, Name can't have numbers or special characters";
}

if(validName($_POST["lastName"]) === true){
    $lastName = mysqli_real_escape_string($cnxn, trim($_POST["lastName"]));
}
else{
    $isValid = false;
    $lastName = "Invalid, Name can't have numbers or special characters";
}

/**
 * Validates phone number
 */
if(validNumber($_POST["pNumber"]) === true){
    $phoneNumber = mysqli_real_escape_string($cnxn, trim($_POST["pNumber"]));
}
else{
    $isValid = false;
    $phoneNumber = "Invalid, Must only contain numbers";
}

/**
 * Validates email
 */
if(validMail($_POST["eMail"]) === true){
    $email = mysqli_real_escape_string($cnxn, trim($_POST["eMail"]));
}
else{
    $isValid = false;
    $email = "Invalid, Must follow the following format: example@mail.com";
}

$mailList = $_POST["onMailList"];

/**
 * Validates t-shirt sizes
 */
if(validSelect($shirtArray, $_POST["shirtSize"]) === true){
    $tShirt = mysqli_real_escape_string($cnxn, trim($_POST["shirtSize"]));
}
else{
    $isValid = false;
    $tShirt = "Please select from the options provided";
}

//address
/**
 * Validates address
 */
if(validText($_POST["street"]) === true || trim($_POST["street"]) !== ""){
    $street = mysqli_real_escape_string($cnxn, trim($_POST["street"]));
}
else{
    $isValid = false;
    $street = "Invalid, provide a valid address";
}

if(letterStrict($_POST["city"]) === true){
    $city = mysqli_real_escape_string($cnxn, trim($_POST["city"]));
}
else{
    $isValid = false;
    $city = "Invalid, can't have special characters or numbers";
}

if(validSelect($stateArray, $_POST["state"]) === true){
    $state = mysqli_real_escape_string($cnxn, trim($_POST["state"]));
}
else{
    $isValid = false;
    $state = "Please select from the given options";
}
$zip = $_POST["zip"];

//About You
$howDidHear = $_POST["howDidHear"];
$otherHowDidHear = $_POST["otherHowDidHear"];
$motivation = $_POST["motivation"];
$volExperience = $_POST["volExperience"];
$skills = $_POST["skills"];

//References
//first
$firstName1 = $_POST["refFirstName1"];
$lastName1 = $_POST["refLastName1"];
$relationship1 = $_POST["refRelationship1"];
$refPhoneNumber1 = $_POST["refPhone1"];
$refEmail1 = $_POST["refEmail1"];

//second
$firstName2 = $_POST["refFirstName2"];
$lastName2 = $_POST["refLastName2"];
$relationship2 = $_POST["refRelationship2"];
$refPhoneNumber2 = $_POST["refPhone2"];
$refEmail2 = $_POST["refEmail2"];

//third
$firstName3 = $_POST["refFirstName3"];
$lastName3 = $_POST["refLastName3"];
$relationship3 = $_POST["refRelationship3"];
$refPhoneNumber3 = $_POST["refPhone3"];
$refEmail3 = $_POST["refEmail3"];

//Send to email variables
$mailInterests = "";
$mailAvailable = "";


?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- style -->
    <link rel="stylesheet" href="../styles/style.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" />

    <title>I Day Dream | Volunteer Form</title>
</head>
<body>

<nav class="navbar navbar-expand-md sticky-top navbar-dark bg-dark info-color">
    <a class="navbar-brand font-weight-bold" href="dreamers.php">Menu |</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../volunteerFrm.html">Volunteer</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Volunteer Confirmation<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../welcome.html">Welcome</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="confirmation.php">Welcome Confirmation</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="jumbotron ">
        <h1 class="display-4">Thank You for Volunteering!</h1>
        <p class="lead">Please review the following information you have submitted</p>
    </div>

    <div class="row">
        <div class="col-6">
                <pre>
                <?php
                //Personal Information
                echo "<p>Full Name: $firstName $lastName</p>";
                echo "<p>Phone Number: $phoneNumber</p>";
                echo "<p>E-Mail: $email</p>";
                if($mailList === "checked"){
                    echo "<p>Mailing List: agreed to receive mail</p>";
                }
                else{
                    echo "<p>Mailing List: didn't agree to receive mail</p>";
                }
                echo "<p>T-shirt Size: $tShirt</p>";

                //address
                echo "<p>Address: ".$street." ".$city.", ".$state." ".$zip."</p>";

                //interests
                echo "<h5>Interests</h5>";
                if(!isset($_POST["interests"])){
                    echo "<p>None selected</p>";
                }
                else {
                    echo "<ul>";
                    foreach($_POST["interests"] as $interests) {
                        if($interests === "other"){
                            echo "<li>Other Skills: ".$_POST["interestsText"]."</li>";
                            $mailInterests .= ", {$_POST["interestsText"]}";
                        }
                        else {
                            echo "<li>" . $interests . "</li>";
                            $mailInterests .=  ", $interests";
                        }
                    }
                    echo "</ul>";
                }

                //Availability
                echo "<h5>Availability</h5>";
                if(!isset($_POST["availability"])){
                    echo "<p>None selected</p>";
                }
                else {
                    foreach($_POST["availability"] as $available) {
                        if($available === "oneWeek"){
                            echo "<p>Available for one week of Summer Camp</p>";
                            $mailAvailable .= "Available One week for Summer Camp";
                        }
                        else if($available === "weekends"){
                            echo "<p> Available: ".$_POST["weekendTimes"]."</p>";
                            $mailAvailable .=  " Available: $available";
                        }
                    }
                }

                //About you

                $otherHeardAbout = (!empty($otherHowDidHear)) ? '('.$otherHowDidHear.')' : '';
                echo "<p>How you heard about us: $howDidHear $otherHeardAbout </p>";
                echo "<p>Your Motivation: $motivation</p>";
                echo "<p>Your Experience: $volExperience</p>";
                echo "<p>Your Skills: ".$skills."</p>";


                ?>
                    </pre>
        </div>
        <div class="col-6">
            <?php
            //All three references
            echo "<h5>Reference One</h5>";
            echo "<p>Name: $firstName1 $lastName1</p>";
            echo "<p>Relationship: $relationship1</p>";
            echo "<p>E-Mail: $refEmail1</p>";
            echo "<p>Phone Number: $refPhoneNumber1</p>";

            echo "<h5>Reference Two</h5>";
            echo "<p>Name: $firstName2 $lastName2</p>";
            echo "<p>Relationship: $relationship2</p>";
            echo "<p>E-Mail: $refEmail2</p>";
            echo "<p>Phone Number: $refPhoneNumber2</p>";

            echo "<h5>Reference Three</h5>";
            echo "<p>Name: $firstName3 $lastName3</p>";
            echo "<p>Relationship: $relationship3</p>";
            echo "<p>E-Mail: $refEmail3</p>";
            echo "<p>Phone Number: $refPhoneNumber3</p>";
            ?>
        </div>
    </div>
</div>
<?php
$emailSend = "olegrovin@gmail.com";

$email_body = "Volunteer Information --\r\n";
$email_body .= "Name: $firstName $lastName \r\n";
$email_body .= "Address: $street $city". ", "."$state $zip \r\n";
$email_body .= "Interests: $mailInterests \r\n \r\n";
$email_body .= "How they heard about us: $howDidHear $otherHeardAbout \r\n";
$email_body .= "Their Motivation: $motivation \r\n";
$email_body .= "Their Experience: $volExperience \r\n";
$email_body .= "Their Skills: $skills \r\n \r\n";
$email_body .= "Their Availability: $mailAvailable \r\n \r\n";
$email_body .= "Reference One--\r\n Name: $firstName1 $lastName1\r\n Relationship: $relationship1 \r\n";
$email_body .= "E-Mail: $refEmail1\r\n  Phone Number: $refPhoneNumber1 \r\n \r\n";
$email_body .= "Reference two--\r\n Name: $firstName2 $lastName2\r\n Relationship: $relationship2 \r\n";
$email_body .= "E-Mail: $refEmail2\r\n  Phone Number: $refPhoneNumber2 \r\n \r\n";
$email_body .= "Reference three--\r\n Name: $firstName3 $lastName3\r\n Relationship: $relationship3 \r\n";
$email_body .= "E-Mail: $refEmail3\r\n  Phone Number: $refPhoneNumber3 \r\n \r\n";

$email_subject = "New Volunteer Applicant";
$to = "olegrovin@gmail.com";

$headers = "from: $email\r\n";
$headers.= "Reply-to: $email \r\n";
$success = mail($to, $email_subject, $email_body, $headers);

//Print final confirmation
$msg = $success ? "Your form was successfully submitted."
    : "We're sorry. There was a problem with your form.";
echo "<p>$msg</p>";
?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
