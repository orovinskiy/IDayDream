$(function(){ //When document is ready
    $(".check-fill").focusout(function() { //Prefer keyup so you check after, in case the user delete his entry.
        progressBar();
    });
})

// Got this progress bar auto-fill function from:
// https://stackoverflow.com/questions/37141647/how-to-make-a-progress-bar-that-fills-every-time-a-textbox-is-filled
function progressBar() {
    var $fields = $(".check-fill");
    var count = 0;
    $fields.each(function () {
        if ($(this).val().length > 0)
            count++;
    });

    var percentage = Math.floor(count * 100 / $fields.length);
    //Here you have your percentage;
    $(".progress-bar").css("width", percentage + "%");
    //$(".count").text(percentage + "%");
};