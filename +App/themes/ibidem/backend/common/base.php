<? namespace app; 
	/* @var $context \app\Context_Backend */
	/* @var $control \app\Controller_Backend */
?>

<?
	$base_config = \app\CFS::config('ibidem/base');
	$site_title = $base_config['site:title'];
	$base_url = '//'.$base_config['domain'].$base_config['path'].$base_config['site:frontend'];
?>

<div class="navbar" style="padding: 5px">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="<?= $base_url ?>"><?= $site_title ?></a>
			<ul class="nav">
				<li><a href="<?= \app\Relay::route('\ibidem\backend')->url() ?>"><i class="icon-cogs"></i> System Information</a>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	
	<nav role="navigation" style="padding: 0 10px" class="span2">

		<? $page_slug = $control->pageslug() ?>
		
		<ul class="nav nav-list well">
			<? foreach ($context->dashboard() as $group): ?>
				<li class="nav-header"><strong><?= $group['title'] ?></strong></li>
				<? foreach ($group['tools'] as $tool): ?>
					<li<?= $page_slug == $tool['slug'] ? ' class="active"' : '' ?>>
						<a href="<?= $tool['url'] ?>">
							<? if ($tool['icon'] !== null): ?>
								<i class="icon-<?= $tool['icon'] ?>"></i>
							<? endif; ?>
							<?= $tool['title'] ?>
						</a>
					</li>
				<? endforeach; ?>
			<? endforeach; ?>
		</ul>

	</nav>

	<section id="page" class="span10">

		<noscript>
			<p class="alert"><strong>Hi!</strong> Please whitelist script(s) from this domain. Otherwise, site functions may not work, or will function inadequetly.</p>
		</noscript>
		
		<?= $view->render() ?>

	</section>
	
</div>