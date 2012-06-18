<?php return array
	(
		// groups
		'Ibidem' => array
			(
				// action slug
				'version-info' => array
					(
						'title' => 'Version Info',
						'context' => '\app\Backend_Ibidem',
						'view' => 'ibidem/backend/version-info'
					),
				'system-info' => array
					(
						'title' => 'System Information',
						'context' => '\app\Backend_Ibidem',
						'view' => 'ibidem/backend/system-information'
					),
			),
	
		'Access' => array
			(
				'user-list' => array
					(
						'title' => 'User List',
						'context' => '\app\Backend_Access',
						'view' => 'ibidem/backend/user-list'
					),
				'user-new' => array
					(
						'title' => 'Add User',
						'context' => '\app\Backend_Access',
						'view' => 'ibidem/backend/user-new'
					),
			),
	);