<h2>Loaded Modules</h2>
<? $versions = \app\CFS::config('version') ?>

<table>
	<thead>
		<tr>
			<th>Module</th>
			<th>Version</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($versions as $name => $version): ?>
			<tr><td><?= $name ?></td><td><?= $version['major'].'.'.$version['minor'] ?></td></tr>
		<? endforeach; ?>
	</tbody>
</table>