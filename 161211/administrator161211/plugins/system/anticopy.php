<?php

/**
* @package	System - AntiCopy
* @copyright	Copyright (C) 2011 by Galaa (http://www.galaa.mn)
* @license	This extension in released under the GNU/GPL License - http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import library dependencies
jimport( 'joomla.event.plugin' );

class plgSystemAntiCopy extends JPlugin {

	function plgSystemAntiCopy( &$subject, $config ) {
		parent::__construct( $subject, $config );
	}

	function onAfterRender() {

		// Backend
		$app = JFactory::getApplication();
		if($app->isAdmin()) return;

		// Parameter
		$plugin =& JPluginHelper::getPlugin( 'system', 'anticopy' );
 		$params = new JParameter( $plugin->params );

		// Check User
		$utypes_opt = array($params->get( 'utype1' ), $params->get( 'utype2' ), $params->get( 'utype3' ), $params->get( 'utype4' ), $params->get( 'utype5' ), $params->get( 'utype6' ), $params->get( 'utype7' ));
		$utypes = array('Registered', 'Author', 'Editor', 'Publisher', 'Manager', 'Administrator', 'Super Administrator');
		foreach($utypes_opt as $k => $v)
			if(!$v)
				unset($utypes[$k]);
		$user =& JFactory::getUser();

		// Set Permission
		if(in_array($user->usertype, $utypes) || $user->guest) {

			// Prepare Script
			$html = JResponse::getBody();

			// Show Popup Message
			$show_message = $params->get('show_message');
			$message = trim($params->get('message'));
			if($show_message) {
				$comment = "";
			}
			else {
				$comment = "//";
			}

			// Ban Right Click
			$disallow_r_click = $params->get('disallow_r_click');
			if($disallow_r_click) {
				$r_click = " 
<script type=\"text/javascript\">
	function clickExplorer() {
		if( document.all ) {
			${comment}alert('".$message."');
		}
		return false;
	}
	function clickOther(e) {
		if( document.layers || ( document.getElementById && !document.all ) ) {
			if ( e.which == 2 || e.which == 3 ) {
				${comment}alert('".$message."');
				return false;
			}
		}
	}
	if( document.layers ) {
		document.captureEvents( Event.MOUSEDOWN );
		document.onmousedown=clickOther;
	}
	else {
		document.onmouseup = clickOther;
		document.oncontextmenu = clickExplorer;
	}
</script>";
				$html = preg_replace("/<\/head>/", "\n" . $r_click . "\n</head>", $html);
			} // Ban Right Click

			// Disable Select and Copy
			$disallow_select_and_copy = $this->params->get('disallow_copy');
			if($disallow_select_and_copy) {
				// Disable text selection
				$select = "
<script type=\"text/javascript\">
	function disableSelection(target){
	if (typeof target.onselectstart!=\"undefined\") //IE route
		target.onselectstart=function(){return false}
	else if (typeof target.style.MozUserSelect!=\"undefined\") //Firefox route
		target.style.MozUserSelect=\"none\"
	else //Other route (Opera etc)
		target.onmousedown=function(){return false}
	target.style.cursor = \"default\"
	}
</script>";
				$html = preg_replace("/<\/head>/", "\n" . $select . "\n</head>", $html);
				$select = "
<script type=\"text/javascript\">
	disableSelection(document.body)
</script>";
				$html = preg_replace("/<\/body>/", "\n" . $select . "\n</body>", $html);
				$copy = "
<script type=\"text/javascript\">
	/* <![CDATA[ */
		window.addEvent('domready', function() {
			document.body.oncopy = function() {
				${comment}alert('".$message."');
				return false;
			}
		});
	/* ]]> */
</script>";
				$html = preg_replace("/<\/head>/", "\n" . $copy . "\n</head>", $html);
			} // Disable Select and Copy

			// Response
			JResponse::setBody($html);
			return true;
		} // Set Permission

	} // onAfterRender

} // class

?>
