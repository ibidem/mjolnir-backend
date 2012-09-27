<?php namespace app; return array
/////// Access Protocol Configuration //////////////////////////////////////////
(
	'whitelist' => array # allow
		(
			'+admin' => array
				(
					Allow::relays
						(
							'\mjolnir\backend'
						)
						->all_parameters(),
				),
		),
);
