<?php
defined('_JEXEC') or die();

class QuanlydiemsControllerDiem extends QuanlydiemsController
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
		JRequest::setVar( 'view', 'diem' );
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
		$model = $this->getModel('diem');

		if ($model->store($post)) {
			$msg = JText::_( 'Đã lưu điểm!' );
		} else {
			$msg = JText::_( 'Lỗi lưu điểm' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_quanlydiem&view=diems';
		$this->setRedirect($link, $msg);
	}

	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('diem');
		if(!$model->delete()) {
			$msg = JText::_( 'Lỗi: Không thể xóa' );
		} else {
			$msg = JText::_( 'Đã xóa điểm' );
		}

		$this->setRedirect( 'index.php?option=com_quanlydiem&view=diems', $msg );
	}
	

	function cancel()
	{
		$msg = JText::_( 'Đã hủy bỏ!' );
		$this->setRedirect( 'index.php?option=com_quanlydiem&view=diems', $msg );
	}
	
		
	function import()
	{
	//Cái này của thầy Hiền
	$db =& JFactory::getDBO();
	echo "<form action =\"index.php?option=com_quanlydiem&controller=diem&task=import\" enctype=\"multipart/form-data\" method=\"post\">";  
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
		        $diem=array();
		        $i=0;
		        if ($row[0])
				    {
		                foreach( $row as $item ) 
						    {
		                       $diem[$i]=$item;
			                   $i=$i+1;	
		                     } 
						if( $diem[0]) 
						{
							$querydiem="INSERT INTO #__diem VALUES (null,'$diem[0]','$diem[1]','$diem[2]','$diem[3]','$diem[4]','$diem[5]','$diem[6]','$diem[7]','$diem[8]','$diem[9]','$diem[10]','$diem[11]','$diem[12]','$diem[13]','$diem[14]','$diem[15]','$diem[16]','$diem[17]','$diem[18]')";
							$db->setQuery($querydiem);
							$db->query();
						}
					}
			}
			if($line!=0) $line=$line-1;
	$msg = JText::_( 'Đã cập nhật '.$line.' điểm!' );
	$this->setRedirect( 'index.php?option=com_quanlydiem&view=diems', $msg );
		
	}
	}
}

?>
