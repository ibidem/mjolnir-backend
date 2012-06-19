<?php namespace ibidem\backend;

/**
 * @package    ibidem
 * @category   Context
 * @author     Ibidem
 * @copyright  (c) 2012, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Context_Backend extends \app\Instantiatable
{
	/**
	 * @var \ibidem\types\View 
	 */
	private $view;
	
	/**
	 * @param \ibidem\types\View view
	 */
	function set_view(\ibidem\types\View $view)
	{
		$this->view = $view;
	}
	
	function view()
	{
		return $this->view;
	}
	
	function dashboard()
	{
		$backend_config = \app\CFS::config('ibidem/backend');
		
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
				if (\app\Access::can('\ibidem\backend', null, $slug))
				{
					$resultset['tools'][] = array
						(
							'title' => $tool['title'],
							'url' => \app\Relay::route('\ibidem\backend')->url(['slug' => $slug]),
							'slug' => $slug
						);
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

} # class
