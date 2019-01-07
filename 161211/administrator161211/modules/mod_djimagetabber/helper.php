<?php
/**
* @version 1.1.4 stable
* @package DJ Image Tabber
* @subpackage DJ Image Tabber Module
* @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: http://design-joomla.eu
* @author email contact@design-joomla.eu
* @developer Michal Olczyk - michal.olczyk@design-joomla.eu
*
*
* DJ Image Slider is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* DJ Image Slider is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with DJ Image Slider. If not, see <http://www.gnu.org/licenses/>.
*
*/
error_reporting(E_NOTICE);
// no direct access
defined('_JEXEC') or die ('Restricted access');

class modDJImageTabberHelper
{
	function getImagesFromDJImageSlider(&$params) {
		
		if(!is_numeric($max = $params->get('max_images'))) $max = 20;
        $catid = $params->get('category');
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__djimageslider WHERE catid='.$catid.' AND published=1 ORDER BY ordering ASC';
		$db->setQuery($query);
		$slides = $db->loadObjectList();
		
        if(!$params->get('sort_by')) shuffle($slides);
		
		$slides = array_slice($slides, 0, $max);
		
		foreach($slides as $slide){
			$slide->link = modDJImageTabberHelper::getSlideLink($slide->params);
			$slide->description = modDJImageTabberHelper::getSlideDescription($slide, $params->get('limit_desc'));
			$slide->alt = $slide->title;			
			$slide->target = modDJImageTabberHelper::getSlideTarget($slide->link);
		}
		
		return $slides;
    }
	
	function getSlideLink(&$sparams) {
		$slide_params = new JParameter($sparams);
		$link = '';
		$db = &JFactory::getDBO();
		switch($slide_params->get('targetswitch', -1)) {
			case 0:
				if ($menuid = $slide_params->get('target',0)) {
					$menu =& JSite::getMenu();
					$menuitem = $menu->getItem($menuid);
					if($menuitem) switch($menuitem->type) {
						case 'component': 
							$link = JRoute::_($menuitem->link.'&Itemid='.$menuid);
							break;
						case 'url':
						case 'menulink':
							$link = JRoute::_($menuitem->link);
							break;
					}	
				}
				break;
			case 1:
				if($itemurl = $slide_params->get('targeturl',0)) {
					$link = JRoute::_($itemurl);
				}
				break;
			case 2:
				if ($artid = $slide_params->get('id',$slide_params->get('targetart',0))) {
					global $mainframe;
					$link = JRoute::_('index.php?option=com_content&view=article&id='.$artid.'&Itemid='.$mainframe->getItemid($artid));
				}
				break;
			case 3:
				if ($prodid = $slide_params->get('targetvmprod',0)) {
					$query = 'SELECT c.* FROM #__vm_category as c, #__vm_product_category_xref as x WHERE x.product_id='.$prodid.' AND c.category_id=x.category_id LIMIT 1';
					$db->setQuery($query);
					$category = $db->loadObject();
					$prodItemid = modDJImageTabberHelper::getProductItemid($prodid,$category->category_id);
					$link = JRoute::_('index.php?page=shop.product_details&flypage='.$category->category_flypage.'&product_id='.$prodid.'&category_id='.$category->category_id.'&option=com_virtuemart&Itemid='.$prodItemid);
				}
				break;
			case 4:
				if ($prodid = $slide_params->get('targetdjc2prod',0)) {
					$query = 'SELECT * FROM #__djc2_items WHERE id='.$prodid.' LIMIT 1';
					$db->setQuery($query);
					$item = $db->loadObject();
					if($item){
						include_once(JPATH_BASE.DS.'components'.DS.'com_djcatalog2'.DS.'helpers'.DS.'route.php');
						$link = JRoute::_(DJCatalogHelperRoute::getItemRoute($prodid, $item->cat_id));
					}
				}
		}
		
		return $link;
	}
	
	function getSlideDescription($slide, $limit) {
		$sparams = new JParameter($slide->params);
		if($sparams->get('targetswitch')==2 && !$slide->description){ // if article and no description then get introtext as description
			$artid = $sparams->get('id',$sparams->get('targetart',0));
			$db = &JFactory::getDBO();
			$query = 'SELECT * FROM #__content WHERE id='.$artid.' LIMIT 1';
			$db->setQuery($query);
			$article = $db->loadObject();
			if($article) {
				$slide->description = $article->introtext;
			}
		}
		if($sparams->get('targetswitch')==3 && !$slide->description){ // if vm product and no description then get product_s_desc as description
			$prodid = $sparams->get('targetvmprod');
			$db = &JFactory::getDBO();
			$query = 'SELECT * FROM #__vm_product WHERE product_id='.$prodid.' LIMIT 1';
			$db->setQuery($query);
			$prod = $db->loadObject();
			if($prod) {
				$slide->description = $prod->product_s_desc;
				if(!$slide->description) $slide->description = $prod->product_desc;
			}
		}
		if($sparams->get('targetswitch')==4 && !$slide->description){ // if article and no description then get introtext as description
			$prodid = $sparams->get('targetdjc2prod');
			$db = &JFactory::getDBO();
			$query = 'SELECT * FROM #__djc2_items WHERE id='.$prodid.' LIMIT 1';
			$db->setQuery($query);
			$item = $db->loadObject();
			if($item) {
				$slide->description = $item->intro_desc;
				if(!$slide->description) $slide->description = $item->description;
			}
		}
		$desc = strip_tags($slide->description);
		if($limit && $limit < strlen($desc)) {
			$limit = strpos($desc, ' ', $limit);
			$desc = substr($desc, 0, $limit);
			if(preg_match('/[A-Za-z0-9]$/', $desc)) $desc.=' ...';
		} else { // no limit or limit greater than description
			$desc = $slide->description;
		}
		
		$desc = nl2br($desc);

		return $desc;
	}
	
