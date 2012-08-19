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
	/**
	 * @var string
	 */
	protected $model = null;
	
	/**
	 * @var string
	 */
	protected $index = null;
	
	/**
	 * @return string class
	 */
	protected function resolve_class()
	{
		return '\app\Model_'.$this->model;
	}
	
	/**
	 * Action for creating new elements in the collection.
	 */
	function action_new()
	{
		if (\app\Server::request_method() === 'POST')
		{
			$class = static::resolve_class();
			if ($errors = $class::push($_POST))
			{
				$key = \strtolower($this->model).'-new';
				return array
					(
						$key => $errors,
					);
			}
			else # errors is null (success
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
		\app\URL::route('\ibidem\backend')
			->url(['slug' => $this->index]);	
	}
	
	/**
	 * Action for updating elements in the collection.
	 */
	function action_update()
	{
		$id = $_POST['id'];
		
		$class = static::resolve_class();
		$errors = $class::update($id, $_POST);
		
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
	
	/**
	 * Action for deleting elements in the collection.
	 */
	function action_delete()
	{
		if (isset($_POST['selected']) && ! empty($_POST['selected']))
		{
			$class = static::resolve_class();
			$class::delete($_POST['selected']);
		}
	}
	
	/**
	 * Action for deleting a single element in the collection.
	 */
	function action_erase()
	{
		$class = static::resolve_class();
		$class::delete([$_POST['id']]);
		
		\app\Layer_HTTP::redirect
			(
				'\ibidem\backend', 
				['slug' => $this->index]
			);
	}
	
	// ------------------------------------------------------------------------
	// Context
	
	/**
	 * @return array of arrays; collection entries
	 */
	function entries($page, $limit, $offset = 0, array $order = [])
	{
		$class = static::resolve_class();
		return $class::entries($page, $limit, $offset, $order);
	}
	
	/**
	 * @return array collection entry
	 */
	function entry($id)
	{
		$class = '\app\Model_'.$this->model;
		return $class::entry($id);
	}
	
	/**
	 * @return \app\Pager
	 */
	function pager()
	{
		$class = static::resolve_class();
		return \app\Pager::instance($class::count());
	}

} # class
