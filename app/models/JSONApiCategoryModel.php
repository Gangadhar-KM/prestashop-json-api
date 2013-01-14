<?php

class JSONApiCategoryModel extends Category {

	public static function getTree($resultParents, $resultIds, $maxDepth, $id_category = null, $currentDepth = 0) {
		$context = Context::getContext();
		if (is_null($id_category)) {
			$id_category = $context->shop->getCategory();
		}

		$children = array();
		if (isset($resultParents[$id_category]) && count($resultParents[$id_category]) && ($maxDepth == 0 || $currentDepth < $maxDepth)) {
			foreach ($resultParents[$id_category] as $subcat) {
				$children[] = self::getTree($resultParents, $resultIds, $maxDepth, $subcat['id_category'], $currentDepth + 1);
			}
		}
		if (!isset($resultIds[$id_category])) {
			return false;
		}
		$return = array(
			'id' => $id_category,
			'link' => $context->link->getCategoryLink($id_category, $resultIds[$id_category]['link_rewrite']),
			'name' => $resultIds[$id_category]['name'], 'desc'=> $resultIds[$id_category]['description'],
			'children' => $children
		);
		return $return;
	}

	public static function getAll() {
		$context = Context::getContext();
		$maxdepth = 2;
		$id_customer = (int)$context->cookie->id_customer;
		$groups = $id_customer ? implode(', ', Customer::getGroupsStatic($id_customer)) : Configuration::get('PS_UNIDENTIFIED_GROUP');
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite
			FROM `'._DB_PREFIX_.'category` c
			INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_lang` = '.$context->cookie->id_lang.Shop::addSqlRestrictionOnLang('cl').')
			INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (cs.`id_category` = c.`id_category` AND cs.`id_shop` = '.(int)$context->shop->id.')
			WHERE (c.`active` = 1 OR c.`id_category` = '.(int)Configuration::get('PS_HOME_CATEGORY').')
			AND c.`id_category` != '.(int)Configuration::get('PS_ROOT_CATEGORY').'
			'.((int)$maxdepth != 0 ? ' AND `level_depth` <= '.(int)$maxdepth : '').'
			AND c.id_category IN (SELECT id_category FROM `'._DB_PREFIX_.'category_group` WHERE `id_group` IN ('.pSQL($groups).'))
			ORDER BY `level_depth` ASC, '.(Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`').' '.(Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC'));

		$resultParents = array();
		$resultIds = array();

		foreach ($result as &$row) {
			$resultParents[$row['id_parent']][] = &$row;
			$resultIds[$row['id_category']] = &$row;
		}

		$blockCategTree = self::getTree($resultParents, $resultIds, 1);
		unset($resultParents, $resultIds);
		return $blockCategTree;
	}
}
