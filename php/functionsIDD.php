<?php

//checks if it is a straight text field
function validName($name){
    $nameArray = array('1','2','3','4','5','6','7','8','9','0','#','@','$','%');
    if($name === "" || $name != htmlspecialchars($name) || !formatCheck($nameArray,$name) || is_numeric($name)){
        return false;
    }
    return true;
}

//see if the date is in a YYYY-MM-DD format
function validDate($date){
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date) ||
        $date != htmlspecialchars($date)) {
        return false;
    }
    return true;
}

//looks to see if the given value is inside the array
function validSelect($array, $input){
    if(!in_array($input, $array)){
        return false;
    }
    return true;
}


function validMail($email){
    if(trim($email) === "" || $email !== htmlspecialchars($email) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)){

        return false;

    }
    return true;
}

function validNumber($number){
    if(trim($number) === "" || $number !== htmlspecialchars($number) ||
        !preg_match("/^[0-9\-\(\)\/\+\s]*$/",$number)){

        return false;

    }
    return true;
}

//checks for undesired variables
function formatCheck($array, $input){
    $valid = true;

    for($i = 0; $i < count($array); $i++){
        if(strpos($input,$array[$i]) !== false){
            $valid = false;
        }
    }

    return $valid;
}

function validText($input){
    if($input !== htmlspecialchars($input)){
        return false;
    }
    return true;
}

/**
 * Takes a date in the YYYY-MM-DD  format and converts it to
 * MM/DD/YYYY. Returns false if conversion fails
 * @param $date the date to format
 * @return string formatted date as MM/DD/YYYY or error msg
 */
function formatDate($date) {
    try {
        $formattedDate = new DateTime($date);
        return $formattedDate->format('m/d/Y');

    } catch (Exception $e) {
        return "Error: invalid date format";
    }
}

function getAllDreamers($cnxn) {
    $sql = 'SELECT *
            FROM person 
            INNER JOIN participant 
                ON person.personId = participant.personId
            ORDER BY participantId DESC';

    return mysqli_query($cnxn, $sql);
}

function insertPerson($cnxn, $firstName, $lastName, $email, $phone) {
    $personInsert = "INSERT INTO person (firstName, lastName, email, phone)
            VALUES ('$firstName', '$lastName', '$email', '$phone')";

    return mysqli_query($cnxn, $personInsert);
}

function insertDreamer($cnxn, $personId, $birthday, $gender, $ethnicity, $gradClass,
                       $favFood, $collegeIntr, $jobGoal, $currDate) {
    $dreamerInsert =
        "INSERT INTO participant (personId, birthday, gender, ethnicity, graduatingClass, 
                                      favoriteFood, collegeOfInterest, careerGoals, joinDate)
            VALUES ('$personId', '$birthday', '$gender', '$ethnicity', '$gradClass', 
                    '$favFood', '$collegeIntr', '$jobGoal', '$currDate')";

    return mysqli_query($cnxn, $dreamerInsert);
}

function saveParticipant($cnxn, $firstName, $lastName, $email, $phoneNum, $birthday, $gender, $ethnicity, $gradClass,
            $favFood, $collegeIntr, $jobGoal) {
    $personQResult = insertPerson($cnxn, $firstName, $lastName, $email, $phoneNum);
    $dreamerQResult = false;

    // If inserted into person table, then can insert rest of data into participant table
    if ($personQResult) {
        $personId = $cnxn->insert_id;
        $currDate = date("Y-m-d");

        $dreamerQResult = insertDreamer($cnxn, $personId, $birthday, $gender, $ethnicity, $gradClass,
            $favFood, $collegeIntr, $jobGoal, $currDate);
    }
    return $personQResult && $dreamerQResult;
}