<?php
/**
 * @version             $Id: jquery.php revision date lasteditedby $
 * @package             Joomla
 * @subpackage  Content
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license             GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Example system plugin
 */
class plgCoreJoomlaJQuery extends JPlugin{
	/**
	 * Constructor
	 * 
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgCoreJoomlaJQuery( &$subject, $config ){
		parent::__construct( $subject, $config );
	}

	/**
	 * Do something onAfterInitialise 
	 */
	function onCallIncludeJQuery($params){
		static $init_cjquery_load = false;
		if($init_cjquery_load == true){
			return false;
		}
		$plugin =& JPluginHelper::getPlugin('corejoomla', 'jquery');
		$pluginParams = new JParameter( $plugin->params );
		$document = &JFactory::getDocument();
		$document->setGenerator($document->getGenerator().'; Joomla jQuery plugin by http://www.corejoomla.com');
		$included = JFactory::getApplication()->get('jquery', false);
		
		switch ($pluginParams->get('use_cdn')) {
			case '1':
				if(in_array('jquery', $params) || $pluginParams->get('jquery')){
					
					if(!isset($included) || !$included){
						$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js');
						JFactory::getApplication()->set('jquery', true);
					}
					$document->addScript(JURI::root( true ).'/plugins/corejoomla/jquery/jquery.noconflict.js');
					
					if(in_array('jqueryui', $params) || $pluginParams->get('jqueryui')){
						$theme = trim($pluginParams->get('jqueryui-theme'));
						$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js');
						$document->addStyleSheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/'.$theme.'/jquery-ui.css');
					}
					
					if(in_array('jqueryform', $params) || $pluginParams->get('jqueryform')){
						$document->addScript(JURI::root( true ).'/plugins/corejoomla/jquery/jquery.form.min.js');
					}
					
					if(in_array('jqueryvalidate', $params) || $pluginParams->get('jqueryvalidate')){
						$document->addScript('http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js');
					}
				}
				break;
			default:
				if(in_array('jquery', $params) || $pluginParams->get('jquery')){
					
					if(!isset($included) || !$included){
						$document->addScript(JURI::root( true ).'/plugins/corejoomla/jquery/jquery-1.5.1.min.js');
						JFactory::getApplication()->set('jquery', true);
					}
					
					if(in_array('jqueryui', $params) || $pluginParams->get('jqueryui')){
						$theme = trim($pluginParams->get('jqueryui-theme'));
						$document->addScript(JURI::root( true ).'/plugins/corejoomla/jquery/jquery-ui-1.8.11.custom.min.js');
						$document->addStyleSheet(JURI::root( true ).'/plugins/corejoomla/jquery/themes/'.$theme.'/jquery-ui-1.8.11.custom.css');
					}
					
					if(in_array('jqueryform', $params) || $pluginParams->get('jqueryform')){
						$document->addScript(JURI::root( true ).'/plugins/corejoomla/jquery/jquery.form.min.js');
					}
					
					if(in_array('jqueryvalidate', $params) || $pluginParams->get('jqueryvalidate')){
						$document->addScript(JURI::root( true ).'/plugins/corejoomla/jquery/jquery.validate.min.js');
					}
				}
				break;
		}
		$init_cjquery_load = true;
	}
}