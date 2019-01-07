<?php
/*------------------------------------------------------------------------
 # Vt NewsTicker  - Version 1.0 - YouTech Club
 # ------------------------------------------------------------------------
 # Copyright (C) 2009-2010 YouTech Club. All Rights Reserved.
 # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 # Author: Ytcvn.Com
 # Websites: http://www.ytcvn.com
 -------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once (dirname(__FILE__).DS.'helper.php');

require_once (dirname(__FILE__) .DS. 'assets' . DS . 'vthemes.php');

jimport("joomla.filesystem.folder");
jimport("joomla.filesystem.file");


$items  = modVThemesHelper::process($params);

/*-- Process---*/

$width = intval($params->get('width', "600"));
$height = intval($params->get('height', "300"));
$thumb_width = intval($params->get('thumb_width', "400"));
$thumb_height = intval($params->get('thumb_height', "300"));


$so = new Vthemes();
$auto = $params->get('play',1);
$so->id = $module->id;
$so->enable = 1;
$so->jquery_enable = $params->get('jquery',1);
$so->web_url = JURI::base();
$so->element_number = $params->get('element_number', 4);	
$so->thumb_height = $params->get('thumb_height', "150px");
$so->thumb_width = $params->get('thumb_width', "120px");
$so->thumb_padding = '5px';
$speed = $params->get('speed',1000);

/*fix module do not item begin*/
$so->scroll = $params->get('scroll',1);
$so->vertical = $params->get('display',0);

$so->enable_navigation     = $params->get('showbutton',1);
$so->enable_summary	  	  = $params->get('showtotal',1);

$so->note = $params->get('note', '');
$so->max_description		=   $params->get('limitcharacter',200);
$so->max_title		=   $params->get('limittitle',25);
$so->resize_folder = JPATH_CACHE.DS.$module->module.DS."images";
$so->url_to_resize = $so->web_url . "cache/".$module->module."/images/";
$so->items = $items;		
			
$items =  $so->process();	



$enable_image 	 	  = $params->get('show_image',1);
$enable_description 	  = $params->get('show_description',1);
$showreadmore 	  = $params->get('showreadmore',1);


$jquery = $params->get("jquery", 0);
$note = $params->get("note", 0);

if ($jquery) {
	JHTML::script('jquery-1.3.2.min.js','modules/'.$module->module.'/assets/');
	
}

if (!defined ('NEWSTICKER')) {
	define ('NEWSTICKER', 1);
	/* Add css*/	
	JHTML::stylesheet('style.css','modules/'.$module->module.'/assets/');
	
	JHTML::script('noconflict.js','modules/'.$module->module.'/assets/');
	/* add JS files*/
	JHTML::script('newsticker.js','modules/'.$module->module.'/assets/');	
}

/* Show html*/
$path = JModuleHelper::getLayoutPath ( 'mod_vt_newsticker');
if (file_exists ( $path )) {
	require ($path);
}


?>
