<?php

jimport( 'joomla.application.component.view');

class QuanlydiemViewQuanlydiem extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$params = &$mainframe->getParams();
		
		$lop = $this->get( 'lop' );
		$mon = $this->get( 'mon' );
		$nam = $this->get( 'namhoc' );
		$hk = $this->get( 'hocki' );
		$this->assignRef( 'lop', $lop );
		$this->assignRef( 'nam', $nam );
		$this->assignRef( 'hk',	$hk );
		$this->assignRef( 'mon',	$mon );
		
		$tieude = $params->def( 'truong',1 );
		$this->assignRef('tieude',		$tieude);

		parent::display($tpl);
	}
}
?>
