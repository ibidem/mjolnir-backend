/**
 * equation shadow
 *
 * Produce calculated fields in form (or form-like structure).
 *
 * @version 1.1
 * @license https://github.com/ibidem/ibidem/blob/master/LICENSE.md (BSD-2)
 */
;(function ($) {

	// enable stict mode
	"use strict";

	$.jshadow({

		'name': 'equation',

		'wrapper': '[data-equation-context]',

		'defaults': {
			'api-target': '[data-equation]'
		},

		'init': function (conf, $wrapper, self) {
			var $equations = $.jshadow.children(conf, $wrapper, self, conf['api-target']);

			$equations.each(function () {
				var $equation = $(this),
					formula = $equation.attr('data-equation'),
					context_variables = null;

				// detect all form field variables
				context_variables = formula.match(new RegExp('\\$[a-zA-Z0-9_]+', 'gi'));

				// create update function
				var update = function () {
					var field_value;
					// populate variables in context
					for (var i = 0; i < context_variables.length; ++i) {
						field_value = $('[name="'+context_variables[i].replace('$', '')+'"]', $wrapper).val();
						if ( ! field_value.match('[0-9\.]+')) {
							field_value = 0.0;
						}
						eval('var '+context_variables[i]+'='+field_value+';');
					}

					eval('var __return = '+formula+';');
					return __return;
				};

				$('input', $wrapper).on('input', function () {
					$equation.val(update());
				});
			});

			$('input', $wrapper).one().trigger('input');
		}

	});

}(window.jQuery));