	function getProductItemid($prodid,$catid) {
		$db = &JFactory::getDBO();
		$query = "SELECT id FROM #__menu WHERE link='index.php?option=com_virtuemart' AND params like '%product_id=$prodid%' AND published=1 LIMIT 1";
		$db->setQuery($query);
		$vm_itemid = $db->loadResult();
		if($vm_itemid) return $vm_itemid;
		
		$query = "SELECT id FROM #__menu WHERE link='index.php?option=com_virtuemart' AND params like '%category_id=$catid%' AND published=1 LIMIT 1";
		$db->setQuery($query);
		$vm_itemid = $db->loadResult();
		if($vm_itemid) return $vm_itemid;
		
		$query = "SELECT id FROM #__menu WHERE link='index.php?option=com_virtuemart' AND published=1 LIMIT 1";
		$db->setQuery($query);
		$vm_itemid = $db->loadResult();
		if($vm_itemid) return $vm_itemid;
		
		return 0;
	}

	function getAnimationOptions(&$params) {
		if(!is_numeric($duration = $params->get('duration'))) $duration = 0;
		if(!is_numeric($delay = $params->get('delay'))) $delay = 3000;
		if(!is_numeric($tab_height = $params->get('tab_height'))) $tab_height = 20;
		if(!is_numeric($image_height = $params->get('image_height'))) $image_height = 200;
		$autoplay = $params->get('autoplay');
		$effect = $params->get('effect','fade');
		$options = "{auto: $autoplay, duration: $duration, delay: $delay, tabheight: $tab_height, effect: '$effect', height: $image_height}";
		return $options;
	}
	
	function getSlideTarget($link) {
		
		if(preg_match("/^http/",$link) && !preg_match("/^".str_replace(array('/','.','-'), array('\/','\.','\-'),JURI::base())."/",$link)) {
			$target = '_blank';
		} else {
			$target = '_self';
		}
		
		return $target;
	}
	
	function getStyleSheet(&$params, &$mid) {
		if(!is_numeric($image_width = $params->get('image_width'))) $image_width = 300;
		if(!is_numeric($image_height = $params->get('image_height'))) $image_height = 200;
		if(!is_numeric($tab_width = $params->get('tab_width'))) $tab_width = 240;
		if(!is_numeric($tab_height = $params->get('tab_height'))) $tab_height = 20;
		if(!is_numeric($desc_width = $params->get('desc_width')) || $desc_width > $image_width) $desc_width = $image_width;
		if(!is_numeric($desc_bottom = $params->get('desc_bottom'))) $desc_bottom = 0;
		if(!is_numeric($desc_left = $params->get('desc_horizontal'))) $desc_left = 0;
		
		$css = '
			#djimagetabber_'.$mid.' {
				width: '.($image_width+$tab_width).'px;
				height: '.$image_height.'px;
				position: relative;
				overflow: hidden;
			}
			#djimagetabber_'.$mid.' .djimagetabber-images {
				width: '.($image_width).'px;
				height: '.$image_height.'px;
				overflow: hidden;
				position: relative;
				z-index: 1;
			}
			#djimagetabber_'.$mid.' .djimagetabber-image {
				position: absolute;
				left: 0;
				top: 0;
				width: '.($image_width).'px;
				height: '.$image_height.'px;
				overflow: hidden;
			}
			#djimagetabber_'.$mid.' .djimagetabber-text {
				position: absolute;
				bottom: 10px;
				left: 0px;
				width: '.($image_width-20).'px;
				z-index: 10;
				padding: 10px;
				background: url('.JURI::root().'modules/mod_djimagetabber/tmpl/textbg.png) repeat;
			}
			#djimagetabber_'.$mid.' .djimagetabber-tabs {
				position: absolute;
				overflow: hidden;
				width: '.$tab_width.'px;
				height: '.$image_height.'px;
				left: '.($image_width).'px;
				top: 0;
				z-index: 9;
			}
			#djimagetabber_'.$mid.' #djimagetabber-ind_'.$mid.' {
				width: 21px;
				height: 47px;
				position: absolute;
				left: '.($image_width-20).'px;
				top: 0;
				z-index: 10;
				background: url('.JURI::root().'modules/mod_djimagetabber/tmpl/arrow.png) 0 0 no-repeat;
			}
			#djimagetabber_'.$mid.' .djimagetabber-tab {
				width: '.$tab_width.'px;
				height: '.$tab_height.'px;
				line-height: '.$tab_height.'px;
				display: block;
				cursor: pointer;
			}
			#djimagetabber_'.$mid.' .djimagetabber-tab span {
				line-height: '.$tab_height.'px;
				display: block;
				cursor: pointer;
			}
			#djimagetabber_'.$mid.' .djimagetabber-tab {
				background: url('.JURI::root().'modules/mod_djimagetabber/tmpl/dj_li.png) 0 center no-repeat;
			}
			
			#djimagetabber_'.$mid.' .tab-active {
				background: url('.JURI::root().'modules/mod_djimagetabber/tmpl/dj_li_active.png) 0 center no-repeat;
			}
			
		';
		
		return $css;
	}

}
