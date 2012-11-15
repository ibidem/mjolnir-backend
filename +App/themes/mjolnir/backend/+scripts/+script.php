<?php namespace app;

	// error reporting may duplicate the definition
	if ( ! \function_exists('\app\index'))
	{
		// we use an in-file function so ruby can process the file
		function index()
		{
			$args = \func_get_args();

			$result = [];
			foreach ($args as $array)
			{
				foreach ($array as $item)
				{
					if ( ! \in_array($item, $result))
					{
						$result[] = $item;
					}
				}
			}

			return $result;
		}
	}
	
	# common to all pages with javascript
	$jquery_libraries = array
		(			
			// overwrites
			'+lib/jquery/jquery.xhrPool',
		
			// jquery.ui libraries
			'+lib/jquery/ui/jquery.ui.core',
		
			'+lib/jquery/ui/jquery.ui.effect',
			'+lib/jquery/ui/jquery.ui.widget',
		
			'+lib/jquery/ui/jquery.ui.mouse',
			'+lib/jquery/ui/jquery.ui.position',
			'+lib/jquery/ui/jquery.ui.selectable',
			'+lib/jquery/ui/jquery.ui.draggable',
			'+lib/jquery/ui/jquery.ui.droppable',
			'+lib/jquery/ui/jquery.ui.resizable',
			'+lib/jquery/ui/jquery.ui.sortable',
			
		
			'+lib/jquery/ui/jquery.ui.effect-blind',
			'+lib/jquery/ui/jquery.ui.effect-bounce',
			'+lib/jquery/ui/jquery.ui.effect-clip',
			'+lib/jquery/ui/jquery.ui.effect-drop',
			'+lib/jquery/ui/jquery.ui.effect-explode',
			'+lib/jquery/ui/jquery.ui.effect-fade',
			'+lib/jquery/ui/jquery.ui.effect-fold',
			'+lib/jquery/ui/jquery.ui.effect-highlight',
			'+lib/jquery/ui/jquery.ui.effect-pulsate',
			'+lib/jquery/ui/jquery.ui.effect-scale',
			'+lib/jquery/ui/jquery.ui.effect-scale',
			'+lib/jquery/ui/jquery.ui.effect-shake',
			'+lib/jquery/ui/jquery.ui.effect-slide',
			'+lib/jquery/ui/jquery.ui.effect-transfer',
			
			'+lib/jquery/ui/jquery.ui.accordion',
			'+lib/jquery/ui/jquery.ui.autocomplete',
			'+lib/jquery/ui/jquery.ui.button',
			'+lib/jquery/ui/jquery.ui.datepicker',
			'+lib/jquery/ui/jquery.ui.dialog',
			'+lib/jquery/ui/jquery.ui.menu',
			'+lib/jquery/ui/jquery.ui.progressbar',
			'+lib/jquery/ui/jquery.ui.slider',
			'+lib/jquery/ui/jquery.ui.spinner',
			'+lib/jquery/ui/jquery.ui.tabs',
			'+lib/jquery/ui/jquery.ui.tooltip',
		
			// internationalization
			//'+lib/jquery/ui/i18n/jquery-ui-i18n',
		
			// chosen
			'+lib/jquery/chosen/jquery.chosen',
			'+lib/jquery/chosen/init',
		
			// plugins
			'+lib/jquery/jquery.hoverIntent',
			'+lib/jquery/jquery.showLoading',
			'+lib/jquery/jquery.timepicker-addon',
		
			// auto-binding for jquery ui
			'+lib/jquery/main',
		
		);
	
	$error_reporting = array
		(
			'+lib/stacktrace',
			'+lib/onerror',
		);
	
	$mjolnir_libraries = array
		(
			'+lib/mjolnir/jshadow-1.1',
			'+lib/mjolnir/jsend-1.0',
			
			// shadows
			'+lib/mjolnir/shadows/backselect',
			'+lib/mjolnir/shadows/equation',
			'+lib/mjolnir/shadows/saveme',
			'+lib/mjolnir/shadows/tabs',
			'+lib/mjolnir/shadows/ui',
			'+lib/mjolnir/shadows/xlinker',
			'+lib/mjolnir/shadows/xload',
			'+lib/mjolnir/shadows/xref',
			'+lib/mjolnir/shadows/xselect',
			'+lib/mjolnir/shadows/xsync',
		);
	
	$twitter_bootstrap = array
		(
			'+lib/twitter/bootstrap-tooltip',
			'+lib/twitter/bootstrap-popover',
			
			'+lib/twitter/bootstrap-affix',
			'+lib/twitter/bootstrap-alert',
			'+lib/twitter/bootstrap-button',
			'+lib/twitter/bootstrap-carousel',
			'+lib/twitter/bootstrap-collapse',
			'+lib/twitter/bootstrap-dropdown',
			'+lib/twitter/bootstrap-modal',
			'+lib/twitter/bootstrap-scrollspy',
			'+lib/twitter/bootstrap-tab',
			'+lib/twitter/bootstrap-transition',
			'+lib/twitter/bootstrap-typeahead',
		);

return array
	(
		'version' => '1.3', # used in cache busting; update as necesary

		// set the script.root to '' (empty string) when writing (entirely) just
		// plain old js files; and not compiling coffee scripts, etc
		'script.root' => 'src'.DIRECTORY_SEPARATOR,
	
		// will be included in all explicity targets; if a target needs to be
		// script free then simply ommit it in the targets declaration bellow
		'common' => [],
	
		// enables closure compiler
		'closure-mode' => true,
	
		// enables single [complete-script] for all pages;
		'complete-mode' => true,

		// script to use in complete-mode
		'complete-script' => index
			(
				$jquery_libraries,
				$error_reporting,
				$mjolnir_libraries,
				$twitter_bootstrap
			),

		// mapping targets to files
		'targets' => array
			(
				// no targetted scripting
			),
	);

