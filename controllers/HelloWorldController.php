<?php
namespace PhpBenchmarksUbiquity\HelloWorld\controllers;

/**
 * Controller HelloWorldController
 */
class HelloWorldController extends \Ubiquity\controllers\Controller {

	public function __construct() {}

	/**
	 *
	 * @route("/benchmark/helloworld")
	 */
	public function index() {
		echo 'Hello World !';
	}
}
