<?php
/**
* @version 1.0
* @package JDownloads
* @copyright (C) 2009 www.jdownloads.com
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* Editor button for jDownloads content plugin 1.9 or newer 
*
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );

class plgButtonjdownload extends JPlugin
{
	function plgButtonjdownload(&$subject, $config) {
		parent::__construct($subject, $config);
	}

	function onDisplay($name) {
		global $mainframe;

		$document = & JFactory::getDocument();
        $plugin =& JPluginHelper::getPlugin('system', 'jdownloads_system_plugin');
        // get params
        $params = new JParameter( $plugin->params );
        $access = $params->get( 'access', 1 );
        $lang = & JFactory::getLanguage();
        $lang->load('plg_editors-xtd_jdownload', JPATH_ADMINISTRATOR);
		$template = $mainframe->getTemplate();
        $document->addStyleSheet( JURI::root().'plugins/editors-xtd/jdownload.css', 'text/css', null, array() ); 
		JHTML::_('behavior.modal');
        $user = &JFactory::getUser(); 
        
        $link = 'index.php?option=com_jdownloads&amp;task=editor.insert.file&amp;tmpl=component&amp;e_name='.$name;
        
		$button = new JObject();
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_('JLIST_BUTTON_PLG_CAT_BUTTON_TEXT'));
		$button->set('name', 'jdownload');
		$button->set('options', "{handler: 'iframe', size: {x: 650, y: 550}}");
		if ($user->aid != 2) return null;
        if ($access == 0 && $user->usertype != 'Super Administrator' && $user->usertype != 'Administrator') {
			$button = null;
		}
		return $button;
	}
}
?>