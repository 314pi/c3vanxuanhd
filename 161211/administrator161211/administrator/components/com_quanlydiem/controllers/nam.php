<?php
defined('_JEXEC') or die();

class QuanlydiemsControllerNam extends QuanlydiemsController
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
		JRequest::setVar( 'view', 'nam' );
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
		$model = $this->getModel('nam');

		if ($model->store($post)) {
			$msg = JText::_( 'Đã lưu năm học!' );
		} else {
			$msg = JText::_( 'Lỗi lưu năm học' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_quanlydiem&view=nams';
		$this->setRedirect($link, $msg);
	}

	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('nam');
		if(!$model->delete()) {
			$msg = JText::_( 'Lỗi: Không thể xóa' );
		} else {
			$msg = JText::_( 'Đã xóa năm học' );
		}

		$this->setRedirect( 'index.php?option=com_quanlydiem&view=nams', $msg );
	}
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Đã hủy bỏ!' );
		$this->setRedirect( 'index.php?option=com_quanlydiem&view=nams', $msg );
	}
	
		
	function import()
	{
	//Cái này của thầy Hiền
	$db =& JFactory::getDBO();
	echo "<form action =\"index.php?option=com_quanlydiem&controller=nam&task=import\" enctype=\"multipart/form-data\" method=\"post\">";  
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
		        $nam=array();
		        $i=0;
		        if ($row[0])
				    {
		                foreach( $row as $item ) 
						    {
		                       $nam[$i]=$item;
			                   $i=$i+1;	
		                     } 
						if( $nam[0]) 
						{
							$query="INSERT INTO #__nam VALUES (null,'$nam[0]','$nam[1]')";
							$db->setQuery($query);
							$db->query();
						}
					}
			}
			$line=$line-1;
	$msg = JText::_( 'Đã cập nhật '.$line.' học kỳ!' );
	$this->setRedirect( 'index.php?option=com_quanlydiem&view=nams', $msg );
		
	}
	}
}

?>
