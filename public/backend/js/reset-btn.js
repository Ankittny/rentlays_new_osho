"use strict"
$(document).on('click', '#reset_btn', function() {
		
    $('#status').val('');
    $('#space_type').val('');
    $('#reviewer').val('');
    $('#property').val('');
    $('#select2-customer-container').text('All');
    $('#select2-customer-container').attr('title','All');
    $('#select2-property-container').text('All');
    $('#select2-property-container').attr('title','All');
    $('.pull-left').html('');
    $('.pull-left').html('<i class="fa fa-calendar"></i>   Pick a date range');
})