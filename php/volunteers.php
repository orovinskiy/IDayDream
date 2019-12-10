<?php

// Turn on error reporting -- this is critical!
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

<div class="container width">
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
                                <th>Email</th>
                                <th>On Mail List</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Weekends</th>
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

                            while ($row = mysqli_fetch_assoc($result)) {
                                $personId = $row['personId'];
                                $volunteerId = $row['volunteerId'];
                                $fName = ucwords(strtolower($row['firstName']));
                                $lName = ucwords(strtolower($row['lastName']));
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

                                echo "<tr>
                            <td>$fName $lName</td>
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
                }
                ?>
                </tbody>
            </table>
            </div>
        </section>
    </div>
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
<script>
    $('#volunteerTable').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details for ' + data[0];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        },

        // Priority of which columns are shown in the table
        columnDefs: [
            {responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: 1},
            {responsivePriority: 3, targets: 3},
            {responsivePriority: 4, targets: 4},
            {responsivePriority: 5, targets: 5},
            {responsivePriority: 6, targets: 6},
            {responsivePriority: 5, targets: 14}
        ],

        // Order table by join date descending
        order: [[14, "desc"]]
    });
</script>
</body>
</html>
