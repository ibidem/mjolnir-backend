/**
 * Implementation of the JSend specification.
 * 
 * See: http://labs.omniti.com/labs/jsend
 * 
 * @version 1.0
 */
;(function ($) {

	// enable stict mode
	'use strict';

	$.extend({

		'jsend': function (route, params, request) {
			var href = $.jsend.api(route, params), 
				process_response, error_report;
			
			error_report = function (message, actual_error) {
				// got development friendly error message?
				if (typeof actual_error !== 'undefined') {
					if (typeof mjolnir !== 'undefined' && mjolnir.development) {
						message = actual_error;
					}
				}
				
				var $error_modal = $('#mjolnir-jsend-error');
				if ($error_modal.length > 0) {
					$('.mjolnir-jsend-error-message', $error_modal).text(message);
					$error_modal.modal('show');
				}
				else { // no modal available
					alert('An unknown error has occured.');
				}
				
				return null;
			};
			
			process_response = function (response) {
				if (typeof response !== 'undefined' && typeof response.status !== 'undefined') {
					if (response.status == 'success') {
						if (typeof response.data !== 'undefined') {
							return response.data;
						}
						else { // data is undefined
							return error_report('An unknown error has occured.', 'Server responded with invalid data.');
						}
					}
					else if (response.status == 'error') {
						if (typeof response.message !== 'undefined') {
							return error_report(response.message);
						} 
						else { // no message provided
							return error_report('An unknown error has occured.', 'Recieved an error, but no error message was provided.');
						}
					}
					else { // unknown status
						return error_report('An unknown error has occured.', 'Server responded with an unknown status ['+response.status+'].');
					}
				} 
				else { // undefined data
					return error_report('An unknown error has occured.');
				}
			};
			
			var result = null; 
			
			$.ajax({
				// request
				url: href, 
				type: 'POST', 
				data: request,
				cache: false,
				async: false,
				timeout: 1000,
				
				// response
				dataType: 'json', 
				success: function (data) {
					result = process_response(data);
				},
				error: function (xhr) {
					try {
						result = process_response(JSON.parse(xhr.responseText));
					}
					catch (e) {
						result = error_report('An unknown error has occured.');
					}
				}
			});
			
			return result;
		}
		
	});	
	
	$.jsend.api = function (route, params) {
		var href = route;
		$.each(params, function (key, param) {
			href = href.replace(key, param);
		});

		return href;
	};
	
}(window.jQuery));