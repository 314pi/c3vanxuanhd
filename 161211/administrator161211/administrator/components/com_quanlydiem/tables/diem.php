<?php

defined('_JEXEC') or die('Restricted access');

class TableDiem extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $mhs = null;
	var $mlop = null;
	var $mnam = null;
	var $mhk = null;
	var $mmon = null;
	var $dm_1 = null;
	var $dm_2 = null;
	var $d15_1 = null;
	var $d15_2 = null;
	var $d15_3 = null;
	var $d15_4 = null;
	var $d15_5 = null;
	var $d1t_1 = null;
	var $d1t_2 = null;
	var $d1t_3 = null;
	var $d1t_4 = null;
	var $d1t_5 = null;
	var $dthi = null;
	var $dtb = null;
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableDiem(& $db) {
		parent::__construct('#__diem', 'id', $db);
	}
}
?>
