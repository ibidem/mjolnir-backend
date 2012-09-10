<?php return array
	(
		'base_classes' => array
			(
				'#^Backend_.*$#' => '\app\Backend_Collection',
			),
	
		'autofills' => array
			(
				'#^Backend_.*$#' => \app\View::instance('mjolnir/backend/autofills/Backend')->render(),
			),
	);
