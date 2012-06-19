;(function ($) {
	
	'use strict';
	
	var ns = 'dashboard-hover';
	
	$(document).ready(function () {
		
		// animation duration
		var duration = 1000;
		
		// store original values
		var width = $('.js-dashboard').width();
		
		// leave a small margin for activation
		width -= 10;
		
		var States = {
			hidden: 0,
			visible: 1
		}
		
		var disabled = false;
		
		var state = States.hidden;
		
		function slideOut() {
			$('.js-dashboard').animate({
				'left': '-='+width
			}, duration);
			
			$('#page').animate({
				'padding-left': '-='+width
			}, duration);
		}
		
		function slideIn() {
			$('.js-dashboard').animate({
				'left': '+='+width
			}, duration);
			
			$('#page').animate({
				'padding-left': '+='+width
			}, duration);
		}
		
		$('.js-dashboard').on('mouseover.'+ns, function (event) {
			if (state == States.hidden && ! disabled)
			{
				disabled = true;
				slideIn();
				state = States.visible;
				setTimeout(function () { disabled = false }, duration+100);
			}
		});
		
		$('#page').on('mouseover.'+ns, function (event) {
			if (state == States.visible && ! disabled)
			{
				disabled = true;
				slideOut();
				state = States.hidden;
				setTimeout(function () { disabled = false }, duration+100);
			}
		});
		
		// $('#page').trigger('mouseover.'+ns);
		
	});
	
}(jQuery));