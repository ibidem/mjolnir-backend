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
	protected static $target = 'backend';
	
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
	
	/**
	 * General purpose settings.
	 */
	function before() 
	{
		parent::before();
		// backend ignores language settings since different modules can be 
		// injected in and (most likely) none of them will know which language 
		// to support
		\app\Lang::lang('en-us');
		
		$slug = $this->params->get('slug', null);
		
		if ($slug !== null)
		{
			$tool = self::tool_config($slug);
			if ($tool === null)
			{
				throw new \app\Exception_NotAllowed('Access Denied.');
			}
			
			$page_title = $tool['title'].' · Backend';
		}
		else # no slug
		{
			$page_title = 'Backend';
		}
		
		\app\GlobalEvent::fire('webpage:title', $page_title);
		
		$jquery = \app\URL::route('\ibidem\theme\Layer_Theme::script')
			->url
			(
				[
					'theme' => 'ibidem/backend',
					'style' => 'default',
					'version' => '0.0',
					'target' => 'src/lib/plugins/jquery-1.7.2.min'
				]
			);

		\app\GlobalEvent::fire('webpage:head-script', $jquery);
	}
	
	/**
	 * Show backend.
	 */
	function action_index()
	{
		$this->body
			(
				\app\ThemeView::instance()
					->theme('ibidem/backend')
					->target('dashboard')
					->layer($this->layer)
					->control($this)
					->context(\app\Context_Backend::instance())
					->render()
			);
	}
	
	/**
	 * Render view.
	 */
	function view($config)
	{
		$this->page = \app\View::instance($config['view'])
			->variable('context', $config['context']::instance())
			->variable('control', $this);
		
		$this->body
			(
				\app\ThemeView::instance()
					->theme('ibidem/backend')
					->target('wrapper')
					->layer($this->layer)
					->control($this)
					->context(\app\Context_Backend::instance())
					->render()
			);
	}
	
	/**
	 * Backend task.
	 */
	function task($task, $config)
	{
		$context = $config['context']::instance();
		
		$task = \str_replace('-', '_', \strtolower($task));
		$errors = \call_user_func([$context, 'action_'.$task]);
		
		$this->page = \app\View::instance($config['view'])
			->variable('context', $context)
			->variable('control', $this)
			->variable('errors', $errors);
		
		$this->body
			(
				\app\ThemeView::instance()
					->theme('ibidem/backend')
					->target('wrapper')
					->layer($this->layer)
					->control($this)
					->context(\app\Context_Backend::instance())
					->render()
			);
	}	
	
	/**
	 * Route to slug and task.
	 */
	function action_route()
	{
		$slug = $this->params->get('slug', null);
		$task = $this->params->get('task', null);
		
		if ($slug === null)
		{
			$this->action_index();
			return;
		}
		else # slug is present
		{
			// validate			
			if (\app\Access::can('\ibidem\backend', null, $slug))
			{
				$tool = self::tool_config($slug);
				
				if ($tool == null)
				{
					throw new \app\Exception_NotAllowed('Access Denied.');
				}
				
				if ($task === null)
				{
					$this->view($tool);
					return;
				}
				else # task provided
				{
					$this->task($task, $tool);
					return;
				}
			}
			else # doesn't have access
			{
				throw new \app\Exception_NotAllowed('Access Denied.');
			}
		}

		// failed everything; assume misaccess
		throw new \app\Exception_NotAllowed('Access Denied.');
	}
	
	/**
	 * @param string action
	 * @return string 
	 */	
	function action($action)
	{
		$relay = $this->layer->get_relay();
		return $relay['matcher']->url(['task' => $action, 'slug' => $this->params->get('slug')]);
	}
	
	/**
	 * @param string slug
	 * @return string URL
	 */
	function backend($slug)
	{
		return \app\URL::route('\ibidem\backend')->url(['slug' => $slug]);
	}
	
	/**
	 * @return string page slug
	 */
	function pageslug()
	{
		return $this->params->get('slug', null);
	}
	
	/**
	 * @param string slug
	 * @return tool or null
	 */
	private static function tool_config($slug)
	{
		$backend_config = \app\CFS::config('ibidem/backend');
		foreach ($backend_config as $group => $tools)
		{
			foreach ($tools as $key => $tool)
			{
				if ($key == $slug)
				{
					return $tool;
				}
			}
		}
		
		return null;
	}


} # class
