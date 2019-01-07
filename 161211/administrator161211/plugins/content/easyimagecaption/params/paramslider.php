<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Parameter slider
 */

class JElementParamslider extends JElement
{
	var	$_name = 'Paramslider';

	function fetchTooltip($label, $description, &$node, $control_name, $name) {
		return '&nbsp;';
	}

	function fetchElement($name, $value, &$node, $control_name)
	{
		$title = $node->_attributes['default'];
        $html = '</td></tr></table>';
        $html .= JPaneSliders::endPanel();
        $html .= JPaneSliders::startPanel(JText::_($title), str_replace(' ', '', $title));
        $html .= '<table width="100%" class="paramlist admintable" cellspacing="1">';
        $html .= '<tr><td class="paramlist_key"></td>';
        $html .= '<td class="paramlist_value">';

        return $html;
	}
}
?>