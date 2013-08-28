<?php namespace mjolnir\backend\tests;

use \mjolnir\backend\Controller_Backend;

class Controller_BackendTest extends \PHPUnit_Framework_TestCase
{
	/** @test */ function
	can_be_loaded()
	{
		$this->assertTrue(\class_exists('\mjolnir\backend\Controller_Backend'));
	}

	// @todo tests for \mjolnir\backend\Controller_Backend

} # test
