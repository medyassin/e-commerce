$(function() {

	'use strict';

	//Dashboard
	$('.toggle-info').click(function() {
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

		if($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-minus"></i>')
		} else {
			$(this).html('<i class="fa fa-plus"></i>')
		}
	})

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

	// Change login btn value
	$('input[type=submit]').click(function () {
		$(this).val('Please wait ...');
	})

	// Categorie View Option
	$('.cat h3').click(function (){
		$(this).next('.full-view').fadeToggle(200);
	})

	$('.full').click(function(){
		$('.full-view').fadeIn();
	})

	$('.classic').click(function(){
		$('.full-view').fadeOut();
	})

	// add .active-view class
	$('.ordering span').click(function() {
		$(this).addClass('active-order').siblings('span').removeClass('active-order');
	})


	// Show Comments Btn on hover

	$('.user-n').hover(function (){
		$(this).children('.btns').animate({
			display: 'block',
			left: '2px'
		}, 400);
	}, function () {
		$(this).children('.btns').animate({
			display: 'none',
			left: '-80px'
		}, 400);
	});


});