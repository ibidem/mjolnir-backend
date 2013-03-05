<?
	namespace app;
?>

<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a href="<?= \app\Server::url_frontpage() ?>" class="brand">
				<?= \app\CFS::config('mjolnir/base')['site:title'] ?>
			</a>

			<div class="nav-collapse collapse">
				<p class="navbar-text pull-right">
					Logged in as <strong><?= Auth::info()['nickname'] ?></strong>
				</p>
				<ul class="nav">
					<li>
						<a href="<?= \app\URL::href('mjolnir:backend.route') ?>">
							<i class="icon-cogs"></i> System Information
						</a>
					</li>
				</ul>
				<ul class="nav pull-right">
					<li>
						<a href="<?= \app\URL::href('mjolnir:access/auth.route') ?>">
							<i class="icon-signin"></i> Lobby
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="span3">
			<div class="well sidebar-nav">
				<ul class="nav nav-list">
					<? $page_slug = $control->pageslug() ?>
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
		</div>
		<div class="span9">
			<?= $entrypoint->render() ?>
		</div>
	</div>
</div>



