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
$interstArray = array('newsletter','events','fundraising','coordination','mentoring','other');
$availableArray = array('oneWeek','weekends');
$youHeardArray = array('none','word','web','print','corporate','other');


//personal Info and validation
/**
 * Validates first/last name
 */
if(validName($_POST["firstName"])){
    $firstName = mysqli_real_escape_string($cnxn, trim($_POST["firstName"]));
}
else{
    $isValid = false;
    $firstName = "Invalid, Name can't have numbers or special characters";
}

if(validName($_POST["lastName"])){
    $lastName = mysqli_real_escape_string($cnxn, trim($_POST["lastName"]));
}
else{
    $isValid = false;
    $lastName = "Invalid, Name can't have numbers or special characters";
}

/**
 * Validates phone number
 */
if(validNumber($_POST["pNumber"])){
    $phoneNumber = mysqli_real_escape_string($cnxn, trim($_POST["pNumber"]));
}
else{
    $isValid = false;
    $phoneNumber = "Invalid, Must only contain numbers";
}

/**
 * Validates email
 */
if(validMail($_POST["eMail"])){
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
if(validSelect($shirtArray, $_POST["shirtSize"])){
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
if(validText($_POST["street"]) && trim($_POST["street"]) !== ""){
    $street = mysqli_real_escape_string($cnxn, trim($_POST["street"]));
}
else{
    $isValid = false;
    $street = "Invalid, provide a valid address";
}

if(letterStrict($_POST["city"])){
    $city = mysqli_real_escape_string($cnxn, trim($_POST["city"]));
}
else{
    $isValid = false;
    $city = "Invalid, can't have special characters or numbers";
}

if(validSelect($stateArray, $_POST["state"])){
    $state = mysqli_real_escape_string($cnxn, trim($_POST["state"]));
}
else{
    $isValid = false;
    $state = "Invalid, please select from the given options";
}

if(numberStrict($_POST["zip"])){
    $zip = mysqli_real_escape_string($cnxn, trim($_POST["zip"]));
}
else{
    $isValid = false;
    $zip = "Invalid, only numbers are aloud";
}


//About You
/**
 * Validate text boxes
 */
if(validSelect($youHeardArray,$_POST["howDidHear"])){
    $howDidHear = mysqli_real_escape_string($cnxn, trim($_POST["howDidHear"]));
}
else{
    $isValid = false;
    $howDidHear = "Illegal Selection";
}

if(validText($_POST["otherHowDidHear"])){
    $otherHowDidHear = mysqli_real_escape_string($cnxn, trim($_POST["otherHowDidHear"]));
}
else{
    $isValid = false;
    $otherHowDidHear = "Illegal Phrase";
}

if(validText($_POST["motivation"]) && trim($_POST["motivation"]) !== ""){
    $motivation = mysqli_real_escape_string($cnxn, trim($_POST["motivation"]));
}
else{
    $isValid = false;
    $motivation = "Invalid, must be provided";
}

if(validText($_POST["volExperience"])){
    $volExperience = mysqli_real_escape_string($cnxn, trim($_POST["volExperience"]));
}
else{
    $isValid = false;
    $volExperience = "Illegal Phrase";
}

if(validText($_POST["skills"])){
    $skills = mysqli_real_escape_string($cnxn, trim($_POST["skills"]));
}
else{
    $isValid = false;
    $skills = "Illegal Phrase";
}

//References
/**
 * Validates all three references
 */

//catchers so the aligned values wouldn't disappear
$firstArray = array();
$lastArray = array();
$relationArray = array();
$pNumberArray = array();
$mailArray = array();

for($i = 1; $i < 4; $i++){
    if(validName($_POST["refFirstName".$i])){
        $firstArray[$i] = mysqli_real_escape_string($cnxn, trim($_POST["refFirstName".$i]));
    }
    else{
        $isValid = false;
        $firstArray[$i] = "Invalid, can't have numbers or special characters";
    }

    if(validName($_POST["refLastName".$i])){
        $lastArray[$i] = mysqli_real_escape_string($cnxn, trim($_POST["refLastName".$i]));
    }
    else{
        $isValid = false;
        $lastArray[$i] = "Invalid, can't have numbers or special characters";
    }

    if(validName($_POST["refRelationship".$i])){
        $relationArray[$i] = mysqli_real_escape_string($cnxn, trim($_POST["refRelationship".$i]));
    }
    else{
        $isValid = false;
        $relationArray[$i] = "Invalid, can't have numbers or special characters";
    }

    if(validNumber($_POST["refPhone".$i])){
        $pNumberArray[$i] = mysqli_real_escape_string($cnxn, trim($_POST["refPhone".$i]));
    }
    else{
        $isValid = false;
        $pNumberArray[$i] = "Invalid, can't have letters or special characters";
    }

    if(validMail($_POST["refEmail".$i])){
        $mailArray[$i] = mysqli_real_escape_string($cnxn, trim($_POST["refEmail".$i]));
    }
    else{
        $isValid = false;
        $mailArray[$i] = "Invalid, must follow this format 'example@mail.net'";
    }


}

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

    <?php

    //Validates agree button and background check
    /**
     * Validates background and agree
     */
    if($_POST['question'] === 'agreed'){
        $isValid = true;
    }
    else{
        $isValid = false;
        echo '<h4>ERROR, Must agree to a background check!</h4>';
    }

    if($_POST['policyCheckBox'] === 'checked'){
        $isValid = true;
    }
    else{
        $isValid = false;
        echo '<h4>ERROR, you must agree to our terms and conditions</h4>';
    }
    ?>

    <div class="row">
        <div class="col-6">
                <?php

                //Personal Information
                echo "<p>First Name: $firstName</p>";
                echo "<p>Last Name: $lastName</p>";
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
                echo "<h5>Address</h5>";
                echo "<p>Street: $street</p>";
                echo "<p>City: $city</p>";
                echo "<p>State: $state</p>";
                echo "<p>Zip Code: $zip</p>";

                //interests
                echo "<h5>Interests</h5>";
                if(validSelectWText($interstArray,$_POST["interests"])) {
                    if (!isset($_POST["interests"])) {
                        echo "<p>None selected</p>";
                    } else {
                        echo "<ul>";
                        foreach ($_POST["interests"] as $interests) {
                            if ($interests === "other" && validText($_POST["interestsText"])) {
                                echo "<li>Other Skills: " . $_POST["interestsText"] . "</li>";
                                $mailInterests .= ", {$_POST["interestsText"]}";
                            }
                            if ($interests === "other" && validText($_POST["interestsText"]) && trim($_POST["interestsText"]) === "" ) {
                                echo "<li>Other</li>";
                                $mailInterests .= ", {$_POST["interestsText"]}";
                            }
                            else {
                                echo "<li>" . $interests . "</li>";
                                $mailInterests .= ", $interests";
                            }
                        }
                        $mailInterests = mysqli_real_escape_string($cnxn,$mailInterests);
                        echo "</ul>";
                    }
                }
                else{
                    echo "<p>Illegal Selection</p>";
                    $isValid = false;
                }

                //Availability
                if(validSelectWText($availableArray, $_POST["availability"])) {
                    echo "<h5>Availability</h5>";
                    if (!isset($_POST["availability"])) {
                        echo "<p>None selected</p>";
                    } else {
                        foreach ($_POST["availability"] as $available) {
                            if ($available === "oneWeek") {
                                echo "<p>Available for one week of Summer Camp</p>";
                                $mailAvailable .= "Available One week for Summer Camp";
                            } else if ($available === "weekends" && validText($_POST["weekendTimes"])) {
                                echo "<p> Available: " . $_POST["weekendTimes"] . "</p>";
                                $mailAvailable .= " Available: $available";
                            }
                        }
                        $mailAvailable = mysqli_real_escape_string($cnxn,$mailAvailable);
                    }
                }
                else{
                    echo "<p>Illegal Selection</p>";
                    $isValid = false;
                }

                //About you

                $otherHeardAbout = (!empty($otherHowDidHear)) ? '('.$otherHowDidHear.')' : '';
                echo "<p>How you heard about us: $howDidHear $otherHeardAbout </p>";
                echo "<p>Your Motivation: $motivation</p>";
                echo "<p>Your Experience: $volExperience</p>";
                echo "<p>Your Skills: ".$skills."</p>";


                ?>
        </div>
        <div class="col-6">
            <?php
            //All three references
            echo "<h5>Reference One</h5>";
            echo "<p>First Name: $firstArray[1]</p>";
            echo "<p>Last Name: $lastArray[1]</p>";
            echo "<p>Relationship: $relationArray[1]</p>";
            echo "<p>E-Mail: $mailArray[1]</p>";
            echo "<p>Phone Number: $pNumberArray[1]</p>";

            echo "<h5>Reference Two</h5>";
            echo "<p>First Name: $firstArray[2]</p>";
            echo "<p>Last Name: $lastArray[2]</p>";
            echo "<p>Relationship: $relationArray[2]</p>";
            echo "<p>E-Mail: $mailArray[2]</p>";
            echo "<p>Phone Number: $pNumberArray[2]</p>";

            echo "<h5>Reference Three</h5>";
            echo "<p>First Name: $firstArray[3]</p>";
            echo "<p>Last Name: $lastArray[3]</p>";
            echo "<p>Relationship: $relationArray[3]</p>";
            echo "<p>E-Mail: $mailArray[3]</p>";
            echo "<p>Phone Number: $pNumberArray[3]</p>";
            ?>
        </div>
    </div>
</div>
<?php
if($isValid) {
    $emailSend = "olegrovin@gmail.com";

    $email_body = "Volunteer Information --\r\n";
    $email_body .= "Name: $firstName $lastName \r\n";
    $email_body .= "Address: $street $city" . ", " . "$state $zip \r\n";
    $email_body .= "Interests: $mailInterests \r\n \r\n";
    $email_body .= "How they heard about us: $howDidHear $otherHeardAbout \r\n";
    $email_body .= "Their Motivation: $motivation \r\n";
    $email_body .= "Their Experience: $volExperience \r\n";
    $email_body .= "Their Skills: $skills \r\n \r\n";
    $email_body .= "Their Availability: $mailAvailable \r\n \r\n";
    $email_body .= "Reference One--\r\n Name: $firstArray[1] $lastArray[1]\r\n Relationship: $relationArray[1] \r\n";
    $email_body .= "E-Mail: $mailArray[1]\r\n  Phone Number: $pNumberArray[1] \r\n \r\n";
    $email_body .= "Reference Two--\r\n Name: $firstArray[2] $lastArray[2]\r\n Relationship: $relationArray[2] \r\n";
    $email_body .= "E-Mail: $mailArray[2]\r\n  Phone Number: $pNumberArray[2] \r\n \r\n";
    $email_body .= "Reference Three--\r\n Name: $firstArray[3] $lastArray[3]\r\n Relationship: $relationArray[3] \r\n";
    $email_body .= "E-Mail: $mailArray[3]\r\n  Phone Number: $pNumberArray[3] \r\n \r\n";

    $email_subject = "New Volunteer Applicant";
    $to = "olegrovin@gmail.com";

    $headers = "from: $email\r\n";
    $headers .= "Reply-to: $email \r\n";
    $success = mail($to, $email_subject, $email_body, $headers);

//Print final confirmation
    $msg = $success ? "Your email was successfully submitted."
        : "We're sorry. There was a problem with the email.";
    echo "<p>$msg</p>";
    echo "<h4>Form Was Successfully Submitted!!</h4>";
}
else{
    echo "<h4>ERROR: Form Was Not Submitted</h4>";
}
?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
