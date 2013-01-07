<?php 

class JSONApiSearchController {
	function find() {
		$results = array();
		die(msgpack_pack($results));
	}
}