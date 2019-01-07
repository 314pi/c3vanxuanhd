<?php
/**
 * @version 	$Id: mod_jdowloadsfilelist.php v1.0 28-01-2011 Tux Merlín$
 * @package     Joomla
 * @copyright   Copyright (C) 2011 Miguel Tuyaré. All rights reserved.
 * @contact		http://www.tuxmerlin.com.ar - developer@tuxmerlin.com.ar
 * @license     GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * IMPORTANT!
 * Terms of Use: 
 * If you want to remove the link below it, make a donation at http://www.tuxMerlin.com.ar
 *
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once ( dirname(__FILE__) . DS . 'helper.php' );

// Pagination accordion if selected!!
$pag 	 = $params->get('pagination');
($pag == '1') ? modjdowloadsfilelistHelper::createHeader($params) : '';

// Create output
$catids	 = $params->get('catid');
$cats = explode(',',$catids);
$html = '';
foreach ($cats as $cat){	
	$catlist 	= modjdowloadsfilelistHelper::getCategoryData($cat);			
	if ($catlist->cat_id != 0){
		$filelist 	= modjdowloadsfilelistHelper::getCategoryFiles($catlist->cat_id);		
		$itemid		= modjdowloadsfilelistHelper::CalcItemid();	
		if ($itemid == ''){
			$html   = '<div class="jdfilelist" style="border: '.$pborder.';padding: '.$psepa.'px;">';
			$html  .= '<p><span style="color:#FF0000">WARNING!! - NO EXIST JDOWNLOADS COMPONENT</span></p><p>jDownloads File List Module not work</p><p>Install first -> <a href="http://www.jdownloads.com">jDownloads</a></div>';				
		} else {
			$html	   .= modjdowloadsfilelistHelper::createHTML($catlist,$filelist,$params,$itemid);
		}		
	}
}	
require(JModuleHelper::getLayoutPath('mod_jdowloadsfilelist'));
?>