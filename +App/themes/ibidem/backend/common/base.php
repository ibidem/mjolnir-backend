<? namespace app; 
	/* @var $context \app\Context_Backend */
?>

<?
	$base_config = \app\CFS::config('ibidem/base');
	$site_title = $base_config['site:title'];
	$base_url = '//'.$base_config['domain'].$base_config['path'].$base_config['site:frontend'];

	$dashboard = $context->dashboard();

	if ( ! isset($_GET['tab']))
	{
		$tab = $dashboard[0]['slug'];
	}
	else # get global set
	{
		$tab = $_GET['tab'];
	}
?>

<nav class="js-dashboard ui-dashboard" role="navigation">

	<div class="padder">

		<header>
			<h1>
				<a href="<?= $base_url ?>">
					<?= $site_title ?>
				</a>
			</h1>

			<p>Logged in as <em><?= \app\A12n::instance()->role() ?></em></p>
		</header>

		<hr/>

		<ul>
			<? foreach ($context->dashboard() as $group): ?>
			<li>
				<? $_GET['tab'] = $group['slug'] ?>
				<strong><a href="?<?= \http_build_query($_GET, '', '&amp;') ?>"><?= $group['title'] ?></a></strong>
				<? if ($group['slug'] == $tab): ?>
					<ul>
						<? foreach ($group['tools'] as $tool): ?>
							<li><a href="<?= $tool['url'] ?>"><?= $tool['title'] ?></a></li>
						<? endforeach; ?>
					</ul>
				<? endif; ?>
			</li>
			<? endforeach; ?>
		</ul>

	</div>

</nav>

<div id="page">
	<div class="padder">
		
		<noscript>
			Please whitelist the script(s) from this domain.
		</noscript>
		
		<?= $view->render() ?>
	</div>
</div>