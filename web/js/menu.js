/** Menu animation **/
$(document).ready(function() {
    $('.drop-link').click(function () {
        if($(this).attr("href") !== '/admin/dashboard') {
            $(this).next().slideToggle("slow", function () {
                // Animation complete.
            });
        }
    });

    $('.drop-link').mouseenter(function() {
        if($(this).attr("href") == '/admin/dashboard') {
            $(this).next().slideToggle("slow", function () {
                // Animation complete.
            });
        }
    });
});