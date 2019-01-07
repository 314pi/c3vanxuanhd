<?php
/*moving text Plugin

*@author Sakis Terzis @ breakDesigns.net

* @copyright	Copyright (C) 2008 breakDesigns.net

 * @license		GNU/GPL, see LICENSE.php

 * Joomla! is free software. This version may have been modified pursuant

 * to the GNU General Public License, and as distributed it includes or

 * is derivative of works licensed under the GNU General Public License or

 * other free or open source software licenses.

 * See COPYRIGHT.php for copyright notices and details.
 * Updated version by Martin Rose - toughtomato.com

*/


defined('_JEXEC') or die ('restricted access');

$mainframe->registerEvent( 'onBeforeDisplayContent', 'plg_moveText');



function plg_moveText(&$row){
global $mainframe, $loadJWTSscripts;
$mosConfig_live_site = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();

if (preg_match_all("/{text=.+?}/", $row->text, $matches, PREG_PATTERN_ORDER) > 0) {
	
	foreach ($matches[0] as $match) {
						$match = str_replace("{text=", "", $match);
						$match = str_replace("}", "", $match);
            $row->text = str_replace( "{text=".$match."}", "<div id=\"maskBlock\"><span class=\"movingObj\">".$match."</span></div>", $row->text );					
            $row->text = str_replace( "{/text}", "", $row->text );
						//$row->text = str_replace("&nbsp;","",$row->text);
						
					}
	
$plugin =& JPluginHelper::getPlugin('content', 'plg_moveText');
		$pluginParams = new JParameter( $plugin->params );
		
	$mskWidth=$pluginParams->get('mskWidth', '300');
	$speed=$pluginParams->get('speed', '2');
  $time=$pluginParams->get('time', '80');
		
	if(!$loadJWTSscripts) {
			$loadJWTSscripts=1;
			$header="<!--breakDesigns/plugin/movingText/-->
			<link rel=\"stylesheet\" href=\"$mosConfig_live_site/plugins/content/plugin_moveText/moveText.css\"/>	
			<script type=\"text/javascript\">var maskwidth=".$mskWidth.";</script>
			<script type=\"text/javascript\">var speed=".$speed.";</script>					
      <script type=\"text/javascript\">var time=".$time.";</script>					
			<script type=\"text/javascript\" src=\"$mosConfig_live_site/plugins/content/plugin_moveText/moveText.js\"></script>";								
																	}
	
	// cache check
			if($mainframe->getCfg('caching') && ($option=='com_frontpage' || $option=='')) {
				echo $header;
			} else {
				$mainframe->addCustomHeadTag($header);
			}
			
}

}
?>