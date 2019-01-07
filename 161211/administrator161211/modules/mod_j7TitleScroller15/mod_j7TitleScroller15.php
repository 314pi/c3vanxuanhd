<?php
/**
* @version		$Id: mod_j7TitleScroller
* @package		j7TitleScroller Module
* @purpose    set the page title scroll
* @author     Josh Prakash, Nov 2008
* @copyright	Copyright (c) youthpole.com. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* This module is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
 // scroll
$scrollchoice = $params->get( 'scrollchoice', '1');
$scrollcount  = $params->get( 'scrollcount', '4');
 //timers
$scrollspeed  =  $params->get( 'scrollspeed', '250');

require(JModuleHelper::getLayoutPath('mod_j7TitleScroller15'));
?>
