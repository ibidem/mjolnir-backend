/**
 * Maintains a pool of ajax requests allowing you to cancel all at once.
 */
;(function () {

	$.xhrPool = [];
	$.xhrPool.abortAll = function() {
		$(this).each(function(idx, jqXHR) {
			jqXHR.abort();
		});
		$.xhrPool.length = 0
	};

	$.ajaxSetup({
		beforeSend: function(jqXHR) {
			$.xhrPool.push(jqXHR);
		},
		complete: function(jqXHR) {
			var index = $.xhrPool.indexOf(jqXHR);
			if (index > -1) {
				$.xhrPool.splice(index, 1);
			}
		}
	});

} (window.jQuery));