$(document).ready(function(){
    "use strict";

    var wrapper = $('.table-wrap');
    var batchWrapper = $('.batch-wrap');

    wrapper.on('click', '.btn-batch', function(){
        wrapper.find('[name=action]').remove();
        var batchValue = $(this).data('batch');
        batchWrapper.append('<input name="action" type="hidden" value="' + batchValue + '" />');
    });


    $('select#assignee').change(function(){
        var option = $('select#assignee :selected').val();
        if(option.length > 0){
            $('select#leadCampaign').attr('disabled', 'disabled');
            $('select#leadCampaign').attr('style', 'color:lightgrey');
        }else{
            $('select#leadCampaign').removeAttr('disabled');
            $('select#leadCampaign').attr('style', 'color:black');
        }
    });

    $('select#leadCampaign').change(function(){
        var option = $('select#leadCampaign :selected').val();
        if(option.length > 0){
            $('select#assignee').attr('disabled', 'disabled');
            $('select#assignee').attr('style', 'color:lightgrey');
        }else{
            $('select#assignee').removeAttr('disabled');
            $('select#assignee').attr('style', 'color:black');
        }
    });

    $('form').on('submit', function(e){

        e.preventDefault();
        var form = $(this);
        var button = form.find('.btn-list-reassign');
        var value = form.find('[name="action"]').val();
        if (value == 'reassign') {
            var data = {'assignee': form.find('select[name="assignee"]').val(), 'campaign': form.find('select[name="leadCampaign"]').val()};
            var ajaxUrl = $(button).data('ajax-url');
            var leads = [];
            var checkedItems = form.find('input[name="idx[]"]:checked');
            checkedItems.each(function(){
               // console.log($(this).val());
                leads[leads.length] = $(this).val();
            });
           // var leadsArray = {'leads': leads};
            data['leads'] = leads;

            console.log(data);
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
        if (value == 'delete' || value == 'delete_permanently') {
            var deleteData = {};
            var deleteForm = $(this);
            var deleteButton = deleteForm.find('.btn-list-delete');
            var deleteAjaxUrl = $(deleteButton).data('ajax-url');
            var deleteLeads = [];
            var deleteCheckedItems = deleteForm.find('input[name="idx[]"]:checked');
            deleteCheckedItems.each(function(){
                deleteLeads[deleteLeads.length] = $(this).val();
            });
            deleteData['delete_leads'] = deleteLeads;
            deleteData['permanently'] = value == 'delete_permanently' ? true : false;

            $.ajax(deleteAjaxUrl, {
                'data': deleteData,
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
        if (value == 'reestablish') {
            var reestablishData = {};
            var reestablishForm = $(this);
            var reestablishButton = reestablishForm.find('.btn-list-reestablish');
            var reestablishAjaxUrl = $(reestablishButton).data('ajax-url');
            var reestablishLeads = [];
            var reestablishCheckedItems = reestablishForm.find('input[name="idx[]"]:checked');
            reestablishCheckedItems.each(function(){
                reestablishLeads[reestablishLeads.length] = $(this).val();
            });
            reestablishData['reestablish_leads'] = reestablishLeads;

            $.ajax(reestablishAjaxUrl, {
                'data': reestablishData,
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
    });
});
