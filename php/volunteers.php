<?php

// Start a session
session_start();

// Included files
include("debugging.php");
require("functionsIDD.php");
require('/home/notfound/connect.php');
require("emailModal.php");

// If user is not logged in, reroute them to the login page
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}

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

    <title>Volunteers | ID.A.Y.DREAM</title>
</head>
<body class="bg-color">

<!-- Header -->
<div class="jumbotron banner mb-0 rounded-0 shadow">
    <h1 class="display-4 text-white font-weight-bold">ID.A.Y.DREAM VOLUNTEERS</h1>
</div>

<?php
    require('nav.php');
?>

<div class="container tableWidth">
    <div class="col-md-12">

        <p><a class="btn btn-dark shadow-sm mx-0 rounded-0" href="#emailSendVol"
              data-toggle="modal" >Send Email</a></p>
        <section class="card shadow mb-5">
            <h3 class="card-title titleColor text-white text-center mb-4 py-2">Volunteer Database</h3>

            <div class="p-3">
                <!-- Volunteers Table -->
                <table id="volunteerTable" class="display nowrap w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>On Mail List</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Availability</th>
                        <th>Summer Camp</th>
                        <th>Shirt Size</th>
                        <th>Heard About By</th>
                        <th>Motivation</th>
                        <th>Experience</th>
                        <th>Skills</th>
                        <th>Interests</th>
                        <th>References</th>
                        <th>Join Date</th>
                    </tr>
                    </thead>

                    <!-- Volunteers information -->
                    <tbody>
                    <?php
                    $result = getAllVolunteers($cnxn);

                    $rowIndex = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $personId = $row['personId'];
                        $volunteerId = $row['volunteerId'];
                        $fName = ucwords(strtolower($row['firstName']));
                        $lName = ucwords(strtolower($row['lastName']));
                        $status = $row['activity'];
                        $email = strtolower($row['email']);
                        $phone = $row['phone'];
                        $address = $row['street'] . ' ' . $row['city'] . ', ' . strtoupper($row['state']) . ' ' . $row['zip'];
                        $summerCamp = $row['oneWeekSummerCamp'] === '1' ? 'Yes' : 'No';
                        $weekend = empty($row['weekend']) ? 'Unspecified' : $row['weekend'];
                        $joinDate = formatDate($row['joinDate']);
                        $onMailList = $row['onMailList'] === '1' ? 'Yes' : 'No';
                        $tShirtSize = formatShirtSize($row['tShirtSize']);
                        $heardAbout = formatHeardAbout($row['heardAbout']);
                        $motivation = $row['motivation'];
                        $experience = empty($row['experience']) ? 'Unspecified' : $row['experience'];
                        $skills = empty($row['experience']) ? 'Unspecified' : $row['experience'];
                        $interests = formatInterests(getInterestsById($cnxn, $volunteerId));
                        $references = formatReferences(getReferencesById($cnxn, $volunteerId));
                        $statusOptions = array('Active'=>'1', 'Pending'=>'0', 'Inactive'=>'-1');
                        $selectedStatusName = array_search($status, $statusOptions);

                        //see manual for Jquery Tables
                        echo "<tr>
                    <td>$fName $lName</td>
                    <td data-search='$selectedStatusName' data-sort='$selectedStatusName'
                            data-dt-column='1' data-dt-row='$rowIndex'>
                      <select class='status' data-vol-id='$volunteerId'  data-row-index='$rowIndex'>";

                        foreach ($statusOptions as $statusName => $statusValue) {
                            $sel = ($status === $statusValue) ? "selected" : "";
                            echo "<option value='$statusValue' $sel>$statusName</option>";
                        }

                        echo "</select>
                    </td>
                    <td>$email</td>
                    <td>$onMailList</td>
                    <td>$phone</td>
                    <td>$address</td>
                    <td>$weekend</td>
                    <td>$summerCamp</td>
                    <td>$tShirtSize</td>
                    <td>$heardAbout</td>
                    <td>$motivation</td>
                    <td>$experience</td>
                    <td>$skills</td>
                    <td>$interests</td>
                    <td>$references</td>
                    <td data-sort='$volunteerId'>$joinDate</td>
                </tr>";

                        $rowIndex++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <?php
       emailModal("emailSendVol","vol");
    ?>
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
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="../javascript/sendMail.js"></script>
<script src="../javascript/updateCellsInTable.js"></script>
<script src="../javascript/volunteerTable.js"></script>
<script src="../javascript/tableSearch.js"></script>
</body>
</html>
