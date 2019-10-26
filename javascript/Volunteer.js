
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
    validText("firstNameLabel","firstName","fName-error");
    validText("lastNameLabel","lastName","lName-error");
    validNumber("phoneNumLabel", "pNumber","num-error");
    validMail("mailLabel", "eMail","email-error");
    validSelect("labelShirt","shirtSize","tShirt-error");

    //Validates Address fields
    validText("labelStreet","street","street-error");
    validText("labelCity","city","city-error");
    validNumber("labelZip","zip","zip-error");

    //Validates How did you hear
    //validSelect("labelHowDidHear","howDidHear")

    //Validates Why Motivated you textarea
    validText("labelGetToKnow","getToKnow","getToKnow-error");

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

function spanErrorDisplay(error){
    $("#"+error).removeClass("hidden");
}

function spanErrorRemove(error){
    $("#"+error).addClass("hidden");
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
    text = text.replace("-","");


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