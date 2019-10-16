/*// Puts the buttons into a array
let buttonList = document.getElementsByTagName("button");

// accesses all the buttons for the availability

for(let i = 0; i < buttonList.length; i++){
    buttonList[i].addEventListener("click",function(){buttonType(i)})
}

function buttonType(week){
    this.className= "hidden";
    console.log("i went through");
}*/

document.getElementById("other-interest").addEventListener("change", toggleDisplay);


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