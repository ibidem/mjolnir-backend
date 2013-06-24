<?php return array
	(
		'version' => '1.0.0',

		'loaders' => array # null = default configuration
			(
				'style' => [ 'default.style' => 'system-panels' ],
				'javascript' => null,
			),

		// target-to-file mapping
		'mapping' => array
			(
				'wrapper' => array
					(
						'foundation/base',
						'wrapper'
					),
				'dashboard' => array
					(
						'foundation/base',
						'dashboard'
					),

			//// Exceptions ////////////////////////////////////////////////////

				'exception-NotFound' => array
					(
						'foundation/error',
						'errors/not-found'
					),
				'exception-NotAllowed' => array
					(
						'foundation/error',
						'errors/not-allowed'
					),
				'exception-NotApplicable' => array
					(
						'foundation/error',
						'errors/not-applicable'
					),
				'exception-Unknown' => array
					(
						'foundation/error',
						'errors/unknown'
					),
			),

	); # theme
