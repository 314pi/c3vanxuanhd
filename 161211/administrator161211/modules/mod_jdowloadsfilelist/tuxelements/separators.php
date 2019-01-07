<?php
/**
* @version		1.0.0 - Basic
* @package		Tux Extensions Elements
* @advert		Only for use with Tux Merlín Extensions. Basic version for free extensions!
* @copyright	Copyright (C) 2010 Miguel Tuyaré. All rights reserved.
* @contact		developer@tuxmerlin.com.ar - http://www.tuxmerlin.com.ar
* @license		GNU/GPL 3.0
* Tux Extensions Basic Elements is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* More information at http://www.gnu.org/copyleft/gpl.html 
*/
defined('_JEXEC') or die();
class JElementSeparators extends JElement {
	var   $_name = 'separators';
	function fetchElement($name, $value, &$node, $control_name)
	{
	$document	= & JFactory::getDocument();
	$html ='<div style="margin-left:-140px;line-height:15px;background:#000080;color:#cccccc;font-weight:bold;padding:2px;text-align:center">:: '.JText::_($value).' ::</div>';
	return $html;
	}
}
?>