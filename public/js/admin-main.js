

$(function(){

	'use strict';

	// replace submit button's text with "loading..."
	$('button[type=submit]').on('click', function(e) {

		$(this).html('<span class="fa fa-spinner fa-spin"></span> Loading..').prop('disabled', true);
		this.form.submit();
	});

	// toggle show/hide next div element
	$('.toggle-next-element').on('click', function(e) {
		console.log('test');
		e.preventDefault();

		let target = $(this).next();

		target.toggle();
	});

	// submit the next form in the dom tree 
	$('.submit-next-form').on('click', function(e) {
		e.preventDefault();
		
		let target = $(this).next('form');
		let danger = $(this).hasClass('btn-danger');

		if (danger) 
		{
			if (!confirm('Are you sure you want to delete all entries associated with this item ?')) return false;
		}

		target.submit();
	});

	// submit form on input change
	$('.submit-on-change').on('change', function(e) {

		this.form.submit();
	});

	// focus on the first error input in the active tab
	$('.form-error-focus').each(function(i, e) {

		let hasError = $(this).find('.has-error').first();

		hasError.find('input, textarea').first().focus().select();
	});

	// remove error class after changing input value
	$('form .has-error').find('input, textarea').on('change', function(e) {

		$(this).closest('.form-group').removeClass('has-error');
	});
});