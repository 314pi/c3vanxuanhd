<?php 
/*------------------------------------------------------------------------
 # Vt NewsTicker  - Version 1.0 - YouTech Club
 # ------------------------------------------------------------------------
 # Copyright (C) 2009-2010 YouTech Club. All Rights Reserved.
 # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 # Author: Ytcvn.Com
 # Websites: http://www.ytcvn.com
 -------------------------------------------------------------------------*/
 
 
defined('_JEXEC') or die('Restricted access');
if (! class_exists("modVThemesHelper") ) { 
require_once (dirname(__FILE__) .DS. 'assets' .DS.'content.class.php');

class modVThemesHelper {
	function process($params) {
		
		$enable_cache 		=   $params->get('cache',1);
		$cachetime			=   $params->get('cache_time',0);
		
		if($enable_cache==1) {			
			$conf =& JFactory::getConfig();
			$cache = &JFactory::getCache($module->module);
			$cache->setLifeTime( $params->get( 'cache_time', $conf->getValue( 'config.cachetime' ) * 60 ) );
			$cache->setCaching(true);
			$cache->setCacheValidation(true);
			$items =  $cache->get( array('modVThemesHelper', 'getList'), array($params));
		} else {
			$items = modVThemesHelper::getList($params);
		}
		
		return $items;		
		
	}
	
	
	function getList ($params) {
	
		$content = new Content();
		$content->is_frontpage = $params->get('frontpage', 2);
		$content->is_cat_or_sec = $params->get('selectradio', 1);
		if ($content->is_cat_or_sec == 0) {
			$content->cat_or_sec_ids = $params->get('sections', '');
		} else {
			$content->cat_or_sec_ids = $params->get('categories', '');
		}
		$content->limit = $params->get('totalarticles', 5);
		$content->sort_order_field = $params->get('sort_order_field', "created");
		$content->type_order = $params->get('sort_order', "ASC");
		
		$items = $content->getList();
		
		return $items;
	}
}
			
} 
?>

