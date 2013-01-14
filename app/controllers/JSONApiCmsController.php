<?php

class JSONApiCmsController {
	function get() {
		$id_cms = 1;
		$cms = new CMS($id_cms);
		die(Tools::jsonEncode($cms));
	}
}
