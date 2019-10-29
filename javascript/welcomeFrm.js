document.getElementById("welcomeForm").onsubmit = validateForm;

function validateForm() {
    clearAllErrMsgs();

    let isValid = true;

    // Make sure all required text has content and show any error msgs
    if (!validateAllRequired()) {
        isValid = false;
    }

    return isValid;
}

/**
 * Checks if all required inputs that accept text contain text that is not whitespace.
 * If not field is not valid it's error message is shown
 * @returns {boolean} true if all required inputs that accept text contain text
 */
function validateAllRequired() {
    let hasAllText = true;
    let reqTxtInputs = document.getElementsByClassName("required");

    // check all required inputs that accept text
    for (let i = 0; i < reqTxtInputs.length; i++) {

        if (!validateRequired(reqTxtInputs[i])) {
            hasAllText = false;
        }
    }
    return hasAllText;
}

/**
 * Shows error message if input's value is empty
 * @param input the input to check the value of
 * @returns {boolean} true if not empty excluding whitespace
 */
function validateRequired(input) {
    let val = input.value.trim();

    if (val == "") {

        // Error message id is "err-" + the id of the input it belongs to
        let errMsg = document.getElementById("err-" + input.id);
        errMsg.style.display = "initial";

        return false;
    }
    return true;
}

/**
 * Hides all the error messages appearing next to input fields
 */
function clearAllErrMsgs() {
    let errors = document.getElementsByClassName("error");

    for (let i = 0; i < errors.length; i++) {
        errors[i].style.display = "none";
    }
}