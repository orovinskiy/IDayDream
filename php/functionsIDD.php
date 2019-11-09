<?php
//checks if it is a straight text field
function validName($name){
    if($name === "" || $name != htmlspecialchars($name) || !ctype_alpha($name)){
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
function validGender($array, $input){
    if(!in_array($input, $array)){
        return false;
    }
    return true;
}

//looks to see if the given value is inside the array
function validEthic($array, $input){
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