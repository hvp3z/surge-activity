$(document).ready(function() {
    "use strict";

    var wrapper = $(".custom-content");

    wrapper.on("mouseenter", ".widget-performance-title", function(){
        $(this).html($(this).data("hoverTitle"));
    });

    wrapper.on("mouseleave", ".widget-performance-title", function(){
        $(this).html($(this).data("unhoverTitle"));
    });
});