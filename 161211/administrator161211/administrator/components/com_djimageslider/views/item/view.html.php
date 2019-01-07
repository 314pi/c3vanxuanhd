<?php
/**
* @version 1.2.4 stable
* @package DJ Image Slider
* @subpackage DJ Image Slider Component
* @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: http://design-joomla.eu
* @author email contact@design-joomla.eu
* @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
*
*
* DJ Image Slider is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* DJ Image Slider is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with DJ Image Slider. If not, see <http://www.gnu.org/licenses/>.
*
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
class DJImageSliderViewItem extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}

		//get the item
		$item =& $this->get('data');

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();
		$globalParams = &JComponentHelper::getParams( 'com_djimageslider' );

		$lists = array();

		//get the item
		$item	=& $this->get('data');
		if(JRequest::getVar('copy',false)) {
			$item->id = 0;
			$item->alias = null;
			$item->title .= ' ('.JText::_('Copy').')';
		}
		$isNew		= ($item->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The item' ), $item->title );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout( $user->get('id') );
		}
		else
		{
			// initialise new record
			$item->published = 1;
			$item->approved 	= 1;
			$item->order 	= 0;
			if(!JRequest::getVar('copy',false)) $item->catid = JRequest::getVar( 'catid', 0, 'post', 'int' );
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, title AS text'
			. ' FROM #__djimageslider'
			. ' WHERE catid = ' . (int) $item->catid
			. ' ORDER BY ordering';

		$lists['ordering'] 			= JHTML::_('list.specificordering',  $item, $item->id, $query );

		// build list of categories
		$lists['catid'] 			= JHTML::_('list.category',  'catid', $option, intval( $item->catid ) );
		// build the html select list
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published );

		//clean item data
		JFilterOutput::objectHTMLSafe( $item, ENT_QUOTES, 'description' );

		$file 	= JPATH_COMPONENT.DS.'models'.DS.'item.xml';
		$params = new JParameter( $item->params, $file );
		
		$directory = $globalParams->get('directory', '');
		
		if (preg_match("/^\//", $directory)) $directory = substr($directory,1);
		if (preg_match("/\/$/", $directory)) $directory = substr($directory,0,strlen($directory)-2);
		if (($directory!='') && !is_dir(JPATH_SITE.DS.'images'.DS.'stories'.DS.$directory)) {
			$directory = '';
		}
			
		$js = '
				function jInsertEditorText(tag, id){
					tag = tag.replace("<img src=\"","");
					var end = tag.indexOf("\"");
					tag = tag.substring(0,end);
					document.adminForm.image.value = tag;
					changeDisplayImage();
				}
		';
		$js .="	function djShowFields(){
					var target = $('paramstargetswitch').getValue();
					var params = new Array();
					params[0] = $('paramstarget').getParent().getParent();
					params[1] = $('paramstargeturl').getParent().getParent();
					params[2] = $('id_id').getParent().getParent();
					params[3] = $('paramstargetvmprod').getParent().getParent();
					params[4] = $('paramstargetdjc2prod').getParent().getParent();
					params[0].setStyle('display','none');
					params[1].setStyle('display','none');
					params[2].setStyle('display','none');
					params[3].setStyle('display','none');
					params[4].setStyle('display','none');
					
					if(target > -1) params[target].setStyle('display','');
				}
				window.addEvent('domready',function(){
					djShowFields();
					$('paramstargetswitch').addEvent('change',djShowFields);
				});
		";
		$doc = & JFactory::getDocument();
		$doc->addScriptDeclaration($js);
		JHTML::_('behavior.modal');
		$lists['image'] = '<div class="button2-left"><div class="image">';
		$lists['image'] .= "<a rel=\"{handler: 'iframe', size: {x: 570, y: 400}}\" href=\"".JURI::base()."index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name=image&folder=".$directory."\" title=\"".JText::_('Image')."\" class=\"modal\">".JText::_('Image')."</a>";
		$lists['image'] .= '</div></div>';
		$directory = '/images/stories/'.$directory;

		$this->assignRef('lists',		$lists);
		$this->assignRef('item',		$item);
		$this->assignRef('params',		$params);

		parent::display($tpl);
	}
}
