<?php namespace mjolnir\backend\tests;

use \mjolnir\backend\Backend_Collection;

class Backend_CollectionTest extends \app\PHPUnit_Framework_TestCase
{
	/** @test */ function
	can_be_loaded()
	{
		$this->assertTrue(\class_exists('\mjolnir\backend\Backend_Collection'));
	}

	// @todo tests for \mjolnir\backend\Backend_Collection

} # test
