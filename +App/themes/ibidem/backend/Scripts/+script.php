<?php return array
	(
		'version' => '1.0', # used in cache busting; update as necesary

		// set the script.root to '' (empty string) when writing (entirely) just
		// plain old js files; and not compiling coffee scripts, etc
		'script.root' => '',
	
		// will be included in all explicity targets; if a target needs to be
		// script free then simply ommit it in the targets declaration bellow
		'common' => array
			(
				'lib/plugins/jquery-1.7.2',
				'lib/twitter/bootstrap'
			),

		// mapping targets to files
		'targets' => array
			(
				// the following empty rules are simply here to tell the theme
				// to load javascript for the two targets the backend module
				// makes use of
				'backend/dashboard' => [
					// loads common
				],
				'backend/wrapper' => [ 
					// loads common
				],
			),
	);

