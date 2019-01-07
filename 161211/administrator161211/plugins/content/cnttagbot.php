<?php

/**********************************************************************************
 * Messiah's CntTagBot
 * @version 1.0
 * @copyright (c) 2006 The Inevitable One
 * @license GNU GPL (http://www.gnu.org/licenses/gpl.txt)
 * @author http://www.theinevitabledossier.com/cnttagbot.html
 * 
 * Version History:
 *
 * 1.0 Initial verion including 'cnstr' & 'daycnt' tags
 *
 **********************************************************************************/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

$mainframe->registerEvent( 'onPrepareContent', 'botCntTagBot' );

function botCntTagBot( &$row, &$params, $page=0 ) {

	// simple performance check to determine whether bot should process further
	if ( JString::strpos( $row->text, '{ctb|' ) === false ) {
		return true;
	}

	// Add Content Tag Bot Stylesheet
	echo '<link rel=stylesheet href="plugins/content/cnttagbot/cnttagbot.css" type="text/css" media=screen>';


	// Get Plugin info
	$plugin =& JPluginHelper::getPlugin('content', 'cnttagbot');

	// Get the plugin parameters
	$pluginParams = new JParameter( $plugin->params );
	$cnstrtxt = $pluginParams->get( 'cnstrtxt' );

	// Set the expression to be matched
	$regex = "#\{ctb\|(.*?)\}#s";


	// Fetch rows and loop words for matched
	preg_match_all( $regex, $row->text, $matches );
	for($x=0; $x<count($matches[0]); $x++) {

	// Raw/Word loop begins here!

	$match=$matches[1][$x];

	// If $match contains "|" split in two
	$parse = split('[\|]', $match);
	if (empty($parse[0])) {
		$replace = '<strong><font color=red>General CntTagBot syntax fault: '.$match.'}</font></strong>';
	} else {
		// cnstr - Under Construction Tag
		if ($parse[0] == 'cnstr') {
			$replace = '<div class="ambox"><table class="ambox ambox-cnstr"><tr><td class="mbox-image"><img alt="'.$cnstrtxt.' '.$parse[1].'" src="/plugins/content/cnttagbot/cnstr.gif" width="42" height="35" border="0" /></td><td class="mbox-text">'.$cnstrtxt.'<br>'.$parse[1].'</td></tr></tbody></table></div>';

		// cnstr - Day counter tag
		} elseif ($parse[0] == 'daycnt') {
			$year = $parse[2];
			$month = $parse[3];
			$day = $parse[4];
			if ($parse[1] == 'since') {
				$replace = ((int)((mktime (0,0,0,$month,$day,$year) - time(void))/86400) * - 1 );
			} elseif ($parse[1] == 'to') {
				$replace = ((int)((mktime (0,0,0,$month,$day,$year) - time(void))/86400) );
			} else {
				$replace = '<strong><font color=red>Syntax Fault {ctb|daycnt|to/since|year|month|day}</font></strong>';
			}
		} else {
			$replace = '<strong><font color=red>Syntax Fault {ctb|'.$match.'}</font></strong>';
		}
	}


    // It's time to return the code...
    $row->text = str_replace($matches[0][$x], $replace, $row->text);
    }
}
?>
