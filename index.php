<?php

// Prestashop Initializationx
require_once(dirname(__FILE__).'/../../config/settings.inc.php');
require_once(dirname(__FILE__).'/../../config/defines.inc.php');
require_once(dirname(__FILE__).'/../../config/autoload.php');

Context::getContext()->shop = Shop::initialize();
Shop::setContext(Shop::CONTEXT_SHOP, Context::getContext()->shop->id);

// F3 initialization
$f3 = require(dirname(__FILE__).'/lib/base.php');
$f3->set('AUTOLOAD','app/controllers/');

$f3->route('GET /', function() {
	die(msgpack_pack('Prestashop JSON API'));
});

// Router
$f3->map('/cms/@id_cms', 'JSONApi\Controllers\CmsController');
$f3->map('/product/@id_product'	, 'JSONApiProductController');
$f3->route('GET /product/latest', 'JSONApi\Controllers\ProductController->getLatest()');
$f3->route('GET /product/sales', 'JSONApi\Controllers\ProductController->getSales()');
$f3->route('GET /search/@term', 'JSONApi\Controllers\SearchController->find()');

// Run!
$f3->run();