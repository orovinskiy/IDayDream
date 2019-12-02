const PHONE_FORMAT = '(___) ___-____';
const PHONE_MAX_LEN = 10;
const PREFIX_LEN = 3; // amount of digits in (   ) XXX- part of phone number
const AREA_CODE_LEN = 3; // amount if digits in area code

document.getElementById("pNumber").value = PHONE_FORMAT;
document.getElementById("pNumber").addEventListener("click", setCaretPos);
document.getElementById("pNumber").addEventListener("keypress", formatPhone);
document.getElementById("pNumber").addEventListener("keydown", formatPhoneDelete);

document.getElementById("pNumber").addEventListener("input", function () {
    refreshPhoneFormat(this, this.value.replace(/\D/g,''));
});


function setCaretPos() {
    this.selectionStart = this.value.indexOf('_');
    this.selectionEnd = this.value.indexOf('_');
}


function refreshPhoneFormat(input, numbers) {
    let phone = "";

    // Attach area code
    phone += '(' + numbers.substring(0, AREA_CODE_LEN);

    // Add remaining placeholder to value
    if (numbers.length <= AREA_CODE_LEN) {
        phone += PHONE_FORMAT.substring(phone.length);
        input.value = phone;
        return;
    }

    // Attach prefix
    phone += ') ' + numbers.substring(AREA_CODE_LEN, AREA_CODE_LEN + PREFIX_LEN);

    // Add remaining placeholder to value
    if (numbers.length <= AREA_CODE_LEN + PREFIX_LEN) {
        phone += PHONE_FORMAT.substring(phone.length);
        input.value = phone;
        return;
    }

    // Attach line number
    phone += '-' + numbers.substring(AREA_CODE_LEN + PREFIX_LEN, PHONE_MAX_LEN);;

    // Add remaining placeholder to value
    if (numbers.length <= PHONE_MAX_LEN) {
        phone += PHONE_FORMAT.substring(phone.length);
        input.value = phone;
        return;
    }

    input.value = phone;
}

function attachPhoneSegment(phone, numbers, segStart, segEnd, segSeparator, ) {
    
    // Attach segment
    phone += segSeparator + numbers.substring(segStart, segEnd);

    // Add remaining placeholder to value if complete
    if (numbers.length <= segEnd) {
        phone += PHONE_FORMAT.substring(phone.length);
        input.value = phone;
        return true;
    }
    return false;
}

function formatPhone(e) {

    let num = String.fromCharCode(e.which);
    let numbers = this.value.replace(/\D/g,'');

    if (/[0-9]/.test(num) && numbers.length < PHONE_MAX_LEN) {

        //let caretPos = this.selectionStart;
        let caretPos = getPrevNumIndex(this.value, this.selectionStart) + 1;

        // Insert num in numbers at location of caret
        let numbersIndex = getPhoneNumbersCurrIndex(caretPos);

        let preNums = numbers.substr(0, numbersIndex);
        let postNums = numbers.substr(numbersIndex);

        numbers = preNums + num + postNums;

        refreshPhoneFormat(this, numbers);
        caretPos++;

        // Move cursor to next segment if at the end of a phone number segment
        let nextChar = this.value.substr(caretPos, 1);

        if (nextChar === ')') {
            caretPos += 2;
        } else if (nextChar === '-') {
            caretPos++;
        }

        // Set new cursor position
        this.selectionStart = caretPos;
        this.selectionEnd = caretPos;
    }
    e.preventDefault();
}

function getPrevNumIndex(str, currIndex) {
    for (let i = str.length - 1; 0 <= i; i--) {
        if (/[0-9]/.test(str.charAt(i))) {
            return i;
        }
    }
    return 0;
}

function getPhoneNumbersCurrIndex(caretPos) {

    // accounts for '('
    if (caretPos <= 3) {
        return caretPos - 1;
    }
    // if passed '(XXX), ', then account for '() '
    if (caretPos <= 8) {
        return caretPos - 3;
    }
    // if passed '(XXX) XXX-', then account for '() -'
    return caretPos - 4;
}

function formatPhoneDelete(e) {
    let numbers = this.value.replace(/\D/g,'');

    // if backspace and has at least a number to delete
    if (e.which === 8 && 0 < numbers.length) {
        let caretPos = this.selectionStart;
        let prevChar = this.value.substr(caretPos - 1, 1);

        if (prevChar === '(') {
            e.preventDefault();
            return;
        }

        // delete num in numbers at location of caret
        let numbersIndex = getPhoneNumbersCurrIndex(caretPos);

        let preNums = numbers.substr(0, numbersIndex - 1);
        let postNums = numbers.substr(numbersIndex);

        numbers = preNums + postNums;

        refreshPhoneFormat(this, numbers);
        caretPos--;

        if (prevChar === ' ') {
            caretPos -= 2;
        }
        else if (prevChar === '-') {
            caretPos--;
        }

        this.selectionStart = caretPos;
        this.selectionEnd = caretPos;

        e.preventDefault();
    }

}
