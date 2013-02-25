<?
	namespace app;

	/* @var $theme ThemeView */

	$versions = \app\CFS::config('version')
?>

<h1>System Information</h1>

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
				<td><?= $version['major'].'.'.$version['minor'].(isset($version['tag']) && ! empty($version['tag']) ? '-'.$version['tag'] : '') ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
