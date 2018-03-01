$(function() {
    google.maps.event.addDomListener(window, 'load', initialize);
    window.gapi_init = initialize;
    function initialize() {
        $('input[id$="state"]').attr('readonly','readonly');
        $('input[id$="city"]').after('<input id="city-value" type="hidden" value="">');
        if($('input[id$="city"]').length > 0){
            if($('input#city-value').length <= 0){
                $('input[id$="city"]').after('<input id="city-value" type="hidden" value="">');
                $('input#city-value').after('<input id="city-autocomplete-validation" type="hidden" value="">');
            }
        }

        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: "us"}
        };

        var input = (document.querySelector('input[id$="city"]'));

        if (input) {
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                message = '';
                city = '';
                state = '';
                if(place){
                    city = place.name;
                    state = getState(place.formatted_address);
                }
                addState(state);
                addCity(city);

                return false;
            });
            google.maps.event.addDomListener(input, 'keydown', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    $('input#city-value').val(true);
                    $(this).css('border-color','#dddddd');
                    $(this).css('color','#555');
                    if($(this).prev().hasClass('error-popup')){
                        removeErrorPopup($(this));
                    }
                }
            });
        }
    }


    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractFirst( term ) {
        return split( term ).shift();
    }
    function extractLast( term ) {
        return split( term ).pop();
    }
    function getState(text){
       arr = split( text );
       state = arr[1].split(' ').shift();
       return state;
    }
    function addState( message ) {
        $('[id$="state"]').val(message);
        $('[id$="state"]').attr('value',message);
        $('[id$="state"]').prop('value',message);

        if(message.length == 0){
            $('input[id$="city"]').css('border-color','#f56954');
            $('input[id$="city"]').css('color','#f56954');
            if(!$('input[id$="city"]').prev().hasClass('error-popup')){
                $('input[id$="city"]').before("<div class='error-popup' style='display:block;'>" +
                    "<p class='label label-danger'> Please, choose city from the list. </p>" +
                    "</div>");
            }
        }else{
            $('input[id$="city"]').css('border-color','#dddddd');
            $('input[id$="city"]').css('color','#555');
            if($('input[id$="city"]').prev().hasClass('error-popup')){
                $('input[id$="city"]').prev().remove();
            }
        }
    }
    function addCity( message ) {
        $('#city-value').val('');
        $('#city-value').val(message);
        $('input[id$="city"]').val('');
        $('input[id$="city"]').val(message);
    }    

});

