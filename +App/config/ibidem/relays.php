<?php return array
	(
		'\ibidem\backend' => array
			(
				'route' => \app\Route_Pattern::instance()
					->standard('backend(/<slug>(/<task>))', ['task' => '[a-zA-Z0-9\-]+', 'slug' => '[a-zA-Z0-9\-]+']),
				'enabled' => true,
				'controller' => '\app\Controller_Backend',
				'action' => 'action_route',
			),
	);