$(function() {

	'use strict';


	// Trigger SelectBoxIt Plugin

	$("select").selectBoxIt({

		autoWidth: false,

	});

	// Switch Between Login & Signup

	$('.login-page h1 span').click(function () {

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);

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

	$('.live').keyup(function() {
		$($(this).data('class')).text($(this).val());
	})

	$('select').on('change', function() {
		var s = parseInt($(this).val());

		if(s === 1) {
			status = 'New';
		} else if(s === 2) {
			status = 'Like New';
		} else if(s === 3) {
			status = 'Used';
		} else {
			status = 'Very Old';
		}

		$($(this).data('class')).text(status);
	})

});