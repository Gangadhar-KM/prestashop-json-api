<?php

class JSONApiCategoryController {

	public function get($f3, $params) {
		$id_category = (int)$params['id_category'];
		$pageNumber = (int)$params['page'];

		$category = new JSONApiCategoryModel($id_category);

		if (!$category) {
			die(Tools::jsonEncode('unreachable category'));
		}
		$json['category'] = $category;

		$categoryProducts = $category->getProducts(Context::getContext()->cookie->id_lang, $pageNumber, 10);
		$json['products'] = $categoryProducts;

		die(Tools::jsonEncode($json));
	}

	public function getAll($f3, $params) {
		die(Tools::jsonEncode(JSONApiCategoryModel::getAll()));
	}
}

?>
