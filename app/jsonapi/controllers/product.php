<?php

namespace JSONApi\Controllers;

class Product {
	function get() {
		$id_product = 1;
		$product = new Product($id_product);
		die(msgpack_pack($product));
	}
}