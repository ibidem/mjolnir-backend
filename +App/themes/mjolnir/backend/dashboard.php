<?
	namespace app;

	/* @var $theme ThemeView */

	$versions = CFS::config('version');
	$requrelist = CFS::config('mjolnir/require');
?>

<h1>System Information</h1>

<table class="table table-striped">
	
	<thead>
		<tr>
			<th>Status</th>
			<th>Requirement</th>
		</tr>
	</thead>
	
	<?
		$errors = 0;
		$failed = 0;
	?>
	
	<tbody>
	
		<? foreach ($requrelist as $ns => $requirements): ?>
		
			<? foreach ($requirements as $requirement => $tester): ?>
				<?
					try
					{
						 $statusinfo = $tester();
					}
					catch (\Exception $e)
					{
						\mjolnir\log_exception($e);
						$statusinfo = 'untestable';
					}

					if (\is_array($statusinfo))
					{
						$status = \key($statusinfo);
						$statushint = \current($statusinfo); 
					}
					else # non-array status
					{
						$status = $statushint = $statusinfo;
					}

					$statusclass = '';
					switch ($status)
					{
						case 'untestable':
							$statusclass = 'error';
							$labelclass = 'label-error';
							++$errors;
							break;
						case 'error':
							$statusclass = 'error';
							$labelclass = 'label-error';
							++$errors;
							break;
						case 'failed':
							$statusclass = 'warning';
							$labelclass = 'label-warning';
							++$failed;
							break;
						case 'available':
							$labelclass = 'label-success';
							break;
					}
				?>
				<tr class="<?= $statusclass ?>">
					<td><span class="label <?= $labelclass ?>"><?= $statushint ?></span></td>
					<td><?= $requirement ?></td>
				</tr>
			<? endforeach; ?>
			
		<? endforeach; ?>
				
	</tbody>
</table>

<h2>Components</h2>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Component</th>
			<th>Version</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($versions as $name => $version): ?>
			<tr>
				<td><?= $name ?></td>
				<td><big><?= $version['major'].'.'.$version['minor'].(isset($version['tag']) && ! empty($version['tag']) ? '-'.$version['tag'] : '') ?></big></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
