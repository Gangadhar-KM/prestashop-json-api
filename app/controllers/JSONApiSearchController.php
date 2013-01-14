<?php

class JSONApiSearchController {
	function find() {
		$results = array();
		die(Tools::jsonEncode($results));
	}
}
