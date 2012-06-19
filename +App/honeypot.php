<?php namespace app;

// This is a IDE honeypot. :)

// HowTo: minion honeypot -n "ibidem\\backend"

class Backend_Ibidem extends \ibidem\backend\Backend_Ibidem { /** @return \ibidem\backend\Backend_Ibidem */ static function instance() { return parent::instance(); } }
class Context_Backend extends \ibidem\backend\Context_Backend { /** @return \ibidem\backend\Context_Backend */ static function instance() { return parent::instance(); } }
class Controller_Backend extends \ibidem\backend\Controller_Backend { /** @return \ibidem\backend\Controller_Backend */ static function instance() { return parent::instance(); } }
