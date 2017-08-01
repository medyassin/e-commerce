$(function() {

	'use strict';


	// Trigger SelectBoxIt Plugin

	$("select").selectBoxIt({

		autoWidth: false,

	});



	// Hide Placeholder on form focus
	$('[placeholder]').focus(function() {
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	}).blur(function() {
		$(this).attr('placeholder', $(this).attr('data-text'));
	});

	// Add Asterisk On required  fields
	$('input').each(function () {
		if ($(this).attr('required') === 'required') {
			$(this).after('<span class="asterisk">*</span>');
		}
	});

	// Convert Password filed to Text filed on hover 
	$('.show-pass').hover(function (){
		$('.password').attr('type', 'text');
	}, function () {
		$('.password').attr('type', 'password');
	});

	// Confirm Delete Button

	$('.confirm').click(function () {
		return confirm('Are you sure');
	});

	// Category hover show btn

	$('.item-box').hover(function (){

		$(this).children('button').show(300);

	}, function () {
		$(this).children('button').hide(300);
	});

	// add menu class;



});