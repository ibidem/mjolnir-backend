<?php namespace mjolnir\backend;

/**
 * @package    mjolnir
 * @category   Context
 * @author     Ibidem
 * @copyright  (c) 2012, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Context_Backend extends \app\Instantiatable
{
	/**
	 * @var \mjolnir\types\View
	 */
	private $view;

	/**
	 * @var string or null
	 */
	private $pageslug;

	/**
	 * ...
	 */
	function set_view(\mjolnir\types\View $view)
	{
		$this->view = $view;
	}

	/**
	 * @return string
	 */
	function view()
	{
		return $this->view;
	}

	/**
	 * @return array
	 */
	function dashboard()
	{
		$backend_config = \app\CFS::config('mjolnir/backend');

		$result = [];
		foreach ($backend_config as $key => $tools)
		{
			$resultset = array
				(
					'slug' => \str_replace(' ', '-', \strtolower($key)),
					'title' => $key,
					'tools' => [],
				);

			foreach ($tools as $slug => $tool)
			{
				if ( ! isset($tool['hidden']) || ! $tool['hidden'])
				{
					if (\app\Access::can('mjolnir:backend.route', null, $slug))
					{
						$resultset['tools'][] = array
							(
								'title' => $tool['title'],
								'icon' => isset($tool['icon']) ? $tool['icon'] : null,
								'url' => \app\URL::href('mjolnir:backend.route', ['slug' => $slug]),
								'slug' => $slug
							);
					}
				}
			}

			if ( ! empty($resultset['tools']))
			{
				$result[] = $resultset;
			}
		}

		if (empty($result))
		{
			throw new \app\Exception_NotAllowed('You do not have sufficient privilages to access this page.');
		}

		return $result;
	}

	/**
	 * @return static $this
	 */
	function set_pageslug($pageslug)
	{
		$this->pageslug = $pageslug;

		return $this;
	}

	/**
	 * @return string
	 */
	function pageslug()
	{
		return $this->pageslug;
	}

} # class
