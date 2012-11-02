//
// Reports javascript errors to the server for logging purposes.
//
;(function ($) {
	
	window.onerror = function(message, url, line) {
		var trace = printStackTrace();
		$.post(mjolnir.error_log, {
			'message': message, 
			'location': window.location.pathname + window.location.search + window.location.hash, 
			'url': url, 
			'line': line, 
			'trace': trace.join("\n")
		});
		
		return false;
	};
	
}(window.jQuery));