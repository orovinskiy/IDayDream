<?php
/**
 * Required files for this file to run.
 * If files not found will terminate program
 */
include('debugging.php');
require("functionsIDD.php");
require('/home/notfound/connect.php');


/**
 * Fields for summary
 */
$firstName = trim($_POST["firstName"]);
$lastName = trim($_POST["lastName"]);
$birthday = trim($_POST["birthday"]);
$gender = trim($_POST["gender"]);
$ethnicity = trim($_POST["ethnicity"]);
$gradClass = trim($_POST["gradClass"]);
$favFood = trim($_POST["food"]);
$collegeIntr = trim($_POST["college"]);
$jobGoal = trim($_POST["jobGoal"]);
$otherEthnic = trim($_POST['otherEthic']);

/**
 * Fields for contact summary
 */
$email = trim($_POST["email"]);
$phoneNum = trim($_POST["phone"]);

/**
 * Fields for Parent/Guardian information
 */

$guardianFName = trim($_POST["guardianFName"]);
$guardianLName = trim($_POST["guardianLName"]);
$guardianEmail = trim($_POST["guardianEmail"]);
$guardianPhoneNum = trim($_POST["guardianPhone"]);

/**
 * Fields for validation
 */
$gradArray = array('2020','2021','2022','2023','2024','2025','2026');
$genderArray = array('male','female','other','noAnswer');
$ethicArray = array('Native American','Asian','Black','Hispanic','Middle Eastern','Pacific Islander','Southeast Asian','White','Multiracial','No Answer','other');
$textArray = array(
    'College Interest:'=> $collegeIntr,
    'Aspirations:'=> $jobGoal,
    'Favorite Snacks:'=> $favFood
);
$isValid = true;
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="../styles/style.css">
    <link href="../styles/form.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" />

    <title>Thank you</title>
</head>
<body>

<!--Header for Thank You page-->
<div class="jumbotron ">
    <h1 class="display-4">Thank You!</h1>
</div>

