$(function() {
    $('div.entity-details-wrap').on('keyup', 'input.length-validate', function() {
        maxLength = 49;
        if($(this).attr('name') == 'other'){
            maxLength = 99;
        }
        if (this.value.length > maxLength){
            $(this).css('border-color','#f56954');
            $(this).css('color','#f56954');
            if(!$(this).prev().hasClass('error-popup')){
                $(this).before("<div class='error-popup' style='display:block;'>" +
                                    "<p class='label label-danger'> The string length should not exceed "+(maxLength+1)+" characters! </p>" +
                                "</div>");
            }
        }else{
            $(this).css('border-color','#dddddd');
            $(this).css('color','#555');
            if($(this).prev().hasClass('error-popup')){
                $(this).prev().remove();
            }
        }
    });

    $('div.entity-details-wrap').on('keyup','input[name="zipcode"]', function(){
        postalCode = $(this).val();
        isPostalCode = isValidPostalCode(postalCode, 'US');
        if(!isPostalCode){
            $(this).css('border-color','#f56954');
            $(this).css('color','#f56954');
            if(!$(this).prev().hasClass('error-popup')){
                addErrorPopup($(this), 'The zipcode doesn\'t match!');
            }
        }else{
            $(this).css('border-color','#dddddd');
            $(this).css('color','#555');
            if($(this).prev().hasClass('error-popup')){
                removeErrorPopup($(this));
            }
        }
        console.log(isPostalCode);
    });

    $('div.entity-details-wrap').on('keyup', 'input', function(){
        if($('div.entity-details').find('.error-popup').length > 0){
            $('div.entity-details').find('button.entity-details-save').css('display','none');
        }else{
            $('div.entity-details').find('button.entity-details-save').css('display','inline-block');
        }
    });

    $('input[id$="city"]').keyup(function(){
        cityValidation = $('#city-autocomplete-validation').val();
        $('input#city-value').val(false);
        $('[id$="state"]').val('');
        $('[id$="state"]').attr('value','');
        $('[id$="state"]').prop('value','');

        $(this).css('border-color','#f56954');
        $(this).css('color','#f56954');
        if(!$(this).prev().hasClass('error-popup')){
            addErrorPopup($(this), 'Please, choose city from the list.');
        }

    });


    function addErrorPopup($element, $message){
        $element.before("<div class='error-popup' style='display:block;'>" +
            "<p class='label label-danger'> "+$message+" </p>" +
            "</div>");
    }

    function removeErrorPopup($element){
        $element.prev().remove();
    }



    function isValidPostalCode(postalCode, countryCode) {
        switch (countryCode) {
            case "US":
                postalCodeRegex = /^([0-9]{5})(?:[-\s]*([0-9]{4}))?$/;
                break;
            case "CA":
                postalCodeRegex = /^([A-Z][0-9][A-Z])\s*([0-9][A-Z][0-9])$/;
                break;
            default:
                postalCodeRegex = /^(?:[A-Z0-9]+([- ]?[A-Z0-9]+)*)?$/;
        }
        return postalCodeRegex.test(postalCode);
    }
});

