<?php

namespace JSONApi\Controllers;

class Cms {
	function get() {
		$id_cms = 1;
		$cms = new CMS($id_cms);
		die(msgpack_pack($cms));
	}
}