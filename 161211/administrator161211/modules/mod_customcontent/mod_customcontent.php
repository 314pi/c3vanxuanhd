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

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

// Disable edit ability icon
$access = new stdClass();
$access->canEdit	= 0;
$access->canEditOwn = 0;
$access->canPublish = 0;

$item = modCustomContentHelper::getItem($params, $access);

// check if any results returned
if (empty( $item )) {
	return;
}

if ($params->get('load_mootools', 0)) {
	JHTML::_( 'behavior.mootools' );
}

$layout = $params->get('layout', 'default');
$layout = JFilterInput::clean($layout, 'word');
$path = JModuleHelper::getLayoutPath('mod_customcontent', $layout);
if (file_exists($path)) {
	require($path);
}
