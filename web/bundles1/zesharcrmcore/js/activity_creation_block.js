$(document).ready(function(){
    $('select[id$="_frequency"]').change(function(){
        frequency = $('select[id$="_frequency"] :selected').val();
        switch(frequency) {
            case '1':
                option_id = "time";
                break;
            case '2':
                option_id = "day";
                break;
            case '3':
                option_id = "date";
                break;
            case '4':
                option_id = "month_date";
                break;
        }
        showBlock(option_id);
    });

    $('button.btn-success').click(function(event){
        selected_id = $('div#custom_slot').find('div.selected').attr('id');
        year = $('select#'+id+'_startsAt_year :selected').val();
        month = $('select#'+id+'_startsAt_month :selected').val();
        day = $('select#'+id+'_startsAt_day :selected').val();
        time = 0;
        minutes = 0;
        switch(selected_id) {
            case 'time':
                $('input#'+id+'_slotString').val('')
                time = $('select#slot_time_hours :selected').val();
                minutes = $('select#slot_time_minutes :selected').val();
                option = $('select#slot_time_option :selected').val();

                s_minutes = $('select#slot_time_minutes :selected').text();
                s_option = $('select#slot_time_option :selected').text();
                $('input#'+id+'_slotString').val(time+':'+s_minutes+''+s_option);
                if(option == '1'){
                    time = parseInt(time) + 12;
                };
                break;
            case 'day':
                s_day = $('select#slot_day :selected').text();
                $('input#'+id+'_slotString').val(s_day);
                break;
            case 'date':
                day = $('select#slot_date :selected').val();
                s_day = $('select#slot_date :selected').text();
                $('input#'+id+'_slotString').val(s_day);
                break;
            case 'month_date':
                month = $('select#slot_month :selected').val();
                day = $('select#slot_month_date :selected').val();
                s_month = $('select#slot_month :selected').text();
                s_day = $('select#slot_month_date :selected').text();
                $('input#'+id+'_slotString').val(s_month+'/'+s_day);
                break;
        }
        setWholeDate(year, month, day, time, minutes);
        //event.preventDefault();
    });
});


var id = $('select[id$="_frequency"]').attr('id').split("_")[0];

function setWholeDate(year, month, day, time, minutes){
    $('div#'+id+'_slot').find('select#'+id+'_slot_date_year').find('option[value="'+year+'"]').attr('selected', 'selected');
    $('div#'+id+'_slot').find('select#'+id+'_slot_date_month').find('option[value="'+month+'"]').attr('selected', 'selected');
    $('div#'+id+'_slot').find('select#'+id+'_slot_date_day').find('option[value="'+day+'"]').attr('selected', 'selected');
    $('div#'+id+'_slot').find('select#'+id+'_slot_time_hour').find('option[value="'+time+'"]').attr('selected', 'selected');
    $('div#'+id+'_slot').find('select#'+id+'_slot_time_minute').find('option[value="'+minutes+'"]').attr('selected', 'selected');
}

function showBlock(option_id){
    $('div#custom_slot').find('div').css('display', 'none');
    $('div#custom_slot').find('div').removeClass('selected');
    $('div#'+option_id).css('display', 'block');
    $('div#'+option_id).addClass('selected');
}

function showDate(){
    var dateObj = new Date();
    var month = dateObj.getUTCMonth() + 1;
    var day = dateObj.getUTCDate();
    var tomorrowDay = day + 1;
    var year = dateObj.getUTCFullYear();

    $('select[id$="_startsAt_year"]').find('option[value="'+year+'"]').attr('selected', 'selected');
    $('select[id$="_startsAt_month"]').find('option[value="'+month+'"]').attr('selected', 'selected');
    $('select[id$="_startsAt_day"]').find('option[value="'+day+'"]').attr('selected', 'selected');

    $('select[id$="_finishesAt_year"]').find('option[value="'+year+'"]').attr('selected', 'selected');
    $('select[id$="_finishesAt_month"]').find('option[value="'+month+'"]').attr('selected', 'selected');
    $('select[id$="_finishesAt_day"]').find('option[value="'+tomorrowDay+'"]').attr('selected', 'selected');
}

function autocomplete(){
    frequency = $('select[id$="_frequency"] :selected').val();
    slotString = $('input[id$="_slotString"]').val();
    switch(frequency) {
        case '1':
            option_id = "time";
            fillTime(slotString);
            break;
        case '2':
            option_id = "day";
            fillDay(slotString);
            break;
        case '3':
            option_id = "date";
            fillDate(slotString);
            break;
        case '4':
            option_id = "month_date";
            fillMonthDate(slotString);
            break;
    }
    showBlock(option_id);
}

function fillTime(slotString){
    hours = slotString.split(':')[0];
    str = slotString.split(':')[1];
    options = str.match(/[a-z]/g).join('');

    if(str.match(/\d/g)[0] == 0){
        minutes = str.match(/\d/g)[1];
    }else{
        minutes = str.match(/\d/g).join('');
    }

    if(options == 'am'){
        option = 0;
    }else{
        option = 1;
    }

    $('select#slot_time_hours').find('option[value="'+hours+'"]').attr('selected', 'selected');
    $('select#slot_time_minutes').find('option[value="'+minutes+'"]').attr('selected', 'selected');
    $('select#slot_time_option').find('option[value="'+option+'"]').attr('selected', 'selected');
}

function fillDay(slotString){
    $('select#slot_day').find('option[value="'+slotString+'"]').attr('selected', 'selected');
}

function fillDate(slotString){
    var numb = slotString.match(/\d/g);
    numb = numb.join("");
    $('select#slot_date').find('option[value="'+numb+'"]').attr('selected', 'selected');
}

function fillMonthDate(slotString){
    month = slotString.split('/')[0];
    date = slotString.split('/')[1];

    month = getMonthFromString(month);
    $('select#slot_month').find('option[value="'+month+'"]').attr('selected', 'selected');
    $('select#slot_month_date').find('option[value="'+date+'"]').attr('selected', 'selected');
}

function getMonthFromString(mon){
    return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
}


