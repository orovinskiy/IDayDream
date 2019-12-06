// Phone format placeholder
const PHONE_FORMAT = '(___) ___-____';
const PHONE_MAX_LEN = 10; // max amount of digits in phone number
const PREFIX_LEN = 3; // amount of digits in (   ) XXX- part of phone number
const AREA_CODE_LEN = 3; // amount if digits in area code

let phoneNumInputs = document.getElementsByClassName("phoneFormat");

// Set event handlers
for (let i = 0; i < phoneNumInputs.length; i++) {
    phoneNumInputs[i].value = PHONE_FORMAT;

    phoneNumInputs[i].addEventListener("click", putCaret);
    phoneNumInputs[i].addEventListener("keypress", formatPhone);
    phoneNumInputs[i].addEventListener("keydown", formatPhoneDeleteAndMoveCaret);
    phoneNumInputs[i].addEventListener("paste", function () {
        // Clear so pasted number can inserted with max attribute at 14
        this.value = "";
    });

    phoneNumInputs[i].addEventListener("input", function () {
        refreshPhoneFormat(this, this.value.replace(/\D/g,''));
    });
}

/**
 * Sets cursor to in between number if clicked there or after last digit and section
 * @param e event object
 */
function putCaret(e) {

    // only set caret position if not highlighting with cursor
    if (this.selectionStart === this.selectionEnd) {
        let caretPos = getCaretPos(this.value, this.selectionStart);

        setCaretPos(this, caretPos);
    }
}

/**
 * Gets location after preceding number and section
 * @param value phone input value
 * @param start current position of caret
 * @returns {number} position of where caret should be
 */
function getCaretPos(value, start) {
    let caretPos = getPrevNumIndex(value, start) + 1;
    return skipForward(caretPos);
}

/**
 * Updates the phone input's value with formatted numbers
 * @param input the input to set formatted numbers
 * @param numbers the numbers to format
 */
function refreshPhoneFormat(input, numbers) {
    let phone = "";

    // Attach area code
    phone += '(' + numbers.substring(0, AREA_CODE_LEN);

    // Add remaining placeholder to value if complete
    if (numbers.length <= AREA_CODE_LEN) {
        phone += PHONE_FORMAT.substring(phone.length);
        input.value = phone;
        return;
    }

    // Attach prefix
    phone += ') ' + numbers.substring(AREA_CODE_LEN, AREA_CODE_LEN + PREFIX_LEN);

    // Add remaining placeholder to value if complete
    if (numbers.length <= AREA_CODE_LEN + PREFIX_LEN) {
        phone += PHONE_FORMAT.substring(phone.length);
        input.value = phone;
        return;
    }

    // Attach line number
    phone += '-' + numbers.substring(AREA_CODE_LEN + PREFIX_LEN, PHONE_MAX_LEN);;

    // Add remaining placeholder to value if complete
    if (numbers.length <= PHONE_MAX_LEN) {
        phone += PHONE_FORMAT.substring(phone.length);
        input.value = phone;
        return;
    }

    input.value = phone;
}

/**
 * Formats numbers from input and sets the caret to usable position
 * @param e event
 */
function formatPhone(e) {

    // Get typed in character
    let num = String.fromCharCode(e.which);

    // Remove non-digits
    let numbers = this.value.replace(/\D/g,'');

    // if a number is pressed and is less than 10 or at least a number is selected for replacement
    if (/\d/.test(num) && (numbers.length < PHONE_MAX_LEN || this.selectionStart !== this.selectionEnd)) {

        // Concat numbers minus removed digits + added digit;
        numbers = updateNumbers(numbers, this.selectionStart, this.selectionEnd, num, 0, 0);

        // Set caret after preceding number and to next section if necessary
        let caretPos = getCaretPos(this.value, this.selectionStart);

        // For inserted character
        caretPos++;

        // Skip non-digits after insertion
        caretPos = skipForward(caretPos);

        // Refresh formatted numbers into input
        refreshPhoneFormat(this, numbers);

        setCaretPos(this, caretPos);
    }
    e.preventDefault();
}

/**
 * Updates numbers with inserted or removed values
 * @param numbers numbers to update
 * @param start location before number insertion or after removal of previous number
 * @param end location after number insertion or before removal of next number
 * @param insertedNum the number to insert between start and end
 * @param minusPrevQty Amount of digits to remove before start
 * @param minusNextQty Amount of digits to remove after end
 * @returns {string} numbers with inserted or removed values
 */
