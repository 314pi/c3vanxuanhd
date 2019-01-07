<?php

defined('_JEXEC') or die('Restricted access');

class TableNam extends JTable
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
	var $mnam = null;
	var $nam = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableNam(& $db) {
		parent::__construct('#__nam', 'id', $db);
	}
}
?>
