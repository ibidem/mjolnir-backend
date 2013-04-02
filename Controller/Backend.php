<?php namespace mjolnir\backend;

/**
 * @package    mjolnir
 * @category   Controller
 * @author     Ibidem
 * @copyright  (c) 2012, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Controller_Backend extends \app\Puppet implements \mjolnir\types\Controller
{
	use \app\Trait_Controller
		{
			preprocess as protected trait_preprocess;
		}

	/**
	 * @var \app\View
	 */
	protected $page;

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
	function preprocess()
	{
		$this->trait_preprocess();

		// backend ignores language settings since different modules can be
		// injected in and (most likely) none of them will know which language
		// to support
		\app\Lang::targetlang_is('en-US');

		$slug = $this->channel()->get('relaynode')->get('slug', null);

		if ($slug !== null)
		{
			$tool = static::tool_config($slug);

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

		$this->channel()->get('layer:html')->set('title', $page_title);

		$jquery_url = \app\URL::href
			(
				'mjolnir:theme/themedriver/javascript.route',
				[
					'theme' => 'mjolnir/backend',
					'style' => 'default',
					'version' => '0.0',
					'target' => 'src/+vendor/jquery/jquery'
				]
			);

		$htmllayer = $this->channel()->get('layer:html');
		
		if ($htmllayer)
		{
			$htmllayer->add
				(
					'headscript', 
					[
						'type' => 'application/javascript', 
						'src' => $jquery_url
					]
				);
		}
	}

	/**
	 * Show backend.
	 */
	function public_index()
	{
		$theme = \app\Theme::instance('mjolnir/backend')
			->channel_is($this->channel());

		return \app\ThemeView::fortarget('dashboard', $theme)
			->pass('context', \app\Context_Backend::instance())
			->pass('control', $this);
	}

	/**
	 * Render view.
	 */
	function view($config)
	{
		try
		{
			$this->page = \app\View::instance($config['view'])
				->pass('context', $config['context']::instance())
				->pass('control', $this);

			$theme = \app\Theme::instance('mjolnir/backend')
				->channel_is($this->channel());

			return \app\ThemeView::fortarget('wrapper', $theme)
				->pass('control', $this)
				->pass('context', \app\Context_Backend::instance());
		}
		catch (\Exception $e)
		{
			// exceptions in the backend system are too serious to go though 
			// logging (chances are logging may not even be working). To make 
			// sure the local administrators know what they are easily we output
			// them directly; this is secure since only system administrators 
			// should have access to backend panels
			echo $e->getMessage();
			exit(1);
		}
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
			->pass('context', $context)
			->pass('control', $this)
			->bind('errors', $errors);

		$theme = \app\Theme::instance('mjolnir/backend')
			->channel_is($this->channel());

		return \app\ThemeView::fortarget('wrapper', $theme)
			->pass('control', $this)
			->pass('context', \app\Context_Backend::instance());
	}

	/**
	 * Route to slug and task.
	 */
	function action_route()
	{
		$relaynode = $this->channel()->get('relaynode');

		$slug = $relaynode->get('slug', null);
		$task = $relaynode->get('task', null);

		if ($slug === null)
		{
			return $this->public_index();
		}
		else # slug is present
		{
			// validate
			if (\app\Access::can('mjolnir:backend.route', null, $slug))
			{
				$tool = self::tool_config($slug);

				if ($tool == null)
				{
					throw new \app\Exception_NotAllowed('Access Denied.');
				}

				if ($task === null)
				{
					return $this->view($tool);
				}
				else # task provided
				{
					return $this->task($task, $tool);
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
		$relaynode = $this->channel()->get('relaynode');
		return $relaynode->get('matcher')->url(['task' => $action, 'slug' => $relaynode->get('slug')]);
	}

	/**
	 * @param string slug
	 * @return string URL
	 */
	function backend($slug)
	{
		return \app\URL::route('mjolnir:backend.route')->url(['slug' => $slug]);
	}

	/**
	 * @return string page slug
	 */
	function pageslug()
	{
		return $this->channel()->get('relaynode')->get('slug', null);
	}

	/**
	 * @param string slug
	 * @return tool or null
	 */
	protected static function tool_config($slug)
	{
		$backend_config = \app\CFS::config('mjolnir/backend');
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
