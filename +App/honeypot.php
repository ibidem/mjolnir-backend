<?php namespace app;

// This is an IDE honeypot. It tells IDEs the class hirarchy, but otherwise has
// no effect on your application. :)

// HowTo: order honeypot -n 'mjolnir\backend'


class Backend_Collection extends \mjolnir\backend\Backend_Collection
{
	/** @return \app\Backend_Collection */
	static function instance() { return parent::instance(); }
}

/**
 * @method \app\Context_Backend set_pageslug($pageslug)
 */
class Context_Backend extends \mjolnir\backend\Context_Backend
{
	/** @return \app\Context_Backend */
	static function instance() { return parent::instance(); }
}

/**
 * @method \app\Controller_Backend channel_is($channel)
 * @method \app\Channel channel()
 * @method \app\Controller_Backend add_preprocessor($name, $processor)
 * @method \app\Controller_Backend add_postprocessor($name, $processor)
 * @method \app\Controller_Backend trait_preprocess()
 * @method \app\Controller_Backend postprocess()
 */
class Controller_Backend extends \mjolnir\backend\Controller_Backend
{
	/** @return \app\Controller_Backend */
	static function instance() { return parent::instance(); }
}
