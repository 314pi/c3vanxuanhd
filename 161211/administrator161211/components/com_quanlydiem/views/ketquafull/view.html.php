<?php

jimport( 'joomla.application.component.view');

class QuanlydiemViewKetquafull extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$params = &$mainframe->getParams();
		
		$tieude = $params->def( 'truong',1 );
		$this->assignRef('tieude',		$tieude);
		
		parent::display($tpl);
	}
}
?>
