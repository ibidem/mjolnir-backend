<?php namespace mjolnir\backend;

$mvc = \app\CFS::config('mjolnir/layer-stacks')['public'];

\app\Router::process('mjolnir:backend.route', $mvc);
