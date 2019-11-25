// Regex found at https://regexr.com/
const EMAIL_REGEX = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;

// Regex found at https://stackoverflow.com/questions/4338267/validate-phone-number-with-javascript
const PHONE_REGEX = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

// Regex found at https://stackoverflow.com/questions/13194322/php-regex-to-check-date-is-in-yyyy-mm-dd-format
// const BIRTHDAY_REGEX =/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
// Regex found at https://forum.codeigniter.com/thread-68064.html
const BIRTHDAY_REGEX = /^(\d{2})\/(\d{2})\/(\d{4})$/;

document.getElementById("welcomeForm").onsubmit = validateForm;

/**
 * gets ethnicity select and sees if other is selected. if selected then shows
 * the other input box
 **/
let $ethnicity = $("#ethnicity");
$ethnicity.on("change", function(){
    if($ethnicity.val() === "other"){
        $("#otherGroup").removeClass("hidden");

    }
    else{
        $("#otherGroup").addClass("hidden");
    }
});

/**
 * Checks required fields for values and if format is correct. Shows error messages
 * and rejects form submission if the form is not valid.
 * @returns {boolean} true if form is valid
 */
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
        scrollTo(0, 0);
    }

    return isValid;
}

/**
 * Validates all formats including email, phone number and birthday
 * @returns {boolean}
 */
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

    //checks for a valid date format
    let birthdayInput = document.getElementById("birthday");
    if (!validateFormat(birthdayInput, BIRTHDAY_REGEX)){
        isValid = false;
    }

    // Check if the guardian email format is valid and how error msgs if not
    let guardianEmailInput = document.getElementById("guardianEmail");
    if (!validateFormat(guardianEmailInput, EMAIL_REGEX)) {
        isValid = false;
    }

    // Check if the guardian phone format is valid and how error msgs if not
    let guardianPhoneInput = document.getElementById("guardianPhone");
    if (!validateFormat(guardianPhoneInput, PHONE_REGEX)) {
        isValid = false;
    }

    return isValid;
}

/**
 * Shows error message if format is not valid.
 * @param input input containing email value
 * @param regexp regular expression to test format
 * @returns {boolean} true if email is valid
 */
function validateFormat(input, regexp) {
    let inputTxt = input.value.trim();

    // only display msg for valid format if characters are typed
    if (inputTxt !== "" && !regexp.test(inputTxt)) {

        // error message id is the id of the input it belongs to + "ErrFormat"
        let errMsg = document.getElementById(input.id + "ErrFormat");
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

    if (val === "") {

        // Error message id is the id of the input it belongs to + "Err"
        let errMsg = document.getElementById(input.id + "Err");
        let label = document.querySelector("label[for=" + input.id + "]");

        showError(errMsg, input, label);
        return false;
    }
    return true;
}

/**
 * Displays hidden error message and puts red border around input field changes label text to red
 * @param errMsg
 * @param input
 * @param label
 */
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