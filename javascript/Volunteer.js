
document.getElementById("volunteerForm").onsubmit = validateForm;
document.getElementById("other-interest").addEventListener("change", toggleDisplay);

let validate = true;

//prevents user from going back. Gotten from a user at stackoverflow.
function preventBack(){window.history.forward();}
setTimeout("preventBack()", 0);
window.onunload=function(){null};

/**
 * Shows the hidden Other text box and label when the user clicks the other checkbox
 */
function toggleDisplay() {
    var otherSection = document.getElementById("other-section");
    if (this.checked) {
        otherSection.style.display = "initial";
    }
    else {
        otherSection.style.display = "none";
    }
}

/**
 * Validation for the form
 */



// grabs all helper functions to fully validate the full form
function validateForm(){
    validate = true;
    //validates Personal Information
    validText("firstNameLabel","firstName");
    validText("lastNameLabel","lastName");
    validNumber("phoneNumLabel", "pNumber");
    validMail("mailLabel", "eMail");
    validSelect("labelShirt","shirtSize");

    //Validates Address fields
    validText("labelStreet","street");
    validText("labelCity","city");
    validNumber("labelZip","zip");

    //Validates How did you hear
    //validSelect("labelHowDidHear","howDidHear")

    //Validates Why Motivated you textarea
    validText("labelGetToKnow","getToKnow");

    //Validates all three references
    validReferences();

    //Validates they agree to the background
    validBackGround();
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

//Validates any text fields
function validText(label,input){
   let $label = $("#"+label);
   let $input = $("#"+input);

   removeClass($input,$label);

   if($input.val().trim() === "" || isNaN($input.val()) === false){
       addClass($input,$label);
       validate = false;
       return false;
   }
}

//Validates only numbers
function validNumber(label,input){
    let $label = $("#"+label);
    let $input = $("#"+input);

    removeClass($input,$label);

    if(isNaN($input.val()) || $input.val().trim() === "" ){
        addClass($input,$label);
        validate = false;
        return false;
    }

}

//Validates only a email
function validMail(label,input){
    let $label = $("#"+label);
    let $input = $("#"+input);

    removeClass($input,$label);


    if ($input.val().trim() === ""  || $input.val().indexOf("@") === -1 || $input.val().indexOf(".") === -1) {
        addClass($input,$label);
        validate = false;
        return false;
    }


}

//Validates anything that is a Select Dom
function validSelect(label,input){
    let $label = $("#"+label);
    let $input = $("#"+input);

    removeClass($input,$label);

    if($input.val() === "none"){
        addClass($input,$label);
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
    $("#err-References").addClass("hidden");

    if(count !== 3){
        $("#err-References").removeClass("hidden");
        document.getElementById("err-References").innerHTML = "*Requires 3 References: "+count+"/3";
    }

}

//Validates if the agree to the background
function validBackGround(){

    let back = document.getElementsByName("question");
    let agree = "";
    $("#backGround").addClass("hidden");

    for(let i = 0; i < back.length; i++){
        if(back[i].checked){
            agree = back[i].value
        }
    }

    if(agree !== "agreed"){
        $("#backGround").removeClass("hidden");
    }
}

// redirects to a new page if background is not accepted
$("#no").on("click",function(){
    document.location = "bye.html";
});