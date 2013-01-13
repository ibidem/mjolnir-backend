<?php namespace mjolnir\backend;

$mvc = \app\CFS::config('mjolnir/layer-stacks')['mvc'];

\app\Relay::process('\mjolnir\backend', $mvc);
