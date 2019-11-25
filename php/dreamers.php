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

    <title>Dreamers | ID.A.Y.DREAM</title>
</head>
<body>

<!-- Header -->
<div class="jumbotron banner">
    <h1 class="display-4 text-light font-weight-bold">ID.A.Y.DREAM DREAMERS</h1>
</div>

<div class="container">

    <!-- Dreamers Table -->
    <table id="dreamerTable" class="display">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Guardian Name</th>
            <th>Guardian Email</th>
            <th>Guardian Phone</th>
            <th>Gender</th>
            <th>Ethnicity</th>
            <th>Graduating Class</th>
            <th>Birthday</th>
            <th>Join Date</th>
        </tr>
        </thead>

        <!-- Dreamers information -->
        <tbody>
        <?php
        $result = getAllDreamers($cnxn);

        while ($row = mysqli_fetch_assoc($result)) {
            $personId = $row['personId'];
            $dreamerId = $row['participantId'];
            $fName = ucwords(strtolower($row['firstName']));
            $lName = ucwords(strtolower($row['lastName']));
            $email = strtolower($row['email']);
            $phone = $row['phone'];
            $birthday = $row['birthday'];
            $gender = ucwords(strtolower($row['gender']));
            $ethnicity = ucwords(strtolower($row['ethnicity']));

            $guardResult = getGuardian($cnxn, $row['guardianId']);
            $guardData = mysqli_fetch_assoc($guardResult);

            $guardFName = ucwords(strtolower($guardData['firstName']));
            $guardLName = ucwords(strtolower($guardData['lastName']));
            $guardEmail = ucwords(strtolower($guardData['email']));
            $guardPhoneNum = ucwords(strtolower($guardData['phone']));
            $gradClass = $row['graduatingClass'];
            $joinDate = $row['joinDate'];

            echo "<tr>
                    <td>$fName $lName</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$guardFName $guardLName</td>
                    <td>$guardEmail</td>
                    <td>$guardPhoneNum</td>
                    <td>$gender</td>
                    <td>$ethnicity</td>
                    <td>$gradClass</td>
                    <td data-sort='$birthday'>".formatDate($birthday)."</td>
                    <td data-sort='$dreamerId'>".formatDate($joinDate)."</td>
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
    $('#dreamerTable').DataTable({
        // Order table by join date descending
        'order': [[ 7, "desc" ]]
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }
    });
</script>
</body>
</html>
