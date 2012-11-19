;(function ($, undefined) {
	
	$(function () {
		$('.has-ui-datepicker').datepicker({ 
			showAnim   : 'slide',
			dateFormat : 'yy-mm-dd'
		});
		$('.has-ui-datetimepicker').datetimepicker({ 
			showAnim   : 'slide',
			timeFormat: 'HH:mm',
			dateFormat : 'yy-mm-dd'
		});
	});
	
}(window.jQuery));