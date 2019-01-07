<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );


class QuanlydiemsViewDiem extends JView
{
	/**
	 * display method 
	 * @return void
	 **/
	function display($tpl = null)
	{

		$diem		=& $this->get('Data');
		$isNew		= ($diem->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Quản lý điểm trung bình' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('diem',		$diem);

		parent::display($tpl);
	}
}
