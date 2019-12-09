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
    <link rel="stylesheet" href="../styles/sendMail.css">

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
    <a class="btn btn-dark p-2" href="#emailSendVol"
       data-toggle="modal" >Send Email</a>

    <!-- modal for the email -->
    <div class="modal fade" id="emailSendVol">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-tittle">Compose Your Email</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- modal-header -->
                <form id="emailComposer" action="mailSender.php" method="post">
                    <div class="modal-body">

                        <!-- Subject -->
                        <div class="form-group" >
                            <label class=" h5 font-weight-light " id="subjectLabel"  for="subject">Subject </label>
                            <span id="subjectError" class="hidden error">*Required</span>
                            <input class="required form-control" type="text" id="subject" maxlength="150" name="subject">
                        </div>

                        <!-- Text Area -->
                        <div class="form-group">
                            <label for="compose" id="composeLabel" class="h5 font-weight-light mr-sm-1">
                                Compose your message
                            </label>
                            <span id="composeError" class="hidden error">*Required</span>
                            <textarea id="compose" maxlength="200000" class="required form-control" name="compose"></textarea>
                        </div>

                        <!-- saves input from which page the user came from -->
                        <?php
                        echo "<input type='checkbox' name='select' value='vol' checked class='halfHidden'>";
                        ?>

                    </div><!-- modal-body -->
                    <div class="modal-footer">
                        <button type="submit" id="submit" class="btn btn-dark p-2">Submit</button>
                    </div><!-- modal-footer -->
                </form>
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="../javascript/sendMail.js"></script>
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

        // Priority of which columns are shown in the table
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 4, targets: 4 },
            { responsivePriority: 5, targets: 5 },
            { responsivePriority: 6, targets: 6 },
            { responsivePriority: 5, targets: 14 }
        ],

        // Order table by join date descending
        order: [[ 14, "desc" ]]
    } );
</script>
</body>
</html>
