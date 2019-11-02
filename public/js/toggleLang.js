


$(function() {

	'use strict';

	
	let hasErrors = {};
	let flag = true;
	let defaultTab = $('#language-list li[href=#tab-en]')
	let tabHistory = [null, defaultTab];

	// check has-errors
	$('.tab-content').find('.tab-pane').each(function(i, e) 
	{
		let errors = 0;

		$(e).find('.form-group').each(function(i, el) 
		{
			if ($(el).hasClass('has-error')) errors++;
		});

		if (errors > 0) 
		{
			hasErrors['#'+e.id] = errors;
		}
	});
	

	// check beforehand
	$('#language-list').find('input').each(function(i, e) 
	{
		let label = $(e).closest('li');
		let target = label.attr('href');

		if (hasErrors[target] !== undefined) 
		{
			label.find('span.label-danger').show().html(hasErrors[target]);
			if (flag) 
			{
				label.tab('show').on('shown.bs.tab', function() 
				{
					focusFirstErrorInput($(target));
				});
				flag = false;
			}
		}

		if (target !== '#tab-en') 
		{
			checkToggle($(e));
		}
	});


	
	$('#language-list li').on('click', function(e) 
	{
		let isActive = $(this).hasClass('active');
		let input = $(this).find('input');
		let checked = input.prop('checked');

		console.log(isActive, checked);

		if (!isActive)
		{
			if (!checked || !e.target.classList.contains('checker'))
			{
				$(this).tab('show').on('shown.bs.tab', function() 
				{
					focusFirstInput($($(this).attr('href')));
				});
				// tabHistory.shift();
				// tabHistory.push($(this));
			}
		} 
		else if (isActive && checked)
		{
			// let lastTab = tabHistory[+!isActive];
			// console.log(lastTab.hasClass('checked'));
			// if (!lastTab.hasClass('checked')) lastTab = defaultTab;
			// if (isActive) lastTab = defaultTab;

			defaultTab.tab('show').on('shown.bs.tab', function() 
			{
				focusFirstInput($(defaultTab.attr('href')));
			});				
		}
		console.log(input.attr('fixed') ? 'true' : 'false');
		if (isActive || e.target.classList.contains('checker')) input.prop('checked', !checked);
		if (input.attr('fixed')) input.prop('checked', true);
		// else if () input.prop('checked', !checked);

		checkToggle(input);
	});

	$('#language-list input').on('change', function(e) 
	{
		let label = $(this).closest('li');
		let checked = $(this).prop('checked');

		checkToggle($(this));
	});

	function checkToggle(e) 
	{
		let label = e.closest('li');
		let target = label.attr('href');
		let checked = e.prop('checked');

		if (checked) 
		{
			label.addClass('checked');
		}
		else 
		{
			label.removeClass('checked');
		}

		$(target).find('input, textarea').each(function(i, e) 
		{
			if (checked) 
			{
				$(e).attr('name', $(e).data('name'));
			}
			else 
			{
				$(e).data('name', $(e).attr('name'));
				$(e).removeAttr('name');
			}
			$(e).prop('disabled', !checked);
		});
	}

	function focusFirstInput(target) 
	{
		target.find('input').filter(':visible:first').focus();
	}

	function focusFirstErrorInput(target) 
	{
		target.find('.has-error').first().find('input, textarea').first().focus().select();
	}





	// function toggleLabel(label) 
	// {
	// 	label.toggleClass('checked');
	// }

	// function toggleForm(target, checked) 
	// {
	// 	$(target).find('input, textarea').each(function(i, e) {

	// 		$(e).attr('name', checked ? $(e).data('name') : '');
	// 		$(e).prop('disabled', !checked);
	// 	});
	// }

	// function toggleActive(label) {

	// 	let target = $(label).find('input').data('target');
	// 	let checked = $(label).find('input').prop('checked');

	// 	$(label).toggleClass('active');
	// 	$(label).find('span.fa').toggleClass('hidden');

	// 	$(target).find('input, textarea').each(function(i, e) {

	// 		$(e).attr('name', checked ? $(e).data('name') : '');
	// 		$(e).prop('disabled', !checked);
	// 	});
	// }

	// function activate(label) {

	// 	let target = $(label).find('input').data('target');

	// 	if (!$(label).hasClass('active')) $(label).addClass('active');

	// 	$(target).find('input, textarea').each(function(i, e) {

	// 		$(e).attr('name', $(e).data('name'));
	// 		$(e).prop('disabled', false);
	// 	});
	// }

// 	var flag = true;
// 	// add number of errors next to tab name
// 	$('.link-tab').each(function (i, e) {

// 		let href = $(this).attr('href');
// 		let errors = $(href).find('.help-block');

// 		if (errors.length > 0) {

// 			let label = $(this).find('.label-danger');
// 			label.removeClass('hidden');
// 			label.html(errors.length);

// 			if (flag) {
// 				flag = !flag;
// 				toggleTo(this);
// 			}
// 		}

// 	});

// 	function toggleTo(e) {
// 		console.log(e);

// 		$('a[href=#en]').parent('li').removeClass('active');
// 		$(e).parent('li').addClass('active');

// 		let href = $($(e).attr('href'));

// 		$('#en').removeClass('in active');
// 		$(href).addClass('in active');

// 	}

// 	$('input.toggleLang').each(function(i, e) {

// 		if ($(e).prop('checked')) {

// 			let target = $(e).next('a').attr('href');

// 			if ($(e).prop('checked')) {
// 				$(target).find('input, textarea').each(function(i, e) {
// 					$(e).attr('name', $(e).data('name'));
// 					$(e).prop('disabled', false);
// 				});
// 			} else {
// 				$(target).find('input, textarea').each(function(i, e) {
// 					$(e).removeAttr('name');
// 					$(e).prop('disabled', true);
// 				});		
// 			}

// 		}

// 	});

// 	$('input.toggleLang').on('change', function(e) {

// 		let target = $(this).next('a').attr('href');

// 		if ($(this).prop('checked')) {
// 			$(target).find('input, textarea').each(function(i, e) {
// 				$(e).attr('name', $(e).data('name'));
// 				$(e).prop('disabled', false);
// 			});
// 		} else {
// 			$(target).find('input, textarea').each(function(i, e) {
// 				$(e).removeAttr('name');
// 				$(e).prop('disabled', true);
// 			});		
// 		}

// 	});




});