<div class="container">
    <div class="text-center">
        <h2>Personal Info</h2>
        <?php
        /**
         * Displays Personal Information entered from the form and validates it
         */
        if(validName($firstName) === false|| validName($lastName)===false){
            $isValid = false;
            echo "<p>Name: Invalid last and first name must contain only letters</p>";
        } else{
            echo "<p>Name: $firstName $lastName </p>";
            $firstName = mysqli_real_escape_string($cnxn, $firstName);
            $lastName = mysqli_real_escape_string($cnxn, $lastName);
        }

        /**
         * Validates the date in a MM/DD/YYYY format
         */
        if(validDate($birthday) === false){
            $isValid = false;
            echo "<p>Date: Invalid must follow MM/DD/YYYY</p>";
        }else{
            echo "<p>Birthday: $birthday </p>";
            $birthday = date('Y-m-d', strtotime($birthday));
            $birthday = mysqli_real_escape_string($cnxn, $birthday);
        }
        /**
         * Validates the gender if the correct one was picked
         */
        if(validSelect($genderArray, $gender) === false){
            $isValid = false;
            echo "<p>Gender: Invalid, please choose from the options provided</p>";
        }else{
            echo "<p>Gender: $gender </p>";
            $gender = mysqli_real_escape_string($cnxn, $gender);
        }

        /**
         * Validates if the graduation year is correct from select
         */
        if(validSelect($gradArray, $gradClass) === false){
            $isValid = false;
            echo "<p>Graduation Year: Invalid, please choose from the options provided</p>";
        }else{
            echo "<p>Graduation year: $gradClass </p>";
            $gradClass = mysqli_real_escape_string($cnxn, $gradClass);
        }

        /**
         * Validates the ethnicity and the other box if chosen
         */
        if(validSelect($ethicArray, $ethnicity) === false){
            $isValid = false;
            echo "<p>Ethnicity: Invalid, please choose from the options provided </p>";
        }
        else if($ethnicity === "other"){
            // If filled in but not valid
            if ($otherEthnic !== htmlspecialchars($otherEthnic)) {
                $isValid = false;
                echo "<p>Ethnicity: Please provide a valid answer";
            }
            // If filled in and valid. If not filled in keep "other" text
            else if (!empty($otherEthnic)) {
                $ethnicity = mysqli_real_escape_string($cnxn, $otherEthnic);
                echo "<p>Ethnicity: $ethnicity</p>";
            }
        }
        else{
            echo "<p>Ethnicity: $ethnicity</p>";
            $ethnicity = mysqli_real_escape_string($cnxn, $ethnicity);
        }

        /**
         * Cycles through all the text fields making sure no spoofing
         * happened
         */
        foreach($textArray as $text=>$value){
            if(!validText($value)){
                $isValid = false;
                echo "<p>$text Invalid Input </p>";
            }
            else{
                echo "<p>$text $value</p>";
            }
        }
        $jobGoal = mysqli_real_escape_string($cnxn, $jobGoal);
        $collegeIntr = mysqli_real_escape_string($cnxn, $collegeIntr);
        $favFood = mysqli_real_escape_string($cnxn, $favFood);
        ?>

        <h2 class="mt-3">Contact Information</h2>
        <?php

        /**
         * Displays Contact Information entered from the form
         * and validates them before displaying
         */
        if(validMail($email) === false){
            $isValid = false;
            echo "<p>E-Mail: Invalid email format</p>";
        }
        else{
            echo "<p>E-Mail: $email</p>";
            $email = mysqli_real_escape_string($cnxn, $email);
        }

        if(validNumber($phoneNum) === false){
            $isValid = false;
            echo "<p>Phone Number: Invalid phone number format</p>";
        }
        else{
            echo "<p>Phone Number: $phoneNum</p>";
            $phoneNum = mysqli_real_escape_string($cnxn, $phoneNum);
        }
        ?>

        <h2 class="mt-3">Parent/Guardian Information</h2>
        <?php

        /**
         * Displays the parent/guardian information entered and validates it
         *
         */

        if(validName($guardianFName) === false|| validName($guardianLName)===false){
            $isValid = false;
            echo "<p>Name: Invalid last and first name must contain only letters</p>";
        } else{
            echo "<p>Name: $guardianFName $guardianLName </p>";
            $guardianFName = mysqli_real_escape_string($cnxn, $guardianFName);
            $guardianLName = mysqli_real_escape_string($cnxn, $guardianLName);
        }

        if(validMail($guardianEmail) === false){
            $isValid = false;
            echo "<p>E-Mail: Invalid email format</p>";
        }
        else{
            echo "<p>E-Mail: $guardianEmail</p>";
            $guardianEmail = mysqli_real_escape_string($cnxn, $guardianEmail);
        }

        if(validNumber($guardianPhoneNum) === false){
            $isValid = false;
            echo "<p>Phone Number: Invalid phone number format</p>";
        }
        else{
            echo "<p>Phone Number: $guardianPhoneNum</p>";
            $guardianPhoneNum = mysqli_real_escape_string($cnxn, $guardianPhoneNum);
        }

        /**
         * Code to send a email of the users entered information.
         * If Error occurs an appropriate message will display
         */
        if($isValid === true) {

            $isSaved = saveParticipant($cnxn, $firstName, $lastName, $email, $phoneNum, $birthday, $gender, $ethnicity,
                $gradClass, $favFood, $collegeIntr, $jobGoal, $guardianFName, $guardianLName, $guardianEmail, $guardianPhoneNum);

            // if all data was saved successfully
            if ($isSaved) {
                echo "<h2>Success!! Your information has been submitted.</h2>";
            }
            else {
                echo "<h2>There was an error. Your information was not submitted.</h2>";
            }


            // Create and send email
            $emailSend = "olegrovin@gmail.com";

            $email_body = "Welcome Form --\r\n";
            $email_body .= "Name: $firstName $lastName \r\n";
            $email_body .= "Birthday: $birthday \r\n";
            $email_body .= "Gender: $gender \r\n";
            $email_body .= "Ethnicity: $ethnicity \r\n";
            $email_body .= "Graduation Year: $gradClass \r\n \r\n";

            $email_body .= "Their College Interests: $collegeIntr \r\n \r\n";
            $email_body .= "Their Aspirations: $jobGoal \r\n \r\n";
            $email_body .= "Their Favorite Snack: $favFood \r\n \r\n";

            $email_body .= "Contact Information --\r\n";
            $email_body .= "E-Mail: $email\r\n";
            $email_body .= "Phone Number: $phoneNum\r\n\r\n";

            $email_body .= "Parent Guardian Information --\r\n";
            $email_body .= "Name: $guardianFName $guardianLName\r\n";
            $email_body .= "Email: $guardianEmail\r\n";
            $email_body .= "Phone Number: $guardianPhoneNum\r\n";


            $email_subject = "New Member Applicant";
            $to = "cdrennan@mail.greenriver.edu";

            $headers = "from: $email\r\n";
            $headers.= "Reply-to: $email \r\n";

            $success = mail($to, $email_subject, $email_body, $headers);

            /*
            //Print final confirmation
            $msg = $success ? "Your form was successfully submitted."
                : "We're sorry. There was a problem with your form.";
            echo "<p>$msg</p>";
            */
        }
        else{
            echo "<h2>There was an error. Your information was not submitted.</h2>";
        }

        ?>
    </div>
</div><!-- Container -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
