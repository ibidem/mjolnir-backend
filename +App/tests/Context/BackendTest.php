<?php namespace mjolnir\backend\tests;

use \mjolnir\backend\Context_Backend;

class Context_BackendTest extends \app\PHPUnit_Framework_TestCase
{
	/** @test */ function
	can_be_loaded()
	{
		$this->assertTrue(\class_exists('\mjolnir\backend\Context_Backend'));
	}

	// @todo tests for \mjolnir\backend\Context_Backend

} # test
