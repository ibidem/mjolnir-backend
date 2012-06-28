<?  
	/* @var $context \app\Context_Backend */
	/* @var $control \app\Controller_Backend */

	namespace app;

	$base_config = \app\CFS::config('ibidem/base');
	$site_title = $base_config['site:title'];
	$base_url = '//'.$base_config['domain'].$base_config['path'].$base_config['site:frontend'];
?>

<div class="container">

	<div class="navbar">
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

		<nav role="navigation" class="span3">

			<div class="well" style="padding: 8px 0;">
				<? $page_slug = $control->pageslug() ?>
				<ul class="nav nav-list">
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
			</div>

		</nav>

		<section id="page" class="span9">

			<noscript>
				<p class="alert">
					<strong>Hi!</strong> Please whitelist script(s) from this domain. Otherwise, site functions may not work, or will function inadequetly.
				</p>
			</noscript>

			<? if (Access::can('\ibidem\backend', null, null, \app\A12n::guest())): ?>
				<p class="alert alert-error">
					<button data-dismiss="alert" class="close" type="button">×</button>
					<big><strong>Major security vulnerability detected</strong>: guest role has access to backend systems!</big>
					<br/>
					If you are viewing this in a production environment <strong>drop all you're doing and fix it NOW</strong>!
				</p>
			<? endif; ?>

			<?= $view->render() ?>

		</section>

	</div>
	
</div>
