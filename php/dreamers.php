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
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <th class="hidden">search activity</th>
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
                    <td>
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
                    <td data-sort='$birthday'>".formatDate($birthday)."</td>
                    <td>$gender</td>
                    <td>$ethnicity</td>
                    <td>$goals</td>
                    <td>$college</td>
                    <td>$food</td>
                    <td>$guardFName $guardLName</td>
                    <td>$guardEmail</td>
                    <td>$guardPhoneNum</td>
                    <td data-sort='$dreamerId'>$joinDate</td>";
                    foreach($activityArray as $active => $id){
                        if($activity == $id){
                            echo "<td class='hidden'>$active</td>";
                        }
                    }
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <br>
    <p><a class="btn btn-dark p-2" href="sendMail.php?source=dream">Send Email</a></p>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="//code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $('.activity').on('change',function(){
        let activity = $(this).val();
        let dreamerId = $(this).attr('data-id');

        $.post('activity.php', {id:dreamerId, activity:activity});
    });
    $('#dreamerTable').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for ' + data[0];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },

        // Priority of which columns are shown in the table
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 5, targets: 10 },
            { responsivePriority: 6, targets: 11 },
            { responsivePriority: 7, targets: 12 },
            { responsivePriority: 4, targets: 13 },
            //Turns off search for the select element
            { searchable: false, targets: 1 }
        ],

        // Order table by join date descending
        order: [[ 13, "desc" ]]
    });
</script>
</body>
</html>
