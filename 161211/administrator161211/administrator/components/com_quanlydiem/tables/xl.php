<?php

defined('_JEXEC') or die('Restricted access');

class TableXl extends JTable
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
	
	var $dtbm = null;
	var $hluc = null;
	var $hkiem = null;
	var $snncp = null;
	var $snnkp = null;
	var $dhieu = null;
	var $nhanxet = null;
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableXl(& $db) {
		parent::__construct('#__xl', 'id', $db);
	}
}
?>
