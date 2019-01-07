<?php

defined('_JEXEC') or die('Restricted access');

class TableHs extends JTable
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
	var $mnam = null;
	var $hoten = null;
	var $mlop = null;
	var $phai = null;
	var $namsinh = null;
	var $noisinh = null;
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableHs(& $db) {
		parent::__construct('#__hs', 'id', $db);
	}
}
?>
