<?php

/**
 * checks if it is a straight text field
 * @param $name the input to make sure it doesnt have
 * unnecessary characters
 * @return true or false
 */
function validName($name){
    $nameArray = array('1','2','3','4','5','6','7','8','9','0','#','@','$','%');
    if($name === "" || $name != htmlspecialchars($name) || !formatCheck($nameArray,$name) || is_numeric($name)){
        return false;
    }
    return true;
}

/**
 * see if the date is in a YYYY-MM-DD format
 * @param $date input from the user
 * @return true or false
 */
function validDate($date){
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date) ||
        $date != htmlspecialchars($date)) {
        return false;
    }
    return true;
}

/**
 * looks to see if the given value is inside the array
 * @param $input input from the user, $array a array of certain strings
 * @return true or false
 */
function validSelect($array, $input){
    if(!in_array($input, $array)){
        return false;
    }
    return true;
}

/**
 * looks to see if the given value is formatted correct
 * @email $input input from the user
 * @return true or false
 */
function validMail($email){
    if(trim($email) === "" || $email !== htmlspecialchars($email) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)){

        return false;

    }
    return true;
}

/**
 * looks to see if the given value is formatted correct
 * @param $number input from the user
 * @return true or false
 */
function validNumber($number){
    if(trim($number) === "" || $number !== htmlspecialchars($number) ||
        !preg_match("/^[0-9\-\(\)\/\+\s]*$/",$number)){

        return false;

    }
    return true;
}

/**
 * checks for undesired characters
 * @param $input input from the user, $array a array of certain strings
 * @return true or false
 */
function formatCheck($array, $input){
    $valid = true;

    for($i = 0; $i < count($array); $i++){
        if(strpos($input,$array[$i]) !== false){
            $valid = false;
        }
    }

    return $valid;
}

/**
 * checks text fields for inserted scripts
 * @param $input input from the user
 * @return true or false
 */
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

/**
 * selects all the information about dreamers by joining person table
 * with the participant table. Also orders it by the most recent entry
 * @param $cnxn connection to the database
 * @return mysqli_result object
 */
function getAllDreamers($cnxn) {
    $sql = 'SELECT *
            FROM person 
            INNER JOIN participant 
                ON person.personId = participant.personId
            ORDER BY participantId DESC';

    return mysqli_query($cnxn, $sql);
}

/**
 * Inserts given values into the table person
 * @param $cnxn: connection to the database.
 * $firstName, $lastName, $email, $phone: input from the user
 * @return true or false if successfully added to the database
 */
function insertPerson($cnxn, $firstName, $lastName, $email, $phone) {
    $personInsert = "INSERT INTO person (firstName, lastName, email, phone)
            VALUES ('$firstName', '$lastName', '$email', '$phone')";

    return mysqli_query($cnxn, $personInsert);
}

/**
 * Inserts given values into the table participant
 * @param $cnxn: connection to the database.
 * $birthday, $gender, $ethnicity, $gradClass, $favFood, $collegeIntr,
 * $personId, $personId, $jobGoal: input from the user.
 * @return true or false if successfully added to the database
 */
function insertDreamer($cnxn, $personId, $birthday, $gender, $ethnicity, $gradClass,
                       $favFood, $collegeIntr, $jobGoal, $currDate) {
    $dreamerInsert =
        "INSERT INTO participant (personId, birthday, gender, ethnicity, graduatingClass, 
                                      favoriteFood, collegeOfInterest, careerGoals, joinDate)
            VALUES ('$personId', '$birthday', '$gender', '$ethnicity', '$gradClass', 
                    '$favFood', '$collegeIntr', '$jobGoal', '$currDate')";

    return mysqli_query($cnxn, $dreamerInsert);
}

/**
 * Inserts given values into the table participant and person
 * @param $cnxn: connection to the database.
 * $personId: gets id of person from table person
 * $birthday, $gender, $ethnicity, $gradClass, $favFood, $collegeIntr, $jobGoal: input from the user.
 * $currDate: formats the given date
 * @return true or false if successfully added to the database
 */
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