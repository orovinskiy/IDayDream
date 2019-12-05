const PHONE_FORMAT = '(___) ___-____';
const PHONE_MAX_LEN = 10;
const PREFIX_LEN = 3; // amount of digits in (   ) XXX- part of phone number
const AREA_CODE_LEN = 3; // amount if digits in area code

document.getElementById("pNumber").value = PHONE_FORMAT;

document.getElementById("pNumber").addEventListener("click", setCaretPos);
document.getElementById("pNumber").addEventListener("keypress", formatPhone);
document.getElementById("pNumber").addEventListener("keydown", formatPhoneDelete);
document.getElementById("pNumber").addEventListener("paste", function () {
    // Clear so pasted number can inserted with max attribute at 14
    this.value = "";
});

document.getElementById("pNumber").addEventListener("input", function () {
    refreshPhoneFormat(this, this.value.replace(/\D/g,''));
});


function setCaretPos() {

    // only set caret position if not highlighting with cursor
    if (this.selectionStart === this.selectionEnd) {
        let caretPos = getCaretPos(this.value, this.selectionStart);

        this.selectionStart = caretPos;
        this.selectionEnd = caretPos;
    }
}

function getCaretPos(value, start) {

    // Set caret after preceding number and to next section if necessary
    let caretPos = getPrevNumIndex(value, start) + 1;
    return skipForward(caretPos, value.substring(caretPos, caretPos + 1));
}


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
        caretPos = skipForward(caretPos, this.value.substring(caretPos, caretPos + 1));

        // Refresh formatted numbers into input
        refreshPhoneFormat(this, numbers);

        // Set new caret position
        this.selectionStart = caretPos;
        this.selectionEnd = caretPos;
    }
    e.preventDefault();
}

function updateNumbers(numbers, start, end, insertedNum, minusPrevQty, minusNextQty) {

    // Insert num in numbers at corresponding location of caret
    let startNumIndex = getPhoneNumberCurrIndex(start);

    let preNums = "";
    let postNums = "";

    // If user did not highlight for deletion
    if (start === end) {

        // To concat numbers minus previous or minus next digit
        preNums = numbers.substring(0, startNumIndex - minusPrevQty);
        postNums = numbers.substring(startNumIndex + minusNextQty);
    }
    else { // To concat numbers minus highlighted selection
        preNums = numbers.substring(0, startNumIndex);
        postNums = numbers.substring(getPhoneNumberCurrIndex(end));
    }

    // Concat numbers minus removed digits + added digit;
    return preNums + insertedNum + postNums;
}

function skipForward(caretPos, nextChar) {
    if (nextChar === ')') {
        caretPos += 2;
    } else if (nextChar === '-') {
        caretPos++;
    }
    return caretPos;
}

function getPrevNumIndex(str, currIndex) {
    for (let i = currIndex - 1; 0 <= i; i--) {
        if (/\d/.test(str.charAt(i))) {
            return i;
        }
    }
    return 0;
}


function getPhoneNumberCurrIndex(numIndex) {

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

function formatPhoneDelete(e) {

    let numbers = this.value.replace(/\D/g,'');

    // if backspace and has at least a number to delete
    if (e.which === 8) {

        // Concat numbers minus removed digits
        numbers = updateNumbers(numbers, this.selectionStart, this.selectionEnd,
                        "", 1, 0);

        // Set caret after preceding number and section
        let caretPos = getCaretPos(this.value, this.selectionStart);

        // If user did not highlight for deletion skip over section separators
        if (this.selectionStart === this.selectionEnd) {
            caretPos = skipBack(caretPos, this.value.substr(caretPos - 1, 1));
        }

        refreshPhoneFormat(this, numbers);

        // Set caret position
        this.selectionStart = caretPos;
        this.selectionEnd = caretPos;

        e.preventDefault();
    }
    else if (e.which === 46) {

        // Concat numbers minus removed digits
        numbers = updateNumbers(numbers, this.selectionStart, this.selectionEnd,
                        "", 0, 1);

        // Set caret after preceding number and section
        let caretPos = getCaretPos(this.value, this.selectionStart);

        refreshPhoneFormat(this, numbers);

        // Set caret position
        this.selectionStart = caretPos;
        this.selectionEnd = caretPos;

        e.preventDefault();
    }
}

function skipBack(caretPos, prevChar) {

    // For ') '
    if (prevChar === ' ') {
        caretPos -= 2;
    } else if (prevChar === '-') {
        caretPos--;
    }

    // If not at beginning
    if (prevChar !== '(') {
        // For removed character
        caretPos--;
    }
    return caretPos;
}

