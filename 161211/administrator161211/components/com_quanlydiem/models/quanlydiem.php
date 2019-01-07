<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );


class QuanlydiemModelQuanlydiem extends JModel
{

	function getLop()
	{
		$db =& JFactory::getDBO();

		$query1 = 'SELECT * FROM #__lop';
		$db->setQuery( $query1 );
		$lop = $db->query();

		return $lop;
	}	
	
	function getHocki()
	{
		$db =& JFactory::getDBO();

		$query2 = 'SELECT * FROM #__hk';
		$db->setQuery( $query2 );
		$hk = $db->query();

		return $hk;
	}	
	
		function getNamhoc()
	{
		$db =& JFactory::getDBO();

		$query3 = 'SELECT * FROM #__nam';
		$db->setQuery( $query3 );
		$nam = $db->query();

		return $nam;
	}	
			
		function getHocsinh()
	{
		$db =& JFactory::getDBO();
		$query4 = 'SELECT * FROM #__hs'; 
		$db->setQuery( $query4 );
		$hs = $db->query();

		return $hs;
	}
			function getMon()
	{
		$db =& JFactory::getDBO();
		$query5 = 'SELECT * FROM #__mon'; 
		$db->setQuery( $query5 );
		$mon = $db->query();

		return $mon;
	}
}
		