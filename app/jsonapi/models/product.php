<?php

namespace JSONApi\Models;

class Product {
	function get() {
		$id_product = 1;
		$product = new Product($id_product);
		die(json_encode($product));
	}
}