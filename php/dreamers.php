<?php

// Included files
include("debugging.php");
require("functionsIDD.php");
require('/home/notfound/connect.php');
require("emailModal.php");

?>

<!doctype html>
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/sendMail.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png"/>

    <title>Dreamers | ID.A.Y.DREAM</title>
</head>
<body class="bg-color">

<!-- Header -->
<div class="jumbotron banner">
    <h1 class="display-4 text-white font-weight-bold">ID.A.Y.DREAM DREAMERS</h1>
</div>

<div class="container width">
    <div class="col-md-12">

        <p><a class="btn btn-dark shadow-sm mx-0 rounded-0" href="#emailSend"
              data-toggle="modal" >Send Email</a></p>

        <section class="card shadow mb-5">
            <h3 class="card-title titleColor text-white text-center mb-4 py-2">Dreamer Database</h3>
            <div class="p-3">

            <!-- Dreamers Table -->
            <table id="dreamerTable" class="display nowrap w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Graduating Class</th>
                        <th>Birthday</th>
                        <th>Gender</th>
                        <th>Ethnicity</th>
                        <th>Career Goals</th>
                        <th>College of Interest</th>
                        <th>Favorite Food</th>
                        <th>Guardian Name</th>
                        <th>Guardian Email</th>
                        <th>Guardian Phone</th>
                        <th>Join Date</th>
                    </tr>
                    </thead>

                    <!-- Dreamers information -->
                    <tbody>
                    <?php
                    $result = getAllDreamers($cnxn);

                    // -1 == inactive, 0 == pending, 1 == active
                    $activityArray = array("Inactive"=>'-1',"Pending"=>'0',"Active"=>'1');

                    while ($row = mysqli_fetch_assoc($result)) {
                        $activity = $row['activity'];
                        $personId = $row['personId'];
                        $dreamerId = $row['participantId'];
                        $fName = ucwords(strtolower($row['firstName']));
                        $lName = ucwords(strtolower($row['lastName']));
                        $email = strtolower($row['email']);
                        $phone = $row['phone'];
                        $birthday = $row['birthday'];
                        $gender = ucwords(strtolower($row['gender']));
                        $ethnicity = ucwords(strtolower($row['ethnicity']));
                        $food = empty($row['favoriteFood']) ? 'Unspecified' : $row['favoriteFood'];
                        $college = empty($row['collegeOfInterest']) ? 'Unspecified' : $row['collegeOfInterest'];
                        $goals = empty($row['careerGoals']) ? 'Unspecified' : $row['careerGoals'];

                        $guardResult = getGuardian($cnxn, $row['guardianId']);
                        $guardData = mysqli_fetch_assoc($guardResult);

                        $guardFName = ucwords(strtolower($guardData['firstName']));
                        $guardLName = ucwords(strtolower($guardData['lastName']));
                        $guardEmail = strtolower($guardData['email']);
                        $guardPhoneNum = ucwords(strtolower($guardData['phone']));

                        $gradClass = $row['graduatingClass'];
                        $joinDate = formatDate($row['joinDate']);

            echo "<tr>
                    <td>$fName $lName</td>  
                    <td class data-search='" . array_search($activity, $activityArray) . "'>
                       <select class='activity' data-id='$dreamerId'>";
                    foreach($activityArray as $active => $id){
                        if($activity == $id){
                            echo "<option value='$id' selected>$active</option>";
                        }
                        else{
                            echo "<option value='$id'>$active</option>";
                        }
                    }
            echo   "</select></td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$gradClass</td>
                    <td data-sort='$birthday'>" . formatDate($birthday) . "</td>
                    <td>$gender</td>
                    <td>$ethnicity</td>
                    <td>$goals</td>
                    <td>$college</td>
                    <td>$food</td>
                    <td>$guardFName $guardLName</td>
                    <td>$guardEmail</td>
                    <td>$guardPhoneNum</td>
                    <td data-sort='$dreamerId'>$joinDate</td>
                 </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <br>
        </section>
    </div>

    <!--<button id="reload" class="btn btn-dark p-2">Update Changes</button>-->
</div>
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
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script><script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="../javascript/dreamerTable.js"></script>
<script src="../javascript/sendMail.js"></script>
</body>
</html>
