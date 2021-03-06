<?php namespace mjolnir\backend;

/**
 * @package    mjolnir
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
		if (\class_exists('\app\Model_'.$this->model))
		{
			return '\app\Model_'.$this->model;
		}
		else if (\class_exists('\app\\'.$this->model.'Lib'))
		{
			return '\app\\'.$this->model.'Lib';
		}
		else # assume full class name
		{
			throw new \app\Exception_NotApplicable('Model ['.$this->model.'] can not be resolved to a class.');
		}
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
			else # errors is null (success)
			{
				\app\Server::redirect
					(
						\app\URL::href('mjolnir:backend.route', ['slug' => $this->index])
					);

				return null;
			}
		}

		// GET request; redirect
		\app\Server::redirect(\app\URL::href('mjolnir:backend.route', ['slug' => $this->index]));
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
			\app\Server::redirect(\app\URL::href('mjolnir:backend.route', ['slug' => $this->index]));
		}
		else # got errors
		{
			$key = \strtolower($this->model).'-update';
			$errors = [$key => $errors];

			return $errors;
		}
	}

	function action_aggregate()
	{
		if (isset($_POST, $_POST['delete']))
		{
			return $this->action_delete();
		}

		throw \app\Exception('Unrecognized aggregate process.');
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

		\app\Server::redirect(\app\URL::href('mjolnir:backend.route', ['slug' => $this->index]));
	}

	// ------------------------------------------------------------------------
	// Context

	/**
	 * @return array of arrays; collection entries
	 */
	function entries($page, $limit, $offset = 0, array $order = [], array $constraints = [])
	{
		$class = static::resolve_class();
		return $class::entries($page, $limit, $offset, $order, $constraints);
	}

	/**
	 * @return array of arrays; collection search entries
	 */
	function search($search, $columns, $page, $limit, $offset, array $order = [])
	{
		$class = static::resolve_class();
		$search_entries = $class::search($search, $columns, $page, $limit, $offset, $order);
		return $class::select_entries(\app\Arr::gather($search_entries, 'id'));
	}

	/**
	 * @return array collection entry
	 */
	function entry($id)
	{
		$class = static::resolve_class();
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
