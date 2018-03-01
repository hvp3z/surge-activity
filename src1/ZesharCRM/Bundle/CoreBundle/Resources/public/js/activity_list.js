$(document).ready(function(){
    "use strict";

    var wrapper = $('.table-wrap');
    var batchWrapper = $('.batch-wrap');

    wrapper.on('click', '.btn-batch', function(){
        wrapper.find('[name=action]').remove();
        var batchValue = $(this).data('batch');
        batchWrapper.append('<input name="action" type="hidden" value="' + batchValue + '" />');
    });

    $('form').on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        var button = form.find('.btn-list-reassign');
        var value = form.find('[name="action"]').val();
        if (value == 'reassign') {
            var data = {'assignee': form.find('select[name="assignee"]').val()};
            var ajaxUrl = $(button).data('ajax-url');
            var activities = [];
            var checkedItems = form.find('input[name="idx[]"]:checked');
            checkedItems.each(function(){
               // console.log($(this).val());
                activities[activities.length] = $(this).val();
            });
           // var leadsArray = {'leads': leads};
            data['activities'] = activities;

            sendAjax(ajaxUrl,data);
        }
        if (value == 'delete') {
            var data = {};
            var form = $(this);
            var button = form.find('.btn-list-delete');
            var ajaxUrl = $(button).data('ajax-url');
            var activities = [];
            var checkedItems = form.find('input[name="idx[]"]:checked');
            checkedItems.each(function(){
                activities[activities.length] = $(this).val();
            });
            data['activities'] = activities;

            sendAjax(ajaxUrl, data);
        }
    });
});

function sendAjax(ajaxUrl, data){
    $.ajax(ajaxUrl, {
        'data': data,
        'type': 'POST',
        'success': function(response) {
            console.log('ajax success');
            window.location.reload();
        },
        'error': function() {
            console.log('ajax error');
            alert('A error occured while AJAX request.');
        }
    });
}
