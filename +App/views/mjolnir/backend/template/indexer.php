<?
	namespace app;

	/* @var $theme ThemeView */

	$default_pagelimit = 25;
	
	// input variables

	$plural = isset($plural) ? $plural : 'entries';
	$singular = isset($singular) ? $singular : 'entry';
	$order = isset($order) ? $order : ['id' => 'desc'];
	$search_columns = isset($search_columns) ? $search_columns : \array_keys($columns);
	$renderers = isset($renderers) ? $renderers : [];
	$actions = isset($actions) ? $actions : [];
	$aggregate = isset($aggregate) ? $aggregate : array
		(
			'delete' => array
				(
					'icon' => 'trash',
					'title' => 'Delete All',
					'class' => 'btn-danger'
				),
		);

	// settings

	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$search = isset($_GET['q']) ? $_GET['q'] : null;
	$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : null;
	$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';
	$pagelimit = isset($_GET['limit']) ? $_GET['limit'] : $default_pagelimit;

	// calculations

	if ($sort_by !== null)
	{
		$order = [ $sort_by => $sort_order ];
	}

	$search_query = $search !== null ? 'q='.\urldecode($search) : null;
	$limit_query = $default_pagelimit === $pagelimit ? '' : "limit=$pagelimit";
	
	if (empty($search))
	{
		$entries = $context->entries($page, $pagelimit, 0, $order);
		
		$pager = $context->pager();
		/* @var $pager Pager */
		$pager
			->appendquery("$search_query&amp;$limit_query")
			->pagelimit_is($pagelimit)
			->page_is($page)
			->apply('twitter');
	}
	else # search mode
	{
		$pagelimit = 100;
		$entries = $context->search($search, $search_columns, $page, $pagelimit, 0, $order);
		$pager = '';
	}
?>

<br/>

<?= $limit_form = HTML::queryform() ?>
<div class="input-append pull-left">
	<?= $limit_form->text('Show', 'limit')
		->value_is($pagelimit)
		->add('class', 'span4') ?>
	
	<button class="btn" type="submit" <?= $limit_form->mark() ?>>
		Limit
	</button>
</div>


<?= $search_form = HTML::queryform() ?>
<div class="input-append pull-right">
	<?= $search_form->text('Search', 'q')
		->value_is($search) ?>
	
	<button class="btn" type="submit" <?= $search_form->mark() ?>>
		Search
	</button>
</div>

<? if ( ! empty($entries)): ?>

	<?= $form = HTML::form($control->action('aggregate'))
		->addfieldtemplate(':field') ?>

	<table class="table table-striped marginless">
		<thead>
			<tr>
				<? if ( ! empty($aggregate)): ?>
					<th class="micro-col">&nbsp;</th>
				<? endif; ?>
				<? foreach ($columns as $field => $title): ?>
					<th>
						<a href="?sort_by=<?= $field ?>&amp;sort_order=<?= ($sort_by == $field && $sort_order == 'asc' ? 'desc' : 'asc')."$search_query&amp;$limit_query" ?>">
							<?= $title ?>
						</a>
					</th>
				<? endforeach; ?>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<? foreach ($entries as $entry): ?>
				<tr>
					<? if ( ! empty($aggregate)): ?>
						<td>
							<?= $form->checkbox(null, 'selected[]')
								->value_is($entry['id']) ?>
						</td>
					<? endif; ?>

					<? foreach ($columns as $field => $title): ?>
						<? if (\in_array($field, \array_keys($renderers))): ?>
							<td><?= $renderers[$field]($entry) ?></td>
						<? else: # normal field ?>
							<td><?= $entry[$field] ?></td>
						<? endif; ?>
					<? endforeach; ?>

					<td class="table-controls">

						<? foreach ($actions as $backend => $action): ?>
							<a href="<?= $control->backend($backend) ?>?id=<?= $entry['id'] ?>"
							   class="btn btn-mini<?= isset($action['class']) ? ' '.$action['class'] : '' ?>">
								 <?= $action['title'] ?>
							</a>
						<? endforeach; ?>

						<?= $delete_form = HTML::form($control->action('erase'), 'mjolnir:inline') ?>
						<?= $delete_form->hidden('id')->value_is($entry['id']) ?>
						<button <?= $delete_form->mark() ?> class="btn btn-mini btn-danger">
							Delete
						</button>

					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>

	<div class="row-fluid">
		<br/>
		<div class="pull-right marginless-pagination">
			<?= $pager ?>
		</div>

		<? foreach ($aggregate as $action => $button): ?>
			<button name="<?= $action ?>" type="submit"
					class="btn btn-mini<?= isset($button['class']) ? ' '.$button['class'] : '' ?>"
					<?= $form->mark() ?>>

				<? if (isset($button['icon'])): ?>
					<i class="icon-<?= $button['icon'] ?>"></i>&nbsp;
				<? endif; ?>

				<?= $button['title'] ?>

			</button>
		<? endforeach; ?>
	</div>


<? else: # no users in system ?>
	<br/>
	<p class="alert alert-info">There are currently <strong>no <?= $plural ?></strong> in the system.</p>
<? endif; ?>

<hr/>
