<?php
defined('_JEXEC') or die();

class QuanlydiemsControllerHs extends QuanlydiemsController
{
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit');
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'hs' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('hs');

		if ($model->store($post)) {
			$msg = JText::_( 'Đã lưu học sinh!' );
		} else {
			$msg = JText::_( 'Lỗi lưu học sinh' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_quanlydiem&view=hss';
		$this->setRedirect($link, $msg);
	}

	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('hs');
		if(!$model->delete()) {
			$msg = JText::_( 'Lỗi: Không thể xóa' );
		} else {
			$msg = JText::_( 'Đã xóa học sinh' );
		}

		$this->setRedirect( 'index.php?option=com_quanlydiem&view=hss', $msg );
	}
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Đã hủy bỏ!' );
		$this->setRedirect( 'index.php?option=com_quanlydiem&view=hss', $msg );
	}
	
		
	function import()
	{
	//Cái này của thầy Hiền
	$db =& JFactory::getDBO();
	echo "<form action =\"index.php?option=com_quanlydiem&controller=hs&task=import\" enctype=\"multipart/form-data\" method=\"post\">";  
	echo "<center>Chọn files Excel XML :";  
	echo "<input type=\"file\" name=\"ufile\" /> ";  
	echo "<input type=\"submit\" value=\"Import\" />";  

	if ( $_FILES['ufile']['tmp_name'] )  
  {
		$dom = DOMDocument::load($_FILES['ufile']['tmp_name']);  
	    $rows = $dom->getElementsByTagName( 'Row' );  
		$data = array();
		$tde=array();
		$line=0;
		
		foreach ($rows as $row)
		    { 
		       $cells = $row->getElementsByTagName( 'Cell' );  
		       $datarow = array();  
			   foreach ($cells as $cell)
			      {  
	     		    if ($line==0){
	        		                $tde[]=$cell->nodeValue;
	     		                 }
					else{
	     			      $datarow []= $cell->nodeValue;
	     		        } 
		 	       }  
		        $data []= $datarow;  
		        $line=$line+1;      
		    }

foreach( $data as $row )
	        {  
		        $hs=array();
		        $i=0;
		        if ($row[0])
				    {
		                foreach( $row as $item ) 
						    {
		                       $hs[$i]=$item;
			                   $i=$i+1;	
		                     } 
						if($hs[0]) 
						{
							$queryhs="INSERT INTO #__hs VALUES (null,'$hs[0]','$hs[1]','$hs[2]','$hs[3]','$hs[4]','$hs[5]','$hs[6]')";
							$db->setQuery($queryhs);
							$db->query();
						}
					}
			}
			if($line!=0) $line=$line-1;
	$msg = JText::_( 'Đã cập nhật '.$line.' học sinh!' );
	$this->setRedirect( 'index.php?option=com_quanlydiem&view=hss', $msg );
		
	}
	}
}

?>
