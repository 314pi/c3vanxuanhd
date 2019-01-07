<?php

defined('_JEXEC') or die('Restricted access');

class TableHk extends JTable
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
	var $mhk = null;
	var $hk = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableHk(& $db) {
		parent::__construct('#__hk', 'id', $db);
	}
}
?>
