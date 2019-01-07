<?php
defined('_JEXEC') or die();

class QuanlydiemsControllerQuanlydiem extends QuanlydiemsController
{
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( ,'add'  , 	'edit');
	}

	/**
	 * display the edit form
	 * @return void
	 */
	
}

?>
