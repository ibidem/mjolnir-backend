<?php return array
	(
		'version' => '1.0', # used in cache busting; update as necesary

		// set the style.root to '' (empty string) when writing (entirely) just
		// plain old css files; and not compiling sass scripts, etc
		'style.root' => 'root'.DIRECTORY_SEPARATOR,

		// common files
		'common' => array
			(
				'lib/twitter/bootstrap', 
				'lib/twitter/corrections', 
				'lib/ancillary-1.0',
				'lib/font-awesome',
				'unsorted'
			),
	
		// mapping targets to files
		'targets' => array
			(
				'backend/dashboard' => [ 'dashboard' ],
				'backend/wrapper' => [ 'dashboard' ],
			),
	);

