<?php
/**
* @version		$Id: helper.php 9764 2007-12-30 07:48:11Z ircmaxell $
* @package		mod_customcontent
* @copyright		Copyright (C) 2008 Ian MacLennan. All rights reserved.
* @copyright		Portions Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class modCustomContentHelper
{
	function renderItem(&$item, &$params, &$access)
	{
		global $mainframe;

		$user 	=& JFactory::getUser();

		$item->text 	= $item->introtext;
		$item->groups 	= '';
		$item->readmore = (trim($item->fulltext) != '');
		$item->metadesc = '';
		$item->metakey 	= '';
		$item->access 	= '';
		$item->created 	= '';
		$item->modified = '';

		if (!$params->get('image')) {
			$item->text = preg_replace( '/<img[^>]*>/', '', $item->text );
		}

		$dispatcher	   =& JDispatcher::getInstance();		
		JPluginHelper::importPlugin('content');
		$results = $dispatcher->trigger('onPrepareContent', array (& $item, & $params ));

		require(JModuleHelper::getLayoutPath('mod_customcontent', '_item'));
	}

	function getItem(&$params, &$access)
	{
		global $mainframe;

		$db 	=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		$aid	= $user->get('aid', 0);

		$id 	= (int) $params->get('id', 0);

		$contentConfig	= &JComponentHelper::getParams( 'com_content' );

		jimport('joomla.utilities.date');
		$date = new JDate();
		$now = $date->toMySQL();

		$nullDate = $db->getNullDate();

		// query to get article
		$query = 'SELECT a.*' .
			' FROM #__content AS a' .
			' WHERE a.state = 1 ' .
			' AND a.id = '. (int) $id .
			' AND a.access <= ' .(int) $aid .
			' AND (a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' ) ' .
			' AND (a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )';
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}
}
