<?php return array
	(
		'version' => '1.0', # used in cache busting; update as necesary

		// set the style.root to '' (empty string) when writing (entirely) just
		// plain old css files; and not compiling sass scripts, etc
		'style.root' => 'root'.DIRECTORY_SEPARATOR,

		// common files
		'common' => array
			(
				// twitter bootstrap
				'+lib/twitter-bootstrap/bootstrap',
				'+lib/twitter-bootstrap/extra',
			
				// jquery ui
				'+lib/jquery/ui/jquery.ui.accordion',
				'+lib/jquery/ui/jquery.ui.autocomplete',
				'+lib/jquery/ui/jquery.ui.button',
				'+lib/jquery/ui/jquery.ui.core',
				'+lib/jquery/ui/jquery.ui.datepicker',
				'+lib/jquery/ui/jquery.ui.dialog',
				'+lib/jquery/ui/jquery.ui.progressbar',
				'+lib/jquery/ui/jquery.ui.resizable',
				'+lib/jquery/ui/jquery.ui.selectable',
				'+lib/jquery/ui/jquery.ui.slider',
				'+lib/jquery/ui/jquery.ui.tabs',
				'+lib/jquery/ui/jquery.ui.theme',
			
				// jquery plugins
				'+lib/jquery/jquery.chosen',
				'+lib/jquery/jquery.timepicker-addon',

				// mjolnir
				'+lib/mjolnir/base',
			
				'unsorted',
			),
	
		// mapping targets to files
		'targets' => array
			(
				'dashboard' => [ ],
				'wrapper'   => [ ],
			),
	);

