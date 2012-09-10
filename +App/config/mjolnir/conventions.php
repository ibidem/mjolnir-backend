<?php return array
	(
		'base_classes' => array
			(
				'#^Backend_.*$#' => '\app\Backend_Collection',
			),
	
		'autofills' => array
			(
				'#^Backend_.*$#' => \app\View::instance('ibidem/backend/autofills/Backend')->render(),
			),
	);
