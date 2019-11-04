<?php
//Error Reporting
/*ini_set("display_errors",1);
error_reporting(E_ALL);*/

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

//ContactInfo Fields
$email = $_POST["email"];
$phoneNum = $_POST["phone"]
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="../styles/form.css" rel="stylesheet">

    <title>Thank you</title>
</head>
<body>
<!--Header for Thank You page-->
<div class="container">
    <div class="jumbotron ">
        <h1 class="display-4">Thank You for Completion!</h1>
        <p class="lead">Please review the following information you have submitted</p>
    </div>

    <div class="text-center">
        <h2>Personal Info</h2>
        <?php
        //Displays Personal Information entered from the form
        echo "<p>Name: $firstName $lastName </p>";
        echo "<p>Birthday: $birthday </p>";
        echo "<p>Gender: $gender </p>";
        echo "<p>Ethnicity: $ethnicity </p>";
        echo "<p>Graduation Year: $gradClass </p>";
        echo "<p>College Interest: $collegeIntr </p>";
        echo "<p>Aspirations: $jobGoal </p>";
        echo "<p>Favorite Snacks: $favFood </p>";
        ?>

        <h2 class="mt-3">Contact Information</h2>
        <?php
        //Displays Contact Information entered from the form
        echo "<p>E-Mail: $email</p>";
        echo "<p>Phone Number: $phoneNum</p>";
        ?>
    </div>
</div>

<!-- Code to send a email of the users entered information -->
<?php
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
?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
