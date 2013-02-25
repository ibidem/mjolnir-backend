<?php require 'library/extras.php';

return array
	(
		'root' => 'root/',
		'sources' => 'src/',
		'mode' => 'complete',

	# Complete mode

		'complete-mapping' => array
			(
				'base'
			),

	# Targetted mode

		// common files used in targeted mapping
		'targeted-common' => [ ],

		// mapping targets to files; if a target is not mapped it won't have
		// any style associated
		'targeted-mapping' => array
			(
				// empty
			),

	); # config
