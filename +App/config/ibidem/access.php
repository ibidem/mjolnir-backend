<?php return array
	(
		'whitelist' => array
			(
				\app\A12n::guest() => array
					(
						\app\Protocol::instance()
							->relays(['\ibidem\backend']),
					),
			)
	);
