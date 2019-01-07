<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
?>

<form action = "index.php?option=com_quanlydiem&view=quanlydiem" method="post" >

<?php 		

		$nam = $this->nam;
		$hki=$this->hk;
	
		$tieude = $this->tieude;	
?>
		<table width = "550">
		<tr>
		<td align ="center"height ="45">
		<font color ="blue" size ="5"   ><b> HỆ THỐNG TRA ĐIỂM</b> </font>
		</td>
		<tr>
		<tr>
		<td align ="center">
		<font color ="red" size ="4" ><b><?php echo $tieude;?></b> </font>
		</td>
		<tr>
		
		<tr>
		<td align ="center">
		<font color ="red" size ="4" ><b>*****</b> </font>
		</td>
		<tr>
		
		<table>
		<tr>
		<td width = "550"align = "left"colspan=3 height ="45">
		<font color ="blue" size ="4"  ><b>   Mã số học sinh: </b> </font>
		<input type="text" size ="65" name="text" value="" />
		</td>
		</tr>
<!--		
		<tr>
		
		<td width = "70">
		
		</td>
		<td width = "90">
		<input type="radio" name="chon" value="ten" checked />Tìm theo Họ và Tên hoặc Tên
		</td>
		<td width = "50">
		<input type="radio" name="chon" value="lop"  />Tìm theo tên lớp
		</td>

		</tr>
-->		
		<tr >
		<td width ="3"></td>
		<td width = "150">
		<font color ="green" size ="3"  ><b>HỌC KÌ: </b> </font>
		<SELECT name="mahki" SIZE="1">
		
		<OPTION value = "">Học kì</OPTION>
		<?php while ($row = mysql_fetch_array($hki))
		{?>
			<OPTION value = "<?php echo $row['mhk'] ?>"><?php echo $row['hk'] ?></OPTION>
		<?php }?>
		</td>
		<td width = "150">
		<font color ="green" size ="3"  ><b>NĂM HỌC: </b> </font>
		<SELECT name="manam" SIZE="1">
		
		<OPTION value = "">Năm học</OPTION>
		<?php while ($row = mysql_fetch_array($nam))
		{?>
			<OPTION value = "<?php echo $row['mnam'] ?>"><?php echo $row['nam'] ?></OPTION>
		<?php }?>
		</td>
		</tr>
		</table>
		<table>
		<tr> 
		<td width = "500"align = "left"colspan=2 height ="25">
		<b>Lưu ý: </b><i>Bạn phải nhập <b>chính xác mã số học sinh</b>, sau đó chọn <b>Học kì</b> và <b>Năm học</b> để bắt đầu tìm kiếm</i>
		</td>
		</tr>
		
		<tr>
		<td align ="center" width ="500" colspan=2>
		<input type="submit" value="Tra điểm">
		<input type="reset" value="Làm lại" />
		<td>
		<tr>
		</table>
</form> 
<?php 
		$text = $_POST['text'];

		$manam = $_POST['manam'];
		$mahki = $_POST['mahki'];

		
		$chontim=$_POST['chon'];
			
		$text = stripslashes($text);
		$text = trim($text," ");
		
		$db =& JFactory::getDBO();
		if ($text)
	{
		if($chontim=='ten')
		{
		
			$query1 = "SELECT * FROM #__hs where mhs like'%$text' and mnam like'$manam'"; 
		
			$db->setQuery( $query1 );
			$hstten = $db->query();
			$soluong = mysql_num_rows($hstten);
			echo "<font size ='2'><i>Có <b>($soluong)</b> kết quả được tìm thấy với từ khóa <b>($text)</b> trong cơ sở dữ liệu!</i></font> <br />";
			echo "<font size ='3'<b> .............................................................................................................................................</b></font>";
			
			if($soluong)
			{
			echo '<table border ="1" align = "center">';
			echo '<tr>';
			echo '<th width ="200"align = "center"height ="30"> Họ tên </th>';
			echo '<th width = "50"align = "center"> Lớp </th>';
			echo '<th width = "50"align = "center"> Giới tính </th>';
			echo '<th width = "100"align = "center"> Ngày sinh </th>';
			echo '<th width = "200"align = "center"> Nơi sinh </th>';
			echo '<th width = "50"align = "center"> Chi tiết </th>';
			echo '</tr>';
			
			while ($row = mysql_fetch_array($hstten))
				{
			echo '<tr>';
			echo '<td align = "center">'; echo $row["hoten"]; 
			echo '</td>';
			echo '<td align = "center">';echo $row["mlop"] ;
			echo '</td>';
			echo '<td align = "center">';  if ($row["phai"]) echo "Nữ"; else echo "Nam";
			echo '</td>';
			echo '<td align = "center">'; echo $row["namsinh"]; 
			echo '</td>';
			echo '<td align = "center">';echo $row["noisinh"];
			echo '</td>';
			
?>
			
			<td align = "center"> <form action = "index.php?option=com_quanlydiem&view=ketquafull" method="post" >
			<input type="hidden" name="mahs" value="<?php echo $row["mhs"];?>" >
			<input type="hidden" name="mahocki" value="<?php echo $mahki;?>" >

			<input type="hidden" name="manam" value="<?php echo $manam;?>" >
			<input type="submit" value="Chi tiết"> </td>
			</form>
<?php
				}
			}
		}
		else
		
		{

			$query2 = "SELECT * FROM #__hs where mhs like '%$text' and mnam like'$manam'"; 
		
			$db->setQuery( $query2 );
			$hstlop = $db->query();
		
			$soluong = mysql_num_rows($hstlop);
			echo "<font size ='2'><i>Có <b>($soluong)</b> kết quả được tìm thấy với từ khóa <b>($text)</b> trong cơ sở dữ liệu!</i></font> <br />";
			echo "<font size ='3'<b> .............................................................................................................................................</b></font>";
			if ($soluong)
			{
			echo '<table border ="1" align = "center">';
			echo '<tr>';
			echo '<th width ="200"align = "center"height ="30"> Họ tên </th>';
			echo '<th width = "50"align = "center"> Lớp </th>';
			echo '<th width = "50"align = "center"> Giới tính </th>';
			echo '<th width = "100"align = "center"> Ngày sinh </th>';
			echo '<th width = "200"align = "center"> Nơi sinh </th>';
			echo '<th width = "50"align = "center"> Chi tiết </th>';
			echo '</tr>';
			while ($row = mysql_fetch_array($hstlop))
				{
			echo '<tr>';
			echo '<td align = "center">'; echo $row["hoten"]; 
			echo '</td>';
			echo '<td align = "center">';echo $row["mlop"] ;
			echo '</td>';
			echo '<td align = "center">';  if ($row["phai"]) echo "Nữ"; else echo "Nam";
			echo '</td>';
			echo '<td align = "center">'; echo $row["namsinh"]; 
			echo '</td>';
			echo '<td align = "center">';echo $row["noisinh"];
			echo '</td>';
			
?>
			
			<td align = "center"> <form action = "index.php?option=com_quanlydiem&view=ketquafull" method="post" >
			<input type="hidden" name="mahs" value="<?php echo $row["mhs"];?>" >
			<input type="hidden" name="mahocki" value="<?php echo $mahki;?>" >

			<input type="hidden" name="manam" value="<?php echo $manam;?>" >
			<input type="submit" value="Chi tiết"> </td>
			</form>
<?php
				}
			}
		}
?>
		
		</table>
		<?php
	}
		
		?>