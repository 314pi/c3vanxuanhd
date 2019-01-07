<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );


class QuanlydiemsModelNams extends JModel
{

	var $_data;


	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildQuery()
	{
		$query = ' SELECT * '
			. ' FROM #__nam '
		;

		return $query;
	}

	function getData()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query );
		}

		return $this->_data;
	}

}
