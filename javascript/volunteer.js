// Validate form
document.getElementById("volunteerForm").onsubmit = validateForm;

// Toggle "Other Interest" text box display
document.getElementById("other-interest").addEventListener("change", function() {
    toggleDisplay(document.getElementById("other-section"), this.checked);
});

// Toggle "Weekend Available Times" text box display
document.getElementById("weekends").addEventListener("change", function() {
   toggleDisplay(document.getElementById("weekendTimesSection"), this.checked);
});

// Toggle "Other - How Did You Hear About Us?" text box display
document.getElementById("howDidHear").addEventListener("change", function () {
   toggleDisplay(document.getElementById("otherHowDidHearSection"), this.value === "other");
});

// redirects to a new page if background is not accepted
$("#no").on("click",function(){
    document.location = "bye.html";
});

let validate = true;

/**
 * Toggles the display to initial and none for the element parameter belonging to
 * a checkbox
 */
function toggleDisplay(element, isSelected) {
    if (isSelected) {
        element.style.display = "block";
    }
    else {
        element.style.display = "none";
    }
}

/**
 * Validation for the form
 */
function validateForm(){
    validate = true;
    //validates Personal Information
    validText("firstNameLabel","firstName","fNameError");
    validText("lastNameLabel","lastName","lNameError");
    validatePhoneNum("phoneNumLabel", "pNumber","numError");
    validMail("mailLabel", "eMail","emailError");
    validSelect("labelShirt","shirtSize","tShirtError");

    //Validates Address fields
    validText("labelStreet","street","streetError");
    validText("labelCity","city","cityError");
    validatePhoneNum("labelZip","zip","zipError");

    //Validates How did you hear
    //validSelect("labelHowDidHear","howDidHear")

    //Validates Why Motivated you textarea
    validText("labelGetToKnow","getToKnow","getToKnowError");

    //Validates all three references
    validReferences();

    //Validates they agree to the background
    validBackGround();
    if(validate === false){
        scrollTo(0,0);
    }
    return validate;
}

/**
 * Changes text color to red and border around input to red
 * @param $input to give red border
 * @param $label to turn text red
 */
function turnFieldRed($input, $label){
    $input.addClass("border-danger");
    $label.addClass("text-danger");
}

/**
 * Removes red color from input and lobel
 * @param $input to remove red border
 * @param $label to remove red text color
 */
function removeRed($input, $label){
    $input.removeClass("border-danger");
    $label.removeClass("text-danger");
}

/**
 * Shows error message element
 * @param error message element to display
 */
function spanErrorDisplay(error){
    $("#"+error).show();
}

/**
 * Hides error message element
 * @param error message element to hide
 */
function spanErrorRemove(error){
    $("#"+error).hide();
}

/**
 * Validates text fields and shows warnings for errors if invalid
 * @param label of field to validate
 * @param input of field to validate
 * @param error messoge element to display if invalid
 * @returns {boolean} true if valid
 */
function validText(label,input,error){
   let $label = $("#"+label);
   let $input = $("#"+input);

   spanErrorRemove(error);
   removeRed($input,$label);

   if($input.val().trim() === "" || isNaN($input.val()) === false){
       turnFieldRed($input,$label);
       spanErrorDisplay(error);
       validate = false;
       return false;
   }
}


/**
 * Checks if required number is present and checks it's format.
 * Shows warnings if invalid
 * @param label of field to check
 * @param input of field to check
 * @param error message element to show if invalid
 * @returns {boolean} True if value is present and is correct format
 */
function validatePhoneNum(label, input, error){
    let $label = $("#"+label);
    let $input = $("#"+input);
    let text = $input.val();

    spanErrorRemove(error);
    removeRed($input,$label);

    text = text.replace("(","");
    text = text.replace(")","");
    text = text.replace(/-/g,"");

    if(isNaN(text) || text.trim() === "" ){
        turnFieldRed($input,$label);
        spanErrorDisplay(error);
        validate = false;
        return false;
    }
}

/**
 * Checks required for required email and it's format. Shows warnings if invalid
 * @param label of field to check
 * @param input of field to check
 * @param error message to show if invalid
 * @returns {boolean} True if valid
 */
function validMail(label,input,error){
    let $label = $("#"+label);
    let $input = $("#"+input);

    spanErrorRemove(error);
    removeRed($input,$label);


    if ($input.val().trim() === ""  || $input.val().indexOf("@") === -1 || $input.val().indexOf(".") === -1) {
        turnFieldRed($input,$label);
        spanErrorDisplay(error);
        validate = false;
        return false;
    }
}

/**
 * Validates select elements. Shows warnings if invalid
 * @param label of field to validate
 * @param input of field to validate
 * @param error message element to show if invalid
 */
function validSelect(label,input,error){
    let $label = $("#"+label);
    let $input = $("#"+input);

    removeRed($input,$label);
    spanErrorRemove(error);

    if($input.val() === "none"){
        turnFieldRed($input,$label);
        spanErrorDisplay(error);
        validate = false;
    }

}

//Validates References all three must be filled
/**
 * Checks required fields for values
 * Shows warnings if invalid
 */
function validReferences(){

    let count = 3;
    for(let i = 1; i < 4; i++){
        let holder = validText("labelRefFirstName"+i, "refFirstName"+i);
        let holder1 = validText("labelRefLastName"+i, "refLastName"+i);
        let holder2 = validText("labelRefRelationship"+i,"refRelationship"+i);
        let holder3 = validatePhoneNum("labelRefPhone"+i,"refPhone"+i);
        let holder4 = validMail("labelRefEmail"+i,"refEmail"+i);
        if(holder === false || holder1 === false || holder2 === false || holder3 === false || holder4 === false){
            count--;
        }
    }
    $("#errReferences").hide();

    if(count !== 3){
        $("#errReferences").show();
        document.getElementById("errReferences").innerHTML = "*Requires 3 References: "+count+"/3";
    }

}

/**
 * Shows error message if agree to background is not selected
 */
function validBackGround(){

    let back = document.getElementsByName("question");
    let agree = "";
    $("#backGround").hide();

    for(let i = 0; i < back.length; i++){
        if(back[i].checked){
            agree = back[i].value
        }
    }

    if(agree !== "agreed"){
        $("#backGround").show();
    }
}