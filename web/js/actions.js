var actionsInit = function($){
    $(document).ready(function(){
        //  custom select
        $('.custom-select-to-init').select2();

        //  sortable drug&drop
        $('.widget-wrap').sortable({
            handle: ".custom-head",
            opacity: "0.9",
            scroll: false
        });

        $('.table-wrap').sortable({
            handle: ".custom-head",
            opacity: "0.9",
            scroll: false
        });

        //  slide up widget
        var $el_widget_menu = $('.custom-menu');

        $el_widget_menu.on('click', '.up-custom', function(){
            $(this).toggleClass('close');
            $(this).parents('.custom-head').next().slideToggle();
            $(this).parents('.custom-form-head').next().slideToggle();                                                   //added script!
        });

        //  height widget
        var $el_widget = $('.icon-widget');

        $el_widget.each(function(){
            if($(this).attr('data-percent-height')){
                $(this).height($(this).attr('data-percent-height'));
            }

            if($(this).attr('data-percent-width')){
                $(this).width($(this).attr('data-percent-width'));
            }

            if($(this).attr('data-color')){
                $(this).css( 'background' , '#' + ($(this).attr('data-color')));
            }
        });

        // filter link
        var $table_cell = $('.custom-table th');

        $($table_cell).on('click', '.filter-link', function(){
            if(!$(this).hasClass('filter-up') && !$(this).hasClass('filter-down')){
                $(this).addClass('filter-up');
            } else if($(this).hasClass('filter-up')){
                $(this).removeClass('filter-up');
                $(this).addClass('filter-down');
            } else {
                $(this).removeClass('filter-down');
            }

        });

        function fixTextTable(){
            // ellipsis fix

            $('.custom-table').each(function(){


                var $th = $(this).find('th');
                var $td = $(this).find('td');
                var numb_th = $th.length;
                var width_table = $(this).width();
                var ratio_th = width_table / numb_th;

                function cutText(arg){


                    if($(arg).find('span').hasClass('cut-text')){
                        $(arg).find('span').width(ratio_th - 30).addClass('cut-text');

                    } else if (ratio_th < $(arg).width()){
                        $(arg).find('span').width(ratio_th - 30).addClass('cut-text');
                    }
                }
                $th.each(function(){
                    cutText(this);

                    //delete
                    $(this).find('span').attr('title',$(this).find('span').text());
                });
                $td.each(function(){
                    cutText(this);

                    //delete
                    $(this).find('span').attr('title',$(this).find('span').text());
                });


            });
        }
        fixTextTable();

        $(window).resize(function(){
            fixTextTable();
        });

        // added scripts

        $(function() {
            $.datepicker.setDefaults($.datepicker.regional['']); // restore english localization

            $.datepicker.setDefaults({
                "dateFormat": 'M d, yy'
            });
            $( ".datepicker" ).datepicker();

            $('.timepicker').timepicker();
        });

        var generalWrapper = $('.content');

        if ($.cookie('isHideWidgets')) {
            var filterWidget = $('.filter-widget');
            filterWidget.removeClass('hidden-widget');
            filterWidget.attr('value', 'Show widgets').html('Show widgets');
            $('.right_half').css('width', '50%');
            filterWidget.closest('.right-column').css('width','auto');
            $.cookie('isHideWidgets', true, { path: '/' });
            generalWrapper.find('#collapse-block').toggle();
        }

        generalWrapper.on('click', '.filter-widget', function() {
            if ($(this).hasClass('hidden-widget')) {
                $(this).removeClass('hidden-widget');
                $(this).attr('value', 'Show widgets').html('Show widgets');
                $(this).closest('.right-column').css('width','auto');
                $('.right_half').css('width', '50%');
                $.cookie('isHideWidgets', true, { path: '/' });
            } else {
                $(this).addClass('hidden-widget');
                $(this).attr('value', 'Hide widgets').html('Hide widgets');
                $('.right_half').css('width', '24%');
                $(this).closest('.right-column').removeAttr('style');
                $.removeCookie('isHideWidgets', { path: '/' });
            }
                generalWrapper.find('#collapse-block').toggle();
        });

        $(document).on('change','.column-visibility',function(){
            var choseAction = $(this).val();
            var targetBlock = $(this).attr('data-target');
            console.log(targetBlock);
            if ( choseAction == 'hide') {
                $('#'+ targetBlock).addClass('widget-collapse');
                $(this).closest('.right-column').css('width','auto')
            } else {
                $('#'+ targetBlock).removeClass('widget-collapse');
                $(this).closest('.right-column').removeAttr('style');
            }
        });

    });
};
$(function() {
    setTimeout(function(){
        actionsInit(jQuery)
    }, 15);
});


