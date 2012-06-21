<? namespace app; 
	/* @var $context \app\Context_Backend */
?>

<?
	$base_config = \app\CFS::config('ibidem/base');
	$site_title = $base_config['site:title'];
	$base_url = '//'.$base_config['domain'].$base_config['path'].$base_config['site:frontend'];
?>

<nav class="js-dashboard ui-dashboard" role="navigation">

	<div class="padder">

		<header>
			<h1>
				<a href="<?= $base_url ?>">
					<?= $site_title ?>
				</a>
			</h1>

			<p>Access level <em><?= \app\A12n::instance()->role() ?></em></p>
		</header>

		<hr/>

		<ul>
			<? foreach ($context->dashboard() as $group): ?>
			<li>
				<? $_GET['tab'] = $group['slug'] ?>
				<strong><?= $group['title'] ?></strong>
				<ul>
					<? foreach ($group['tools'] as $tool): ?>
						<li><a href="<?= $tool['url'] ?>"><?= $tool['title'] ?></a></li>
					<? endforeach; ?>
				</ul>
			</li>
			<? endforeach; ?>
		</ul>

	</div>

</nav>

<div id="page">
	<div class="padder">
		
		<noscript>
			Hi! Please whitelist script(s) from this domain; otherwise site functions may not work, or will function inadequetly.
		</noscript>
		
		<?= $view->render() ?>
	</div>
</div>