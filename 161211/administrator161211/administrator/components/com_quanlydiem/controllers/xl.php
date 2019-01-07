<?php
defined('_JEXEC') or die();

class QuanlydiemsControllerXl extends QuanlydiemsController
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
		JRequest::setVar( 'view', 'xl' );
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
		$model = $this->getModel('xl');

		if ($model->store($post)) {
			$msg = JText::_( 'Đã lưu xếp loại học sinh!' );
		} else {
			$msg = JText::_( 'Lỗi lưu xếp loại học sinh' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_quanlydiem&view=xls';
		$this->setRedirect($link, $msg);
	}

	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('xl');
		if(!$model->delete()) {
			$msg = JText::_( 'Lỗi: Không thể xóa' );
		} else {
			$msg = JText::_( 'Đã xóa xếp loại học sinh' );
		}

		$this->setRedirect( 'index.php?option=com_quanlydiem&view=xls', $msg );
	}
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Đã hủy bỏ!' );
		$this->setRedirect( 'index.php?option=com_quanlydiem&view=xls', $msg );
	}
	
		
	function import()
	{
	//Cái này của thầy Hiền
	$db =& JFactory::getDBO();
	echo "<form action =\"index.php?option=com_quanlydiem&controller=xl&task=import\" enctype=\"multipart/form-data\" method=\"post\">";  
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
		        $xl=array();
		        $i=0;
		        if ($row[0])
				    {
		                foreach( $row as $item ) 
						    {
		                       $xl[$i]=$item;
			                   $i=$i+1;	
		                     } 
						if($xl[0]) 
						{
							$queryxl="INSERT INTO #__xl VALUES (null,'$xl[0]','$xl[1]','$xl[2]','$xl[3]','$xl[4]','$xl[5]','$xl[6]','$xl[7]','$xl[8]','$xl[9]','$xl[10]')";
							$db->setQuery($queryxl);
							$db->query();
						}
					}
			}
			if($line!=0) $line=$line-1;
	$msg = JText::_( 'Đã cập nhật '.$line.' xếp loại học sinh!' );
	$this->setRedirect( 'index.php?option=com_quanlydiem&view=xls', $msg );
		
	}
	}
}

?>
