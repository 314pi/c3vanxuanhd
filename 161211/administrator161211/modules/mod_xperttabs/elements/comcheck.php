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

class JElementComCheck extends JElement {	

	function fetchElement($name, $value, &$node, $control_name)
	{
		if (defined('K2_CHECK') and defined('VM_CHECK')) return;
		
        $k2 = JPATH_SITE.DS."components".DS."com_k2".DS."k2.php";
        
        $closeTable = "</td></tr></tbody></table>";		
        
        $k2Warning = "<div class=\"warning\"><p><strong>K2 Component</strong> Not Found. In order to use the <strong>K2 Content</strong> type, you will need to <a href=\"http://www.getk2.org\" target=\"_blank\">download and install it.</a></p></div>";
        $k2Success = "<div class=\"success\"><p><strong>K2 Component</strong> has been found and is available to use.</p></div>";
        
    	if (!file_exists($k2)) {
            define('K2_CHECK', 0);            
			$html =  $closeTable. $k2Warning;
		} 
        else  {
			define('K2_CHECK', 1);
			$html = $closeTable . $k2Success;
		}
        
        return $html;
	}
}