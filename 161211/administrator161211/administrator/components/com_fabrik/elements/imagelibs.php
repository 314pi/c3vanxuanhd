<?php
/**
* @package Joomla
* @subpackage Fabrik
* @copyright Copyright (C) 2005 Rob Clayburn. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fabrik'.DS.'helpers'.DS.'element.php');

/**
 * Renders a list of elements found in a fabrik table
 *
 * @package 	Joomla
 * @subpackage	Articles
 * @since		1.5
 */
class JElementImagelibs extends JElement
{
	/**
	 * Element name
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Imagelibs';

	function fetchElement($name, $value, &$node, $control_name)
	{
		require_once(COM_FABRIK_FRONTEND.DS.'helpers'.DS.'image.php');
		$imageLibs = imageHelper::getLibs();
		if (empty($imageLibs)) {
			return JText::_('NO MAGE LIBRARY FOUND');
		}
		$fullName = ElementHelper::getFullName($this, $control_name, $name);
		return JHTML::_('select.genericlist', $imageLibs, $fullName, 'class="inputbox" size="1" ', 'value', 'text', $value);
	}
}