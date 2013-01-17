<?php namespace mjolnir\backend;

$mvc = \app\CFS::config('mjolnir/layer-stacks')['mvc'];

\app\Router::process('\mjolnir\backend', $mvc);
