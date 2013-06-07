<?
	namespace app;

	/* @var $theme ThemeView */

	$versions = CFS::config('version');
	$requrelist = CFS::config('mjolnir/require');
?>

<h1>System Information</h1>

<ul class="nav nav-tabs">
	<li class="active"><a href="#status-tab" data-toggle="tab">Status</a></li>
	<li><a href="#components-tab" data-toggle="tab">Components</a></li>
</ul>

<div class="tab-content">

	<div class="tab-pane active" id="status-tab">

		<?
			$errors = 0;
			$failed = 0;
		?>

		<? View::frame() ?>

			<table class="table table-striped">

				<thead>
					<tr>
						<th>Status</th>
						<th>Requirement</th>
					</tr>
				</thead>

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
									case 'satisfied':
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

		<? $checks = View::endframe() ?>

		<? if ($errors > 0): ?>
			<div class="alert alert-error"><strong>Failed!</strong> Please check the tests bellow and documentation and enable/install/configure any missing requirements.</div>
		<? elseif ($failed > 0): ?>
			<div class="alert alert-warning"><strong>Usable.</strong> You are missing some non-critical components or have some strange configuration settings. The system may not be fit for production but will work fine in development.</div>
		<? else: ?>
			<div class="alert alert-success"><strong>All Requirements Satisfied.</strong> All systems have their required dependencies.</div>
		<? endif; ?>

		<hr/>

		<?= $checks ?>

	</div>
	
	<div class="tab-pane" id="components-tab">
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
	</div>
	
</div>