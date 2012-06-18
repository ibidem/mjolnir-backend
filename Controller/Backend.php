<?php namespace ibidem\backend;

/**
 * @package    ibidem
 * @category   Controller
 * @author     Ibidem
 * @copyright  (c) 2012, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_Backend extends \app\Controller_HTTP
{
	/**
	 * @var \app\View 
	 */
	private $page;
	
	/**
	 * @return \app\View page
	 */
	function page()
	{
		return $this->page;
	}
	
	function action_index()
	{
		$this->page = \app\View::instance('ibidem/backend/dashboard')
			->variable('context', $this)
			->variable('control', $this);
		
		$this->body
			(
				\app\ThemeView::instance()
					->theme('ibidem/backend')
					->target('backend/dashboard')
					->control($this)
					->context($this)
					->render()
			);
	}
	
	function view($config)
	{
		$this->body
			(
				\app\ThemeView::instance()
					->theme('ibidem/backend')
					->variable
						(
							'page', 
							\app\View::instance($config['view'])
								->variable('context', $config['context']::instance())
								->variable('control', $this)
						)
			);
	}
	
	function action_route()
	{
		$slug = $this->params->get('slug', null);
		if ($slug === null)
		{
			$this->action_index();
			return;
		}
		else # slug is present
		{
			// validate
			$backend_config = \app\CFS::config('ibidem/backend');
			foreach ($backend_config as $group => $tools)
			{
				foreach ($tools as $key => $tool)
				{
					if ($key == $backend_config)
					{
						if (\app\Access::can('backend', null, [$key]))
						{
							$this->view($tool);
							return;
						}
						else # doesn't have access to signin
						{
							\app\Layer_HTTP::redirect('\ibidem\access\a12n', ['action' => 'signin']);
						}
					}
				}
			}
		}
		
		// failed everything; assume misaccess
		\app\Layer_HTTP::redirect('\ibidem\access\a12n', ['action' => 'signin']);
	}

} # class
