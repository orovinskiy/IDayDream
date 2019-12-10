<?php

// Includes
include('debugging.php');
require('functionsIDD.php');
require('/home/notfound/connect.php');

// Acceptable values for status
$statusValues = array('-1','0','1');

$status = mysqli_real_escape_string($cnxn,trim($_POST['status']));
$volId = mysqli_real_escape_string($cnxn,trim($_POST['volId']));

if (in_array($status, $statusValues)) {
    updateVolunteerStatus($cnxn, $volId, $status);
}
