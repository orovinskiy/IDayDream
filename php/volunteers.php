<?php

// Included files
include("debugging.php");
require("functionsIDD.php");
require('/home/notfound/connect.php');

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../styles/style.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" />

    <title>Volunteers | ID.A.Y.DREAM</title>
</head>
<body>

<nav class="navbar navbar-expand-md sticky-top navbar-dark bg-dark info-color">
    <a class="navbar-brand font-weight-bold" href="#">Menu |</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link waves-effect waves-light" href="../volunteerFrm.html">Volunteer<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="thankYou.php">Volunteer Confirmation</a>
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

<!-- Header -->
<div class="jumbotron banner">
    <h1 class="display-4 text-light font-weight-bold">ID.A.Y.DREAM VOLUNTEERS</h1>
</div>

<div class="container">

    <!-- Volunteers Table -->
    <table id="volunteerTable" class="display nowrap" style="width:100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Summer Camp</th>
            <th>Weekends</th>
            <th>Join Date</th>
            <th>On Mail List</th>
            <th>Shirt Size</th>
            <th>Heard About By</th>
            <th>Motivation</th>
            <th>Experience</th>
            <th>Skills</th>
            <th>Interests</th>
            <th>References</th>
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
            $address = $row['street'] . '<br>' . $row['city'] . ', ' . strtoupper($row['state']) . ' ' . $row['zip'];
            $summerCamp = $row['oneWeekSummerCamp'] === '1' ? 'Yes' : 'No';
            $weekend = formatWeekend($row['weekend']);
            $joinDate = formatDate($row['joinDate']);
            $onMailList = $row['onMailList'] === '1' ? 'Yes' : 'No';
            $tShirtSize = formatShirtSize($row['tShirtSize']);
            $heardAbout = formatHeardAbout($row['heardAbout']);
            $motivation = $row['motivation'];
            $experience = $row['experience'];
            $skills = $row['skills'];
            $interests = formatInterests(getInterestsById($cnxn, $volunteerId));
            $references = formatReferences(getReferencesById($cnxn, $volunteerId));

            echo "<tr>
                    <td>$fName $lName</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$address</td>
                    <td>$summerCamp</td>
                    <td>$weekend</td>
                    <td data-sort='$volunteerId'>$joinDate</td>
                    <td>$onMailList</td>
                    <td>$tShirtSize</td>
                    <td>$heardAbout</td>
                    <td>$motivation</td>
                    <td>$experience</td>
                    <td>$skills</td>
                    <td>$interests</td>
                    <td>$references</td>
                </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $('#volunteerTable').DataTable( {
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+ data[0];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },
        // Order table by join date descending
        order: [[ 6, "desc" ]]
    } );
</script>
</body>
</html>
