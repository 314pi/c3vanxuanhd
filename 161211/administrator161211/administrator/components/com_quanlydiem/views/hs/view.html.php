<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );


class QuanlydiemsViewHs extends JView
{
	/**
	 * display method 
	 * @return void
	 **/
	function display($tpl = null)
	{

		$hs		=& $this->get('Data');
		$isNew		= ($hs->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Quản lý danh sách học sinh' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('hs',		$hs);

		parent::display($tpl);
	}
}
