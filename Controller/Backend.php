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
			
			$page_title = 'Backend · '.$tool['title'];
		}
		else # no slug
		{
			$page_title = 'Backend';
		}
		
		$this->layer->dispatch
			(
				\app\Event::instance()
					->subject(\ibidem\types\Event::title)
					->contents($page_title)
			);
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
					->target('dashboard')
					->layer($this->layer)
					->control($this)
					->context(\app\Context_Backend::instance())
					->render()
			);
	}
	
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
				echo 'Access denied.'; die;
				
				// \app\Layer_HTTP::redirect('\ibidem\access\a12n', ['action' => 'signin']);
			}
		}

		// failed everything; assume misaccess
		throw new \app\Exception_NotAllowed('Access Denied.');
		echo 'Access denied.'; die;
		// \app\Layer_HTTP::redirect('\ibidem\access\a12n', ['action' => 'signin']);
	}
	
	/**
	 * @param string action
	 * @return string 
	 */	
	public function action($action)
	{
		$relay = $this->layer->get_relay();
		return $relay['route']->url(['task' => $action, 'slug' => $this->params->get('slug')]);
	}
	
	/**
	 * @param string slug
	 * @return string URL
	 */
	function backend($slug)
	{
		return \app\Relay::route('\ibidem\backend')->url(['slug' => $slug]);
	}
	
	function pageslug()
	{
		return $this->params->get('slug', null);
	}
	
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
