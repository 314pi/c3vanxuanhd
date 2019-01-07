<?php
/**
 * Copyright (C) 2010  freakedout (www.freakedout.de)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Set flag that this is a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

class JElementJ2topColorText extends JElement
{
	function fetchElement($name, $value, &$node, $control_name)
	{
		$document	= &JFactory::getDocument();

		// Color Picker
		JHTML::stylesheet( 'picker.css', JURI::root().'plugins/system/J2top/elements/jcp/' );
		$document->addScript(JURI::root().'plugins/system/J2top/elements/jcp/picker.js');

		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );
        $onchange = ( $node->attributes('onchange') ? 'onchange="'.$node->attributes('onchange').'"' : '' );

        $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);

        $background = ' style="background-color: '.$value.'"';

		$html ='<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' '.$background.' '.$onchange.' onfocus="this.style.background=\'#ffffff\';" />';
		
		// Color Picker
		$html .= '<span style="margin-left:10px" onclick="openPicker(\''.$control_name.$name.'\')"  class="picker_buttons">' . JText::_('Pick color') . '</span>';

	return $html;
	}
}
?>
