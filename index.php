<?php

$f3 = require(dirname(__FILE__).'/lib/base.php');
$f3->set('AUTOLOAD','app/');

$f3->route('GET /', 
	function() {
		die(json_encode('Prestashop JSON API'));
	}
);

$f3->map('/product/@id_product', 'JSONApi\Models\Product');

$f3->run();