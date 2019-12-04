<?php
//connection to the database
require('/home/notfound/connect.php');

//variables
$array = array('-1','0','1');
$activity = mysqli_real_escape_string($cnxn,trim($_POST['activity']));
$id = mysqli_real_escape_string($cnxn,trim($_POST['id']));

if(in_array($activity,$array)) {
//Updating the database
    $sql = "UPDATE participant SET activity= '$activity' WHERE participantId = '$id'";

    echo mysqli_query($cnxn, $sql);
}