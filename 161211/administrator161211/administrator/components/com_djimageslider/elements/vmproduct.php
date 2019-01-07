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

class JElementVmproduct extends JElement
{
	var	$_name = 'VMProduct';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db = &JFactory::getDBO();
		$language =& JFactory::getLanguage();
		$language->load('com_djimageslider');
		
		$query = "SELECT category_id as id, category_name as name FROM #__vm_category "
				."WHERE category_publish='Y' ORDER BY category_name ASC";
		$db->setQuery( $query );
		$categories = $db->loadObjectList();		
		
		$query = "SELECT p.product_id AS id, p.product_name AS text, c.category_id "
				."FROM #__vm_product p, #__vm_category c, #__vm_product_category_xref x "
				."WHERE p.product_publish='Y' AND p.product_parent_id=0 AND p.product_id=x.product_id AND c.category_id=x.category_id AND c.category_publish='Y' "
				."ORDER BY c.category_name, p.product_name ASC"; 
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
