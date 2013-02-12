<?php return array
	(
		'mjolnir:backend.route' => array
			(
				'matcher' => \app\URLRoute::instance()
					->urlpattern
					(
						'backend(/<slug>(/<task>))',
						[
							'task' => '[a-zA-Z0-9\-]+',
							'slug' => '[a-zA-Z0-9\-]+'
						]
					),
				'enabled' => true,
			// MVC
				'controller' => '\app\Controller_Backend',
				'action' => 'action_route',
			),
	);