<?php 

namespace JSONApi\Controllers;

class Search {
	function find() {
		$results = array();
		die(msgpack_pack($results));
	}
}