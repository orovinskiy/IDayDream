<?php
//Error Reporting
ini_set("display_errors",1);
error_reporting(E_ALL);

require('/home/notfound/connect.php');

//Fields
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$birthday = $_POST["birthday"];
$gender = $_POST["gender"];
$ethnicity = $_POST["ethnicity"];
$gradClass = $_POST["gradClass"];
$favFood = $_POST["food"];
$collegeIntr = $_POST["college"];
$jobGoal = $_POST["jobGoal"];
$otherEthic = $_POST['otherEthic'];

//ContactInfo Fields
$email = $_POST["email"];
$phoneNum = $_POST["phone"];

//Validation variables
$gradArray = array('2020','2021','2022','2023','2024','2025','2026');
$genderArray = array('male','female','other','noAnswer');
$ethicArray = array('Native American','Asian','Black','Hispanic','Middle Eastern','Pacific Islander','Southeast Asian','White','Multiracial','No Answer','other');
$textArray = array(
    'College Interest:'=> $collegeIntr,
    'Aspirations:'=> $jobGoal,
    'Favorite Snacks:'=> $favFood
);
$isValid = true;

//include other files
include "functionsIDD.php";
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
    <h1 class="display-4">Thank You for Completion!</h1>
    <p class="lead">Please review the following information you have submitted</p>
</div>

<div class="container">
    <div class="text-center">
        <h2>Personal Info</h2>
        <?php
        //Displays Personal Information entered from the form and validates
        if(validName($firstName) === false|| validName($lastName)===false){
            $isValid = false;
            echo "<p>Name: Invalid last and first name must contain only letters</p>";
        } else{
            echo "<p>Name: $firstName $lastName </p>";
            $firstName = mysqli_real_escape_string($cnxn, $firstName);
            $lastName = mysqli_real_escape_string($cnxn, $lastName);
        }

        //validates the date in a YYYY-MM-DD format
        if(validDate($birthday) === false){
            $isValid = false;
            echo "<p>Date: Invalid must follow YYYY-MM-DD</p>";
        }else{
            echo "<p>Birthday: $birthday </p>";
            $birthday = mysqli_real_escape_string($cnxn, $birthday);
        }

        //validates the gender if the correct one was picked
        if(validSelect($genderArray, $gender) === false){
            $isValid = false;
            echo "<p>Gender: Invalid, please choose from the options provided</p>";
        }else{
            echo "<p>Gender: $gender </p>";
            $gender = mysqli_real_escape_string($cnxn, $gender);
        }

        //Validates if the graduation year is correct from select
        if(validSelect($gradArray, $gradClass) === false){
            $isValid = false;
            echo "<p>Graduation Year: Invalid, please choose from the options provided</p>";
        }else{
            echo "<p>Graduation year: $gradClass </p>";
            $gradClass = mysqli_real_escape_string($cnxn, $gradClass);
        }

        //validates the ethnicity and the other box if chosen
        if(validSelect($ethicArray, $ethnicity) === false){
            $isValid = false;
            echo "<p>Ethnicity: Invalid, please choose from the options provided </p>";
        }
        else if($ethnicity === "other"){
            if($otherEthic !== htmlspecialchars($otherEthic) || trim($otherEthic) === ""){
                $isValid = false;
                echo "<p>Ethnicity: Please provide a valid answer";
            }
            else {
                echo "<p>Ethnicity: $otherEthic</p>";
                $otherEthic = mysqli_real_escape_string($cnxn, $otherEthic);
            }
        }
        else{
            echo "<p>Ethnicity: $ethnicity</p>";
            $ethnicity = mysqli_real_escape_string($cnxn, $ethnicity);
        }

        //cycles through all the text fields making sure no spoofing
        //happened
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
        //Displays Contact Information entered from the form
        //and validates them before displaying
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
    </div>
</div>

<!-- Code to send a email of the users entered information -->
<?php
if($isValid === true) {

    // Insert into database
    $personInsert = "INSERT INTO person (firstName, lastName, email, phone)
            VALUES ('$firstName', '$lastName', '$email', '$phoneNum')";

    $personQResult = mysqli_query($cnxn, $personInsert);
    $dreamerQResult = false;

    if ($personQResult) {
        $personId = $cnxn->insert_id;
        $currDate = date("Y-m-d");

        $dreamerInsert =
            "INSERT INTO participant (personId, birthday, gender, ethnicity, graduatingClass, 
                                      favoriteFood, collegeOfInterest, careerGoals, joinDate)
            VALUES ('$personId', '$birthday', '$gender', '$ethnicity', '$gradClass', 
                    '$favFood', '$collegeIntr', '$jobGoal', '$currDate')";

        $dreamerQResult = mysqli_query($cnxn, $dreamerInsert);
    }

    if ($personQResult && $dreamerQResult) {
        echo "<h2>Success!! Your information has been submitted</h2>";
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
    $email_body .= "Phone Number: $phoneNum\r\n";


    $email_subject = "New Member Applicant";
    $to = "olegrovin@gmail.com";

    $headers = "from: $email\r\n";
    $headers.= "Reply-to: $email \r\n";

    $success = mail($to, $email_subject, $email_body, $headers);

    //Print final confirmation
    $msg = $success ? "Your form was successfully submitted."
        : "We're sorry. There was a problem with your form.";
    echo "<p>$msg</p>";
}
else{
    echo "<h2>There was an error. Your information was not submitted.</h2>";
}

?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
