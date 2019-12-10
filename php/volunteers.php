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

<!-- Header -->
<div class="jumbotron banner">
    <h1 class="display-4 text-light font-weight-bold">ID.A.Y.DREAM VOLUNTEERS</h1>
</div>

<div class="container">

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
    <p><a class="btn btn-dark p-2" href="sendMail.php?source=vol">Send Email</a></p>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="../javascript/volunteerTable.js"></script>
</body>
</html>
