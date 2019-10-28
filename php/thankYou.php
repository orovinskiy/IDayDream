<?php
//Error reporter
ini_set("display_errors",1);
error_reporting(E_ALL);

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

//Interests
$interests = $_POST["interests[]"];

//About You
$howDidHear = $_POST["howDidHear"];
$howDidHear = $_POST["howDidHear"];
$motivation = $_POST["motivation"];
$volExperience = $_POST["volExperience"];
$skills = $_POST["skills"];

//References
//first
$fullName1 = $_POST["refFullName1"];
$relationship1 = $_POST["refRelationship1"];
$refPhoneNumber1 = $_POST["refPhone1"];
$refEmail1 = $_POST["refEmail1"];

//second
$fullName2 = $_POST["refFullName2"];
$relationship2 = $_POST["refRelationship2"];
$refPhoneNumber2 = $_POST["refPhone2"];
$refEmail2 = $_POST["refEmail2"];

//third
$fullName3 = $_POST["refFullName3"];
$relationship3 = $_POST["refRelationship3"];
$refPhoneNumber3 = $_POST["refPhone3"];
$refEmail3 = $_POST["refEmail3"];


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

    </div>
</body>
</html>

