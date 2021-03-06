<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');
class QuanlydiemsModelXl extends JModel
{
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__xl '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->mhs = null;
			$this->_data->mlop= null;
			$this->_data->mnam = null;
			$this->_data->mhk = null;
			
			$this->_data->dtbm = null;
			$this->_data->hluc = null;
			$this->_data->hkiem = null;
			$this->_data->snncp = null;
			$this->_data->snnkp = null;
			$this->_data->dhieu = null;
			$this->_data->nhanxet= null;
		}
		return $this->_data;
	}

	function store()	{
		$row =& $this->getTable();

		$data = JRequest::get( 'post' );

		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
	
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}

		return true;
	}

	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids ))		{
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}						
		}
		return true;
	}
			

}
?>
