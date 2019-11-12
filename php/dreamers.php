<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

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
    <title>Dreamers | ID.A.Y.DREAM</title>
</head>
<body>
<div class="container">
    <h3>Dreamers</h3>
    <?php
    require('/home/notfound/connect.php');


    $sql = 'SELECT *
            FROM person 
            INNER JOIN participant 
                ON person.personId = participant.personId';

    $result = mysqli_query($cnxn, $sql);
    ?>

    <table id="dreamerTable" class="display">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Birthday</th>
            <th>Gender</th>
            <th>Ethnicity</th>
            <th>Graduating Class</th>
        </tr>
        </thead>
        <tbody>

        <?php

        while ($row = mysqli_fetch_assoc($result)) {
            $personId = $row['personId'];
            $dreamerId = $row['participantId'];
            $fName = $row['firstName'];
            $lName = $row['lastName'];
            $email = $row['email'];
            $phone = $row['phone'];
            $birthday = $row['birthday'];
            $gender = $row['gender'];
            $ethnicity = $row['ethnicity'];
            $gradClass = $row['graduatingClass'];

            echo "<tr>
                <td>$fName $lName</td>
                <td>$email</td>
                <td>phone</td>
                <td>$birthday</td>
                <td>$gender</td>
                <td>$ethnicity</td>
                <td>$gradClass</td>
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
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" ></script>
<script>
    $('#dreamerTable').DataTable();
</script>
</body>
</html>
