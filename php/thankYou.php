<?php
//Error reporter
/*
ini_set("display_errors",1);
error_reporting(E_ALL);*/

/**
 * fields
 */
//personal Info
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$phoneNumber = $_POST["pNumber"];
$email = $_POST["eMail"];
$mailList = $_POST["onMailList"];
$tShirt = $_POST["shirtSize"];

//address
$street = $_POST["street"];
$city = $_POST["city"];
$state = $_POST["state"];
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
    <title>I Day Dream | Volunteer Form</title>
</head>
<body>
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
</body>
</html>
