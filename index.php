<?php

$f3 = require(dirname(__FILE__).'/lib/base.php');
$f3->set('AUTOLOAD','app/');

$f3->route('GET /', function() {
	die(json_encode('Prestashop JSON API'));
});

// Router
$f3->map('/cms/@id_cms', 'JSONApi\Controllers\Cms');
$f3->map('/product/@id_product'	, 'JSONApi\Controllers\Product');
$f3->route('GET /product/latest', 'JSONApi\Controllers\Product->getLatest()');
$f3->route('GET /product/sales', 'JSONApi\Controllers\Product->getSales()');
$f3->route('GET /search/@term', 'JSONApi\Controllers\Search->find()');

// Run!
$f3->run();