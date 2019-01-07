<?php
/**
* @version		$Id: mod_filterednews.php 2009 vargas $
* @package		Joomla
* @license		GNU/GPL, see LICENSE.php
*/

defined('_JEXEC') or die('Restricted access');

global $filterednews_id;

if ( !$filterednews_id ) : $filterednews_id =1; endif;

require_once (dirname(__FILE__).DS.'helper.php');

$list = modFilteredNewsHelper::getFN_List($params);

if ( !count($list ) ) return;

if ( $alt_title = $params->get('alt_title', '') ) echo '<h3>' . $alt_title . '</h3>';

$layout = $params->get('layout', 'default');

if ( $layout != 'default' ) {
	modFilteredNewsHelper::addFN_CSS($params,$layout,$filterednews_id);
}

require(JModuleHelper::getLayoutPath('mod_filterednews', $layout));

$filterednews_id++;