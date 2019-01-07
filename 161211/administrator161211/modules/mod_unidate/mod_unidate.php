<?php
/**
* @version		1.0 stable
* @copyright	Copyright (C) 2008 - 2009 style13. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require(dirname(__FILE__).DS.'helper.php');

$day = modUnidateHelper::day_initialization();
$month = modUnidateHelper::month_initialization();
$dateformat = $params->get('dateformat', '%day%, %dd% %mm% %yyyy%');

$myday = date("w");
$mymonth = date("n");
$year = date("Y");
$d = date("d");
$search = array('%day%', '%dd%', '%mm%', '%m%', '%yyyy%', '%yy%');
$replace = array($day[$myday], $d, $month[$mymonth], $mymonth, $year, substr($year, 2, -1));


$display_title = $params->get('display_title', '0');
if ($display_title){
	$tag_for_title = modUnidateHelper::getTag($params);
	$title = $params->get('date_title', '');
	//$layout = $params->get('layout', 'default');
	$path = JModuleHelper::getLayoutPath('mod_unidate', 'default');
}else{
	$path = JModuleHelper::getLayoutPath('mod_unidate', 'notitle');
}

if (file_exists($path)) {
	require($path);
}
?>