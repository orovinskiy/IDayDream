// regex found at https://regexr.com/
const EMAIL_REGEX = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g;

// regex found at https://stackoverflow.com/questions/12317049/how-to-split-a-long-regular-expression-into-multiple-lines-in-javascript
const PHONE_REGEX = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

document.getElementById("welcomeForm").onsubmit = validateForm;

function validateForm() {
    clearAllErrors();

    let isValid = true;

    // Make sure all required text has content and show any error msgs
    if (!validateAllRequired()) {
        isValid = false;
    }

    if (!validateAllFormats()) {
        isValid = false;
    }

    if (!isValid) {
        window.scrollTo(0, 0);
    }

    return isValid;
}

function validateAllFormats() {
    let isValid = true;

    // Check for a valid email and show any error msgs
    let emailInput = document.getElementById("email");
    if (!validateFormat(emailInput, EMAIL_REGEX)) {
        isValid = false;
    }

    // Check for valid phone format and show any error msgs
    let phoneInput = document.getElementById("phone");
    if (!validateFormat(phoneInput, PHONE_REGEX)) {
        isValid = false;
    }
}

/**
 * Shows error message if format is not valid.
 * @param input input containing email value
 * @param regexp regular expression to test format
 * @returns {boolean} true if email is valid
 */
function validateFormat(input, regexp) {
    let inputTxt = input.value.trim();

    // only display msg for valid format if characters are typed in
    if (inputTxt != "" && !regexp.test(inputTxt)) {

        // error message id is "err-format-" + the id of the input it belongs to
        let errMsg = document.getElementById("err-format-" + input.id);
        let label = document.querySelector("label[for=" + input.id + "]");

        showError(errMsg, input, label);

        return false;
    }
    return true;
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
        let label = document.querySelector("label[for=" + input.id + "]");

        showError(errMsg, input, label);
        return false;
    }
    return true;
}

function showError(errMsg, input, label) {
    errMsg.style.display = "initial";
    input.classList.add("border-danger");
    label.classList.add("text-danger");
}

/**
 * Hides all the error messages appearing next to input fields
 */
function clearAllErrors() {
    // Clear all error messages
    let errMsgs = document.getElementsByClassName("error");

    for (let i = 0; i < errMsgs.length; i++) {
        errMsgs[i].style.display = "none";
    }

    // Remove red borders on inputs
    let redInputs = document.getElementsByClassName("border-danger");

    for (let i = redInputs.length - 1; i >= 0; i--) {
        redInputs[i].classList.remove("border-danger");
    }

    // Remove red on all label text
    let redLabels = document.querySelectorAll("label.text-danger");

    for (let i = redLabels.length - 1; i >= 0; i--) {
        redLabels[i].classList.remove("text-danger");
    }

}