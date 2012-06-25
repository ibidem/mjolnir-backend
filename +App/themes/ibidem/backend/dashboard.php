<? namespace app; ?>

<h1>Named Components</h1>

<? $versions = \app\CFS::config('version') ?>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Components</th>
			<th>Version</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($versions as $name => $version): ?>
			<tr><td><?= $name ?></td><td><?= $version['major'].'.'.$version['minor'] ?></td></tr>
		<? endforeach; ?>
	</tbody>
</table>