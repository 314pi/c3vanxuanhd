<?php
/**
* @version 1.2.2 stable
* @package DJ Image Slider
* @subpackage DJ Image Slider Component
* @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: http://design-joomla.eu
* @author email contact@design-joomla.eu
* @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementDJC2Product extends JElement
{
	var	$_name = 'DJC2Product';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db = &JFactory::getDBO();
		$language =& JFactory::getLanguage();
		$language->load('com_djimageslider');
		
		$query = "SELECT id, name FROM #__djc2_categories "
				."WHERE published=1 ORDER BY name ASC";
		$db->setQuery( $query );
		$categories = $db->loadObjectList();		
		
		$query = "SELECT p.id, p.name AS text, c.id as category_id "
				."FROM #__djc2_items p, #__djc2_categories c "
				."WHERE p.published=1 AND p.cat_id=c.id AND c.published=1 "
				."ORDER BY c.name, p.name ASC"; 
		$db->setQuery( $query );
		$products = $db->loadObjectList();
		
		if(!count($categories) || !count($products)) $html = '<div id="'.$control_name.$name.'">'.JText::_('NO PRODUCTS').'</div>';
		else {
			foreach($products as $product){
				$options[$product->category_id][] = $product;
			}
			foreach($categories as $category) {
				$groups[] = JHTMLSelect::optgroup($category->name);
				if(is_array(@$options[$category->id]))
				foreach($options[$category->id] as $option){
					$groups[] = JHTMLSelect::option($option->id, $option->text);
				}
			}
			$html = JHTMLSelect::genericList($groups, ''.$control_name.'['.$name.']', 'class="inputbox" size="10" style="width: 95%"', 'value', 'text', $value, $control_name.$name);
		}
		
		return $html;
	}
}
