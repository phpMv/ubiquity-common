<?php
namespace PhpBenchmarksUbiquity\RestApi\controllers\rest;

use Ubiquity\controllers\rest\RestBaseController;
use Ubiquity\controllers\Startup;
use Ubiquity\events\EventsManager;
use Ubiquity\contents\normalizers\NormalizersManager;
use PhpBenchmarksUbiquity\RestApi\normalizer\UserNormalizer;
use PhpBenchmarksUbiquity\RestApi\normalizer\CommentNormalizer;
use PhpBenchmarksUbiquity\RestApi\normalizer\CommentTypeNormalizer;
use PhpBenchmarksUbiquity\RestApi\eventListener\DefineLocaleEventListener;
use PhpBenchmarksRestData\User;
use PhpBenchmarksRestData\CommentType;
use PhpBenchmarksRestData\Comment;
use PhpBenchmarksRestData\Service;

/**
 *
 * @route("/benchmark/rest","inherited"=>false,"automated"=>false)
 * @rest("resource"=>"")
 */
class RestApiController extends RestBaseController {

	public function __construct() {
		if (! \headers_sent()) {
			$this->config = Startup::getConfig();
			$this->server = $this->_getRestServer();
			$this->responseFormatter = $this->_getResponseFormatter();
			$this->server->_setContentType($this->contentType);
		}
	}

	public function initialize() {}

	/**
	 * Returns all objects for the resource $model
	 *
	 * @route("cache"=>false)
	 */
	public function index() {
		EventsManager::trigger(DefineLocaleEventListener::EVENT_NAME);
		NormalizersManager::registerClasses([
			User::class => UserNormalizer::class,
			CommentType::class => CommentTypeNormalizer::class,
			Comment::class => CommentNormalizer::class
		]);
		$datas = NormalizersManager::normalizeArray_(Service::getUsers());
		echo $this->_getResponseFormatter()->toJson($datas);
	}
}

