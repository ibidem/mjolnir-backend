<?php namespace ibidem\backend;

/**
 * @package    ibidem
 * @category   Backend
 * @author     Ibidem
 * @copyright  (c) 2012, Ibidem Team
 * @license    https://github.com/ibidem/ibidem/blob/master/LICENSE.md
 */
class Backend_Collection extends \app\Instantiatable
{
	// configuration
	protected $model = null;
	protected $index = null;
	
	function action_new()
	{
		if (\app\Layer_HTTP::request_method() === \ibidem\types\HTTP::POST)
		{
			$class = '\app\Model_DB_'.$this->model;
			if ($validator = $class::factory($_POST))
			{
				$key = \strtolower($this->model).'-new';
				return array
					(
						$key => $validator->validate(),
					);
			}
			else # $validator is null (success)
			{
				\app\Layer_HTTP::redirect
					(
						'\ibidem\backend', 
						['slug' => $this->index]
					);
				
				return null;
			}
		}
		
		// GET request; redirect
		\app\Relay::route('\ibidem\backend')
			->url(['slug' => $this->index]);	
	}
	
	function action_update()
	{
		$id = $_POST['id'];
		
		$class = '\app\Model_DB_'.$this->model;
		$validator = $class::update($id, $_POST);
		
		$errors = [];
		if ($validator !== null)
		{
			$errors = $validator->validate();
		}
		
		if (empty($errors))
		{
			\app\Layer_HTTP::redirect
				(
					'\ibidem\backend', 
					['slug' => $this->index]
				);
		}
		else # got errors
		{
			$key = \strtolower($this->model).'-update';
			$errors = [$key => $errors];
			
			return $errors;
		}
	}
	
	function action_delete()
	{
		if (isset($_POST['selected']) && ! empty($_POST['selected']))
		{
			$class = '\app\Model_DB_'.$this->model;
			$class::delete($_POST['selected']);
		}
	}
	
	function action_erase()
	{
		$class = '\app\Model_DB_'.$this->model;
		$class::delete([$_POST['id']]);
		\app\Model_DB_User::delete([$_POST['id']]);
		
		\app\Layer_HTTP::redirect
			(
				'\ibidem\backend', 
				['slug' => $this->index]
			);
	}
	
	function entries($page, $limit, $offset = 0)
	{
		$class = '\app\Model_DB_'.$this->model;
		return $class::entries($page, $limit, $offset);
	}
	
	function entry($id)
	{
		$class = '\app\Model_DB_'.$this->model;
		return $class::entry($id);
	}
	
	function pager()
	{
		$class = '\app\Model_DB_'.$this->model;
		return \app\Pager::instance($class::count());
	}

} # class
