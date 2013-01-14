<?php

require(dirname(__FILE__).'/../../config/config.inc.php');

class PrestashopJsonApi extends FrontController {

	public function __construct() {
		$this->name = 'productcomments';
		$this->f3 = require(dirname(__FILE__).'/lib/base.php');

		parent::__construct();
		$this->context = Context::getContext();
	}

	public function initContent() {
		// Initialization
		parent::initContent();
		$this->f3->set('AUTOLOAD', 'app/controllers/; app/models/');

		$this->f3->route('GET /', function() {
			die(Tools::jsonEncode('Prestashop JSON API'));
		});

		// Router
		$this->f3->map('/cms/@id_cms', 'JSONApiCmsController');
		$this->f3->map('/product/@id_product', 'JSONApiProductController');
		$this->f3->map('/category/@id_category/@page', 'JSONApiCategoryController');
		$this->f3->route('GET /product/latest', 'JSONApiProductController->getLatest');
		$this->f3->route('GET /product/sales', 'JSONApiProductController->getSales');
		$this->f3->route('GET /category/all', 'JSONApiCategoryController->getAll');
		$this->f3->route('GET /search/@term', 'JSONApiSearchController->find');
	}

	public function run() {
		// Run!
		$this->f3->run();
	}
}

$prestashopJsonApi = new PrestashopJsonApi();
$prestashopJsonApi->init();
$prestashopJsonApi->initContent();
$prestashopJsonApi->run();
