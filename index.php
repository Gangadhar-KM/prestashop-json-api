<?php

require(dirname(__FILE__).'/../../config/config.inc.php');

class PrestashopJsonApi extends FrontController {

	public function __construct() {
		$this->name = 'productcomments';
		$this->f3 = require(dirname(__FILE__).'/lib/base.php');

		parent::__construct();
		$this->context = Context::getContext();
	}

	// Initialization
	public function initContent() {
		parent::initContent();
		$this->f3->set('AUTOLOAD','app/controllers/');

		$this->f3->route('GET /', function() {
			die(msgpack_pack('Prestashop JSON API'));
		});

		// Router
		$this->f3->map('/cms/@id_cms', 'JSONApi\Controllers\CmsController');
		$this->f3->map('/product/@id_product', 'JSONApiProductController');
		$this->f3->map('/category/@id_category/@page', 'JSONApiCategoryController');
		$this->f3->route('GET /product/latest', 'JSONApi\Controllers\ProductController->getLatest()');
		$this->f3->route('GET /product/sales', 'JSONApi\Controllers\ProductController->getSales()');
		$this->f3->route('GET /search/@term', 'JSONApi\Controllers\SearchController->find()');
	}

	// Run!
	public function run() {
		$this->f3->run();
	}
}

$prestashopJsonApi = new PrestashopJsonApi();
$prestashopJsonApi->init();
$prestashopJsonApi->initContent();
$prestashopJsonApi->run();
