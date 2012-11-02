<?php return array
	(	
		// mapping targets to files
		'targets' => array
			(
				'wrapper' => array
					(
						'components/base',
						'wrapper' 
					),
				'dashboard' => array
					(
						'components/base',
						'dashboard'
					),
			
			//// Exceptions ////////////////////////////////////////////////////
			
				'exception-NotFound' => array
					(
						'components/errors/base',
						'errors/not-found' 
					),
				'exception-NotAllowed' => array
					(
						'components/errors/base',
						'errors/not-allowed' 
					),
				'exception-NotApplicable' => array
					(
						'components/errors/base',
						'errors/not-applicable' 
					),
				'exception-Unknown' => array
					(
						'components/errors/base',
						'errors/unknown' 
					),			
			),
	);

