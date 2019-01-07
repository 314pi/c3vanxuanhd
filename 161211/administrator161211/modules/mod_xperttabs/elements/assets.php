<?php
/**
 * @package Xpert Tabs
 * @version 1.5.1
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
// no direct access
defined('_JEXEC') or die();

class JElementAssets extends JElement {

    var	$_name = 'Assets';

	function fetchTooltip($label, $description, &$node, $control_name, $name) {
		return;
	}
    
	function fetchElement($name, $value, &$node, $control_name)
	{
		$doc =& JFactory::getDocument();
        $doc->addScript(JURI::root(true).'/modules/mod_xperttabs/tmpl/jquery-1.6.1.min.js');
        $doc->addScript(JURI::root(true).'/modules/mod_xperttabs/admin/script.js');
        $doc->addStyleSheet(JURI::root(true).'/modules/mod_xperttabs/admin/style.css');

        return '';
	}
}