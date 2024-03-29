<?php

// Included files
include('debugging.php');


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
 * see if the date is in a MM/DD/YYYY format
 * @param $date input from the user
 * @return true or false
 */
function validDate($date){
    if (preg_match("/^(1[0-2]|0{0,1}[1-9])\/(3[0-1]|[0-2]{0,1}[1-9])\/[0-9]{4,4}$/",$date) !== 1 || $date != htmlspecialchars($date)) {
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
 * looks to see if the given value is inside the array
 * @param $input input from the user, $array a array of certain strings
 * @return true or false
 */
function validSelectWText($array, $input){
    if(!isset($input)){
        return true;
    }
    $valid = true;
    foreach($input as $interest){
        if(!in_array($interest,$array)){
            $valid = false;
        }
    }
    return $valid;
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
        preg_match("/^\(\d{3}\)\s\d{3}-\d{4}/",$number) !== 1){

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
 * checks if the variable only contains letters
 * @param $input input from the user
 * @return true or false
 */
function letterStrict($input){
    $input = str_replace(' ','', $input);
    if(trim($input) === "" || ctype_alpha($input) === false || $input !== htmlspecialchars($input)){
        return false;
    }
    return true;
}

/**
 * checks if the variable only contains numbers
 * @param $input input from the user
 * @return true or false
 */
function numberStrict($input){
    if(trim($input) === "" || ctype_digit($input) === false || $input !== htmlspecialchars($input)){
        return false;
    }
    return true;
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
 * checks text fields for inserted scripts and if it is empty
 * @param $input input from the user
 * @return true or false
 */
function validReqText($input){
    if($input !== htmlspecialchars($input) || trim($input) === ""){
        return false;
    }
    return true;
}

/**
 * Takes a date in the YYYY-MM-DD  format and converts it to
 * MM/DD/YYYY. Returns a string with error message if fails
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
 * Converts db value to readable words
 * @param $value of db tShirtSize value
 * @return string readable words
 */
function formatShirtSize($value) {
    switch ($value) {
        case 'extraSmall':
            return 'Extra Small';
        case 'extraLarge':
            return 'Extra Large';
        default:
            return ucwords($value);
    }
}

/**
 * Converts database value to more specific readable form. Returns "Unspecified" if none.
 * @param $value value of heardAbout from db
 * @return string Specific "Heard about" message
 */
function formatHeardAbout($value) {
    switch ($value) {
        case 'word':
            return 'Word of Mouth/Friend/Colleague';
        case 'web':
            return 'Web/Social Media';
        case 'print':
            return 'Print (Flyer/Poster/Brochure)';
        case 'corporate':
            return 'Corporate Sponsor';
        case 'other':
            return 'Other';
        case '':
            return 'Unspecified';
        default:
            return $value;
    }
}

/**
 * Displays volunteer's interests as a string of a list. Returns "unspecified"
 * if no interests
 * @param $qResult query result for interests
 * @return string list of interests
 */
function formatInterests($qResult) {
    if ($qResult) {
        $interests = '';

        while ($row = mysqli_fetch_assoc($qResult)) {
            $interests .= $row['interestOption'] . ', ';
        }

        // remove comma at the end
        return empty($interests) ? 'Unspecified' : rtrim($interests, ', ');
    }
    return 'Unspecified';
}

/**
 * Formats all references vertically with a blank line inbetween references
 * @param $qResult Select query result
 * @return string formatted references
 */
function formatReferences($qResult) {
    if ($qResult) {
        $references = '';

        while ($row = mysqli_fetch_assoc($qResult)) {
            $references .= ucwords(strtolower($row['firstName'] . ' ' . $row['lastName'])) . '<br>'
                            . strtoLower($row['relationship']) . '<br>'
                            . strtolower($row['email']) . '<br>'
                            . $row['phone'] . '<br>' . '<br>';
        }

        // remove extra newline at the end
        return rtrim($references, '<br>');
    }
    return '';
}

/**
 * Selects a volunteers interests from the db by their id
 * @param $cnxn db connection
 * @param $id id of volunteer
 * @return bool|mysqli_result db result if successful. false if not successful
 */
function getInterestsById($cnxn, $id) {
    $sql = "SELECT interestOption
            FROM volunteerInterest 
            INNER JOIN interest 
                ON volunteerInterest.interestId = interest.interestId
            WHERE volunteerInterest.volunteerId = $id";

    return mysqli_query($cnxn, $sql);
}

/**
 * Gets all references for a volunteer by Id
 * @param $cnxn db connection
 * @param $id volunteer Id
 * @return bool|mysqli_result db result if successful. false if not successful
 */
function getReferencesById ($cnxn, $id) {
    $sql = "SELECT firstName, lastName, phone, email, relationship
            FROM person 
            INNER JOIN reference
                ON person.personId = reference.personId
            WHERE reference.volunteerId = $id";

    return mysqli_query($cnxn, $sql);
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
 * Selects all volunteers and columns from the volunteers table
 * @param $cnxn db connection
 * @return bool|mysqli_result result if successful. false if not
 */
function getAllVolunteers($cnxn) {
    $sql = 'SELECT *
            FROM person 
            INNER JOIN volunteer 
                ON person.personId = volunteer.personId
            INNER JOIN availability
                ON volunteer.volunteerId = availability.volunteerId
            ORDER BY volunteer.volunteerId DESC';

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
 * Inserts given values into the table Interest
 * @param $cnxn: connection to the database.
 * $interest: input from the user
 * @return true or false if successfully added to the database
 */
function insertInterests($cnxn, $interest){
    $interestsInsert = "INSERT INTO interest (interestOption)
                  VALUES ('$interest')";

    return mysqli_query($cnxn, $interestsInsert);
}

/**
 * Inserts given values into the table volunteerInterest
 * @param $cnxn: connection to the database.
 * $volunteerID, $interestID: input from the user
 * @return true or false if successfully added to the database
 */
function insertVolInterest($cnxn, $volunteerID, $interestID ){
    $volInterstInsert = "INSERT INTO  volunteerInterest (volunteerId, interestId)
                         VALUES ('$volunteerID', '$interestID')";

    return mysqli_query($cnxn, $volInterstInsert);
}

/**
 * Inserts given values into the table availability
 * @param $cnxn: connection to the database.
 * $volunteerID, $oneWeek, $weekend: input from the user
 * @return true or false if successfully added to the database
 */
function insertAvailability($cnxn, $volunteerID, $oneWeek, $weekend){
    $availabilityInsert = "INSERT INTO availability (volunteerId, oneWeekSummerCamp, weekend)
                           VALUES ('$volunteerID', '$oneWeek', '$weekend')";

    return mysqli_query($cnxn, $availabilityInsert);
}

/**
 * Inserts given values into the table person
 * @param $cnxn: connection to the database.
 * $personID, $volunteerID, $relationship: input from the user
 * @return true or false if successfully added to the database
 */
function insertReference($cnxn, $personID, $volunteerID, $relationship){
    $referenceInsert = "INSERT INTO reference (personId, volunteerId, relationship)
                        VALUES ('$personID', '$volunteerID', '$relationship')";

    return mysqli_query($cnxn, $referenceInsert);
}

/**
 * Inserts given values into the table volunteer
 * @param $cnxn: connection to the database.
 * $personID, $onMailList, $tShirtSize, $street, $city, $state,
 * $zip, $heardAbout, $motivation, $experience, $skills, $joinDate: input from the user
 * @return true or false if successfully added to the database
 */
function insertVolunteer($cnxn, $personID, $onMailList, $tShirtSize, $street, $city, $state, $zip, $heardAbout, $motivation, $experience, $skills, $joinDate){
    $volunteerInsert = "INSERT INTO volunteer (personId, onMailList, tShirtSize, street, city, state, zip, heardAbout, motivation, experience, skills, joinDate)                                  
                        VALUES ('$personID', '$onMailList', '$tShirtSize', '$street', '$city', '$state', '$zip', '$heardAbout', '$motivation', '$experience', '$skills', '$joinDate')";

    return mysqli_query($cnxn, $volunteerInsert);
}

/**
 * Calls all the related insert functions to capture all the data a volunteer will enter
 * @param $cnxn: connection to the database.
 * $firstName, $lastName, $email, $phone, $onMailList, $tShirtSize, $street, $city, $state, $zip, $heardAbout, $motivation, $experience, $skills,
 * $refFirstArray, $refLastArray, $refPhoneArray, $refMailArray, $refRelationArray,
 * $oneWeek, $weekends, $interestArray: input from the user
 * @return true or false if the called functions successfully add to the database
 */
function saveVolunteer($cnxn, $firstName, $lastName, $email, $phone
    , $onMailList, $tShirtSize, $street, $city, $state, $zip, $heardAbout, $motivation, $experience, $skills,
                       $refFirstArray, $refLastArray, $refPhoneArray, $refMailArray, $refRelationArray,
                       $oneWeek, $weekends,
                       $interestArray){


    $personResult = insertPerson($cnxn, $firstName, $lastName, $email, $phone);

    //checks if the insert into person was successful
    if($personResult){
        $personVolID = $cnxn->insert_id;
        $currDate = date('Y-m-d');

        $volunteerResult = insertVolunteer($cnxn, $personVolID, $onMailList, $tShirtSize, $street, $city, $state, $zip, $heardAbout, $motivation, $experience, $skills, $currDate);

        //checks if the insert into volunteers was successful
        if($volunteerResult){
            $volunteerID = $cnxn->insert_id;

            //inserts all three references. If any fail stops and sends false
            for($i = 1; $i < 4; $i++){
                $personResult = insertPerson($cnxn, $refFirstArray[$i], $refLastArray[$i], $refMailArray[$i], $refPhoneArray[$i]);
                if($personResult === false){
                    return false;
                }

                $personRefID = $cnxn->insert_id;

                $referenceResult = insertReference($cnxn, $personRefID, $volunteerID, $refRelationArray[$i]);
                if($referenceResult === false){
                    return false;
                }
            }

            $availableResult = insertAvailability($cnxn, $volunteerID, $oneWeek, $weekends);

            if($availableResult){
                for($i = 0; $i < count($interestArray); $i++){

                    /*
                     * The following are the Interests that never change. They are marked with a specific id from
                     * the sql table.
                     *
                     * #12 Coordination, #13 Events, #14 Fundraising, #16 Mentoring, #17 Newsletter, #18 Other
                     */
                    switch($interestArray[$i]){
                        case 'coordination':
                            $interestVolResult = insertVolInterest($cnxn, $volunteerID, '12');
                            if($interestVolResult === false){
                                return false;
                            }
                            break;

                        case 'events':
                            $interestVolResult = insertVolInterest($cnxn, $volunteerID, '13');
                            if($interestVolResult === false){
                                return false;
                            }
                            break;

                        case 'fundraising':
                            $interestVolResult = insertVolInterest($cnxn, $volunteerID, '14');
                            if($interestVolResult === false){
                                return false;
                            }
                            break;

                        case 'mentoring':
                            $interestVolResult = insertVolInterest($cnxn, $volunteerID, '16');
                            if($interestVolResult === false){
                                return false;
                            }
                            break;

                        case 'newsletter':
                            $interestVolResult = insertVolInterest($cnxn, $volunteerID, '17');
                            if($interestVolResult === false){
                                return false;
                            }
                            break;

                        case 'other':
                            $interestVolResult = insertVolInterest($cnxn, $volunteerID, '18');
                            if($interestVolResult === false){
                                return false;
                            }
                            break;

                        default:
                            $interestResult = insertInterests($cnxn, $interestArray[$i]);
                            if($interestResult === false){
                                return false;
                            }

                            $interestID = $cnxn->insert_id;

                            $interestVolResult = insertVolInterest($cnxn, $volunteerID, $interestID);
                            if($interestVolResult === false){
                                return false;
                            }
                            break;
                    }
                }
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}

/**
 * Inserts given values into the table participant
 * @param $cnxn: connection to the database.
 * $birthday, $gender, $ethnicity, $gradClass, $favFood, $collegeIntr,
 * $personId, $personId, $jobGoal: input from the user.
 * @return true or false if successfully added to the database
 */
function insertDreamer($cnxn, $personId, $guardianId, $birthday, $gender, $ethnicity, $gradClass,
                       $favFood, $collegeIntr, $jobGoal, $currDate) {
    $dreamerInsert =
        "INSERT INTO participant (personId, guardianId, birthday, gender, ethnicity, graduatingClass, 
                                      favoriteFood, collegeOfInterest, careerGoals, joinDate)
            VALUES ('$personId', '$guardianId', '$birthday', '$gender', '$ethnicity', '$gradClass', 
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
                         $favFood, $collegeIntr, $jobGoal, $guardianFName, $guardianLName, $guardianEmail, $guardianPhoneNum) {
    $guardianQResult = insertPerson($cnxn, $guardianFName, $guardianLName, $guardianEmail, $guardianPhoneNum);
    if ($guardianQResult) {
        $guardianId = $cnxn->insert_id;
    }
    else {
        return false;
    }

    $personQResult = insertPerson($cnxn, $firstName, $lastName, $email, $phoneNum);
    $dreamerQResult = false;

    // If inserted into person table, then can insert rest of data into participant table
    if ($personQResult) {
        $personId = $cnxn->insert_id;
        $currDate = date("Y-m-d");

        $dreamerQResult = insertDreamer($cnxn, $personId, $guardianId, $birthday, $gender, $ethnicity, $gradClass,
            $favFood, $collegeIntr, $jobGoal, $currDate);
    }
    return $personQResult && $dreamerQResult;
}

/**
 * Gets the guardian/parent of a participant
 * @param $cnxn db connection
 * @param $guardianId
 * @return bool|mysqli_result
 */
function getGuardian($cnxn, $guardianId) {
    $sql =
        "SELECT * FROM person WHERE $guardianId = personId";

    return mysqli_query($cnxn, $sql);
}

function updateVolunteerStatus($cnxn, $volId, $status) {
    $sql = "UPDATE volunteer 
            SET activity= '$status' 
            WHERE volunteerId = '$volId'";

    mysqli_query($cnxn, $sql);
}