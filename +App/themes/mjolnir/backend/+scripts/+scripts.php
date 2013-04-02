<?php require 'library/extras.php';

	// definitions

	$unsorted = array
		(
			'unsorted',
		);
	
	$bootstrap = array
		(
			'+vendor/bootstrap-sass/js/bootstrap-tooltip',
		
			'+vendor/bootstrap-sass/js/bootstrap-affix',
			'+vendor/bootstrap-sass/js/bootstrap-alert',
			'+vendor/bootstrap-sass/js/bootstrap-button',
			'+vendor/bootstrap-sass/js/bootstrap-carousel',
			'+vendor/bootstrap-sass/js/bootstrap-collapse',
			'+vendor/bootstrap-sass/js/bootstrap-dropdown',
			'+vendor/bootstrap-sass/js/bootstrap-modal',
			'+vendor/bootstrap-sass/js/bootstrap-popover',
			'+vendor/bootstrap-sass/js/bootstrap-scrollspy',
			'+vendor/bootstrap-sass/js/bootstrap-tab',
			'+vendor/bootstrap-sass/js/bootstrap-transition',
			'+vendor/bootstrap-sass/js/bootstrap-typeahead',
		);
	
	$jshadow = array
		(
			'+vendor/mjolnir-shadow/jshadow',
			'+vendor/mjolnir-shadow/shadows/backselect',
			'+vendor/mjolnir-shadow/shadows/equation',
			'+vendor/mjolnir-shadow/shadows/innerform',
			'+vendor/mjolnir-shadow/shadows/saveme',
//			'+vendor/mjolnir-shadow/shadows/tabs',
			'+vendor/mjolnir-shadow/shadows/ui',
			'+vendor/mjolnir-shadow/shadows/xlinker',
			'+vendor/mjolnir-shadow/shadows/xload',
			'+vendor/mjolnir-shadow/shadows/xref',
			'+vendor/mjolnir-shadow/shadows/xselect',
			'+vendor/mjolnir-shadow/shadows/xsync',
			'+vendor/mjolnir-shadow/shadows/xtoggle',
		);
	
return array
	(
		'root' => 'root/',
		'sources' => 'src/',
		'mode' => 'complete',
	
	# complete mode

		'complete-mapping' => \app\index
			(
				$unsorted,
				$bootstrap,
				$jshadow
			),
		
	# targeted mode
	
		'targeted-common' => [ ],
		'targeted-mapping' => [ ],

	); # config
