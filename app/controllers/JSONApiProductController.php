<?php

class JSONApiProductController {
	function get($f3, $params) {
		$id_product = $params['id_product'];
		$product = new Product($id_product);
		die(Tools::jsonEncode($product));
	}
}
