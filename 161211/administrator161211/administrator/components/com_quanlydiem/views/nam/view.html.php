<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );


class QuanlydiemsViewNam extends JView
{
	/**
	 * display method 
	 * @return void
	 **/
	function display($tpl = null)
	{

		$nam		=& $this->get('Data');
		$isNew		= ($nam->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Quản lý năm học' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('nam',		$nam);

		parent::display($tpl);
	}
}
