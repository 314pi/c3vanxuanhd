<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );


class QuanlydiemsViewXl extends JView
{
	/**
	 * display method 
	 * @return void
	 **/
	function display($tpl = null)
	{

		$xl		=& $this->get('Data');
		$isNew		= ($xl->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Quản lý xếp loại học sinh' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('xl',		$xl);

		parent::display($tpl);
	}
}
