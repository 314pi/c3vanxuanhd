<?php
/**
* @version		1.0 stable
* @copyright	Copyright (C) 2008 - 2009 style13. All rights reserved.
* @license		GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');

class modUnidateHelper
{
	function day_initialization()
	{
		global $mainframe;
		$lang = &JFactory::getLanguage();
		$date_string = $lang->_strings;
		$day = array();  
		$day[] = $date_string['SUNDAY'];
		$day[] = $date_string['MONDAY'];
		$day[] = $date_string['TUESDAY'];
		$day[] = $date_string['WEDNESDAY'];
		$day[] = $date_string['THURSDAY'];
		$day[] = $date_string['FRIDAY'];
		$day[] = $date_string['SATURDAY'];
		return $day;
	}
	
	function month_initialization()
	{
		global $mainframe;
		$lang = &JFactory::getLanguage();
		$date_string = $lang->_strings;
		$month = array();
		$month[1] = $date_string['JANUARY'];
		$month[2] = $date_string['FEBRUARY'];
		$month[3] = $date_string['MARCH'];
		$month[4] = $date_string['APRIL'];
		$month[5] = $date_string['MAY'];
		$month[6] = $date_string['JUNE'];
		$month[7] = $date_string['JULY'];
		$month[8] = $date_string['AUGUST'];
		$month[9] = $date_string['SEPTEMBER'];
		$month[10] = $date_string['OCTOBER'];
		$month[11] = $date_string['NOVEMBER'];
		$month[12] = $date_string['DECEMBER'];
		return $month;
	}
	
	function getTag($params)
	{
		global $mainframe;
		$tag_type = $params->get('title_type', '0');
		switch ($tag_type) {
    		case 0:
				$tag = 'h4';
				break;
			case 1:
				$tag = 'div';
				break;
			case 2:
				$tag = 'span';
				break;
			case 3:
				$tag = 'p';
				break;
		}
		return $tag;
	}
}
