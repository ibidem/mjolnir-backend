<?php require 'library/extras.php';

	// definitions

	$unsorted = array
		(
			'+vendor/jquery/jquery',
			'unsorted',
		);
	
	$bootstrap = array
		(
			'+vendor/sass-bootstrap/bootstrap-tab',
			'+vendor/sass-bootstrap/bootstrap-tooltip',
			'+vendor/sass-bootstrap/bootstrap-affix',
			'+vendor/sass-bootstrap/bootstrap-alert',
			'+vendor/sass-bootstrap/bootstrap-button',
			'+vendor/sass-bootstrap/bootstrap-carousel',
			'+vendor/sass-bootstrap/bootstrap-collapse',
			'+vendor/sass-bootstrap/bootstrap-dropdown',
			'+vendor/sass-bootstrap/bootstrap-modal',
			'+vendor/sass-bootstrap/bootstrap-popover',
			'+vendor/sass-bootstrap/bootstrap-scrollspy',
			'+vendor/sass-bootstrap/bootstrap-transition',
			'+vendor/sass-bootstrap/bootstrap-typeahead',
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
