//Validates the fields on submit
document.getElementById("emailComposer").onsubmit = validateAllFields;

/**
 * Adds red color from input and lobel
 * @param inputID to add red border and add red text color
 */
function turnFieldRed(inputID){
    $('#'+inputID).addClass("border-danger");
    $('#'+inputID+'Label').addClass("text-danger");
}

/**
 * Removes red color from input and lobel
 * @param inputID to remove red border and remove red text color
 */
function removeRed(inputID){
    $('#'+inputID).removeClass("border-danger");
    $('#'+inputID+'Label').removeClass("text-danger");
}

/**
 * Shows error message element
 * @param error message element to display
 */
function spanErrorDisplay(error){
    $('#'+error+'Error').removeClass('hidden');
}

/**
 * Hides error message element
 * @param error message element to hide
 */
function spanErrorRemove(error){
    $('#'+error+'Error').addClass('hidden');
}

function validateAllFields(){
    let valid = true;
    let reqFields = document.getElementsByClassName("required");

    for(let i = 0; i < reqFields.length; i++){

        if(!validateRequired(reqFields[i])){
            valid = false;
        }
    }

    return valid
}

/**
 * Hides error message element
 * @param input to check if not empty
 */
function validateRequired(input){
    let val = input.value.trim();
    spanErrorRemove(input.id);
    removeRed(input.id);

    if(val === ""){
        spanErrorDisplay(input.id);
        turnFieldRed(input.id);
        return false;
    }
    return true
}