function updateNumbers(numbers, start, end, insertedNum, minusPrevQty, minusNextQty) {

    // Insert num in numbers at corresponding location of caret
    let startNumIndex = getNumbersIndex(start);

    let preNums = "";
    let postNums = "";

    // If user did not highlight for deletion
    if (start === end) {

        // To concat numbers minus previous or minus next digit(s)
        preNums = numbers.substring(0, startNumIndex - minusPrevQty);
        postNums = numbers.substring(startNumIndex + minusNextQty);
    }
    else { // To concat numbers minus highlighted selection
        preNums = numbers.substring(0, startNumIndex);
        postNums = numbers.substring(getNumbersIndex(end));
    }

    // Concat numbers minus removed digits + added digit;
    return preNums + insertedNum + postNums;
}

/**
 * Skip caret after non-digits
 * @param caretPos current position of caret
 * @returns {*} caret position after skipping non digits
 */
function skipForward(caretPos) {
    // if before ') '
    if (caretPos === 4) {
        caretPos += 2;

    // if before '-'
    } else if (caretPos === 9) {
        caretPos++;
    }
    return caretPos;
}

/**
 * Gets index of previous number from current index
 * @param str string to search for previous number
 * @param currIndex current index
 * @returns {number} index of previous number
 */
function getPrevNumIndex(str, currIndex) {
    for (let i = currIndex - 1; 0 <= i; i--) {
        if (/\d/.test(str.charAt(i))) {
            return i;
        }
    }
    return 0;
}

/**
 * Finds corresponding location in a string of only
 * numbers from the formatted phone number
 * @param numIndex index of number in formatted phone number
 * @returns {number} index of number if string of only numbers
 */
function getNumbersIndex(numIndex) {

    // For '('
    if (numIndex <= 4) {
        return numIndex - 1;
    }
    // For '()'
    if (numIndex <= 5) {
        return numIndex - 2;
    }
    // if passed '(XXX), ', then account for '() '
    if (numIndex <= 9) {
        return numIndex - 3;
    }
    // if passed '(XXX) XXX-', then account for '() -'
    return numIndex - 4;
}

/**
 * Removes number(s) from input by backspace and delete.
 * Moves caret left and right with arrows while skipping non-digits
 * @param e event
 */
function formatPhoneDeleteAndMoveCaret(e) {

    let numbers = this.value.replace(/\D/g,'');

    // if backspace
    if (e.which === 8) {

        // Concat numbers minus removed digits
        numbers = updateNumbers(numbers, this.selectionStart, this.selectionEnd,
                        "", 1, 0);

        // Set caret after preceding number and section
        let caretPos = getCaretPos(this.value, this.selectionStart);

        // If user did not highlight for deletion skip over section separators
        if (this.selectionStart === this.selectionEnd) {
            caretPos = skipBack(caretPos);

            // If not at beginning
            if (caretPos !== 1) {
                // For removed character
                caretPos--;
            }
        }
        refreshPhoneFormat(this, numbers);

        setCaretPos(this, caretPos);

        e.preventDefault();
    }
    // If delete
    else if (e.which === 46) {

        // Concat numbers minus removed digits
        numbers = updateNumbers(numbers, this.selectionStart, this.selectionEnd,
                        "", 0, 1);

        // Set caret after preceding number and section
        let caretPos = getCaretPos(this.value, this.selectionStart);

        refreshPhoneFormat(this, numbers);

        setCaretPos(this, caretPos);

        e.preventDefault();
    }
    // If left arrow
    else if (e.which === 37) {
        let caretPos = this.selectionStart;

        // If right after ') '
        if (caretPos === 6) {
            caretPos -= 2;
        }
        // If right after '('
        else if (caretPos !== 1) {
            caretPos--;
        }
        setCaretPos(this, caretPos);

        e.preventDefault();
    }
    // If right arrow
    else if (e.which === 39) {
        let caretPos = this.selectionStart;

        let numIndex = getNumbersIndex(caretPos);

        // Do not go right if no number on the right side
        if (numbers.charAt(numIndex) === "") {
            e.preventDefault();
            return;
        }

        // If right before ') '
        if (caretPos === 4) {
            caretPos += 2;
        }
        else {
            caretPos++;
        }
        setCaretPos(this, caretPos);

        e.preventDefault();
    }
}

/**
 * Sets the position of the caret in the input
 * @param input input to set position in
 * @param caretPos position to set of caret
 */
function setCaretPos(input, caretPos) {
    input.selectionStart = caretPos;
    input.selectionEnd = caretPos;
}

/**
 * Caret skips back over non-digits
 * @param caretPos current caret position
 * @returns {*} new position of caret after skipping non digits
 */
function skipBack(caretPos) {

    // For ') '
    if (caretPos === 6) {
        caretPos -= 2;

    } // For '-'
    else if (caretPos === 10) {
        caretPos--;
    }
    return caretPos;
}

