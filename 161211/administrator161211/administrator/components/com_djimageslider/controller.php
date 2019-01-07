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

jimport( 'joomla.application.component.controller' );

class DJImageSliderController extends JController
{
	function __construct($config = array())
	{
		parent::__construct($config);

		// Register Extra tasks
		$this->registerTask( 'add',  'display' );
		$this->registerTask( 'edit', 'display' );
		$this->registerTask( 'copy', 'display' );
		$this->registerTask( 'apply', 'save' );
	}

	function display( )
	{
		switch($this->getTask())
		{
			case 'add'     :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view'  , 'item');
				JRequest::setVar( 'edit', false );

				// Checkout the item
				$model = $this->getModel('item');
				$model->checkout();
			} break;
			case 'edit'    :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view'  , 'item');
				JRequest::setVar( 'edit', true );

				// Checkout the item
				$model = $this->getModel('item');
				$model->checkout();
			} break;
			case 'copy'    :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'item');
				JRequest::setVar( 'edit', true );
				JRequest::setVar( 'copy', true);
				
			} break;			
			default : {
				JRequest::setVar( 'view'  , 'items');
				JRequest::setVar( 'layout'  , 'default');
			}
		}
		
		$globalParams = &JComponentHelper::getParams( 'com_djimageslider' );
		$directory			= $globalParams->get('directory', '');

		if (preg_match("/^\//", $directory)) $directory = substr($directory,1);
		if (preg_match("/\/$/", $directory)) $directory = substr($directory,0,strlen($directory)-2);
		if (($directory!='') && !is_dir(JPATH_SITE.DS.'images'.DS.'stories'.DS.$directory)) {
			$msg = JText::_('Wrong Image Path!');
			JError::raiseNotice(0,$msg);
		}

		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];
		$post['description'] = JRequest::getString('description',null,'POST',JREQUEST_ALLOWHTML);
		
		$model = $this->getModel('item');

		if ($model->store($post)) {
			$msg = JText::_( 'Item Saved' );
		} else {
			$msg = JText::_( 'Error Saving Slide' ).': '.$model->getError(true);
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		$data = $model->getData();
		
		$task = JRequest::getCmd('task');
		if ($task == 'save')
			$link = 'index.php?option=com_djimageslider';
		elseif($task == 'apply')
			$link = 'index.php?option=com_djimageslider&task=edit&cid[]='.(int) $data->id;
		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel('item');
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_djimageslider' );
	}


	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('item');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_djimageslider' );
	}


	function unpublish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('item');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_djimageslider' );
	}

	function cancel()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Checkin the item
		$model = $this->getModel('item');
		$model->checkin();

		$this->setRedirect( 'index.php?option=com_djimageslider' );
	}


	function orderup()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$model = $this->getModel('item');
		$model->move(-1);

		$this->setRedirect( 'index.php?option=com_djimageslider');
	}

	function orderdown()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$model = $this->getModel('item');
		$model->move(1);

		$this->setRedirect( 'index.php?option=com_djimageslider');
	}

	function saveorder()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel('item');
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$this->setRedirect( 'index.php?option=com_djimageslider', $msg );
	}
}