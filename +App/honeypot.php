<?php namespace app;

// This is an IDE honeypot. It tells IDEs the class hirarchy, but otherwise has
// no effect on your application. :)

// HowTo: order honeypot -n 'ibidem\backend'

class Backend_Collection extends \ibidem\backend\Backend_Collection { /** @return \ibidem\backend\Backend_Collection */ static function instance() { return parent::instance(); } }
class Context_Backend extends \ibidem\backend\Context_Backend { /** @return \ibidem\backend\Context_Backend */ static function instance() { return parent::instance(); } }
class Controller_Backend extends \ibidem\backend\Controller_Backend { /** @return \ibidem\backend\Controller_Backend */ static function instance() { return parent::instance(); } }
