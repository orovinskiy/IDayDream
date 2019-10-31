
document.getElementById("volunteerForm").onsubmit = validateForm;

document.getElementById("other-interest").addEventListener("change", function() {
    toggleDisplay(document.getElementById("other-section"), this.checked);
});

document.getElementById("weekends").addEventListener("change", function() {
   toggleDisplay(document.getElementById("weekendTimesSection"), this.checked);
});

document.getElementById("howDidHear").addEventListener("change", function () {
   toggleDisplay(document.getElementById("otherHowDidHearSection"), this.value === "other");
});

let validate = true;

//prevents user from going back. Gotten from a user at stackoverflow.
/*function preventBack(){window.history.forward();}
setTimeout("preventBack()", 0);
window.onunload=function(){null};*/

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



// grabs all helper functions to fully validate the full form
function validateForm(){
    validate = true;
    //validates Personal Information
    validText("firstNameLabel","firstName","fNameError");
    validText("lastNameLabel","lastName","lNameError");
    validNumber("phoneNumLabel", "pNumber","numError");
    validMail("mailLabel", "eMail","emailError");
    validSelect("labelShirt","shirtSize","tShirtError");

    //Validates Address fields
    validText("labelStreet","street","streetError");
    validText("labelCity","city","cityError");
    validNumber("labelZip","zip","zipError");

    //Validates How did you hear
    //validSelect("labelHowDidHear","howDidHear")

    //Validates Why Motivated you textarea
    validText("labelGetToKnow","getToKnow","getToKnowError");

    //Validates all three references
    validReferences();

    //Validates they agree to the background
    validBackGround();
    if(validate === false){
        window.scrollTo(0,0);
    }
    return validate;
}

function addClass($input,$label){
    $input.addClass("border-danger");
    $label.addClass("text-danger");
}

function removeClass($input, $label){
    $input.removeClass("border-danger");
    $label.removeClass("text-danger");
}

function spanErrorDisplay(error){
    $("#"+error).show();
}

function spanErrorRemove(error){
    $("#"+error).hide();
}

//Validates any text fields
function validText(label,input,error){
   let $label = $("#"+label);
   let $input = $("#"+input);

   spanErrorRemove(error);
   removeClass($input,$label);

   if($input.val().trim() === "" || isNaN($input.val()) === false){
       addClass($input,$label);
       spanErrorDisplay(error);
       validate = false;
       return false;
   }
}


//Validates only numbers
function validNumber(label,input,error){
    let $label = $("#"+label);
    let $input = $("#"+input);
    let text = $input.val();

    spanErrorRemove(error);
    removeClass($input,$label);

    text = text.replace("(","");
    text = text.replace(")","");
    text = text.replace(/-/g,"");


    if(isNaN(text) || text.trim() === "" ){
        addClass($input,$label);
        spanErrorDisplay(error);
        validate = false;
        return false;
    }

}

//Validates only a email
function validMail(label,input,error){
    let $label = $("#"+label);
    let $input = $("#"+input);

    spanErrorRemove(error);
    removeClass($input,$label);


    if ($input.val().trim() === ""  || $input.val().indexOf("@") === -1 || $input.val().indexOf(".") === -1) {
        addClass($input,$label);
        spanErrorDisplay(error);
        validate = false;
        return false;
    }


}

//Validates anything that is a Select Dom
function validSelect(label,input,error){
    let $label = $("#"+label);
    let $input = $("#"+input);

    removeClass($input,$label);
    spanErrorRemove(error);

    if($input.val() === "none"){
        addClass($input,$label);
        spanErrorDisplay(error);
        validate = false;
    }

}

//Validates References all three must be filled
function validReferences(){

    let count = 3;
    for(let i = 1; i < 4; i++){
        let holder = validText("labelRefFullName"+i, "refFullName"+i);
        let holder1 = validText("labelRefRelationship"+i,"refRelationship"+i);
        let holder2 = validNumber("labelRefPhone"+i,"refPhone"+i);
        let holder3 = validMail("labelRefEmail"+i,"refEmail"+i);
        if(holder === false || holder1 === false || holder2 === false || holder3 === false){
            count--;
        }
    }
    $("#errReferences").hide();

    if(count !== 3){
        $("#errReferences").show();
        document.getElementById("errReferences").innerHTML = "*Requires 3 References: "+count+"/3";
    }

}

//Validates if the agree to the background
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

// redirects to a new page if background is not accepted
$("#no").on("click",function(){
    document.location = "bye.html";
});