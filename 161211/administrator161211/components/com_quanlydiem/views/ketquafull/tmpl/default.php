<?php 
defined('_JEXEC') or die('Restricted access'); ?>
<?php 		
		
	
		$mhss=$_POST['mahs'];
		$mhocki=$_POST['mahocki'];
		$manam=$_POST['manam'];
		
		$tieude = $this->tieude;	
?>

		<table width = "550">
		<tr>
		<td align ="center"height ="45">
		<font color ="blue" size ="5"   ><b>  HỆ THỐNG TRA ĐIỂM</b> </font>
		</td>
		</tr>
		<tr>
		<td align ="center">
		<font color ="red" size ="4" ><b><?php echo $tieude;?></b> </font>
		</td>
		</tr>
		<tr>
		<td align ="center">
		<font color ="red" size ="4" ><b>*****</b> </font>
		</td>
		</tr>
		</table>
<?php		
			
			$db =& JFactory::getDBO();
	
			$query2 = "SELECT * FROM #__hs where mhs ='$mhss'"; 
			$db->setQuery( $query2 );
			$hs = $db->query();	
			
			while ($row = mysql_fetch_array($hs))
	{
			$hoten=$row['hoten'];
		
			echo '<table>';
			echo '<tr>';
			
			echo '<td width ="300"><font color ="blue" size ="2"><b>    Họ và tên: </b> </font> ';
			echo '<font color ="red" size ="3"><b>';  echo $row['hoten'];  '</b> </font>';
			echo '</td>';
			echo '<td width ="300"><font color ="blue" size ="2"><b>    Giới tính: </b> </font> '; 
			echo '<font color ="red" size ="2"><b>';  if ($row['phai']!='1') echo "Nam"; else echo "Nữ"; '</b> </font>';
			echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
			echo '<td width ="300"><font color ="blue" size ="2"><b>    Ngày sinh: </b> </font> ';
			echo '<font color ="red" size ="2"><b>';  echo $row['namsinh']; '</b> </font>';
			echo '</td>';
			echo '<td width ="300"><font color ="blue" size ="2"><b>    Nơi sinh: </b> </font> ';
			echo '<font color ="red" size ="2"><b>'; echo $row['noisinh']; '</b> </font>';
			echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
			echo '<td width ="300"><font color ="blue" size ="2"><b>    Lớp: </b> </font> ';
			echo '<font color ="red" size ="2"><b>'; echo $row['mlop']; '</b> </font>';
			echo '</td>';

			echo '</tr>';
			echo '</table>';

	}
	?>
	
<?php	
		if ((($mhss)&&($mhocki=='1'))||(($mhss)&&($mhocki=='2')))
{
		$query1 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='to'"; 
		$db->setQuery( $query1 );
		$toan = $db->query();
		$sltoan = mysql_num_rows($toan);
		
		$query2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='vl'"; 
		$db->setQuery( $query2 );
		$vatly = $db->query();
		$slvatly = mysql_num_rows($vatly);
		
		$query3 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='ho'"; 
		$db->setQuery( $query3 );
		$hoa = $db->query();
		$slhoa = mysql_num_rows($hoa);
		
		$query4 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='si'"; 
		$db->setQuery( $query4 );
		$sinh = $db->query();
		$slsinh = mysql_num_rows($sinh);
		
		$query5 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='cn'"; 
		$db->setQuery( $query5 );
		$congnghe = $db->query();
		$slcongnghe = mysql_num_rows($congnghe);
		
		$query6 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='va'"; 
		$db->setQuery( $query6 );
		$van = $db->query();
		$slvan = mysql_num_rows($van);
		
		$query7 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='su'"; 
		$db->setQuery( $query7 );
		$su = $db->query();
		$slsu = mysql_num_rows($su);
		
		$query8 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='di'"; 
		$db->setQuery( $query8 );
		$dia = $db->query();
		$sldia = mysql_num_rows($dia);
		
		$query9 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='cd'"; 
		$db->setQuery( $query9 );
		$gdcd = $db->query();
		$slgdcd = mysql_num_rows($gdcd);
		
		$query10 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='nn'"; 
		$db->setQuery( $query10 );
		$ngoaingu = $db->query();
		$slngoaingu = mysql_num_rows($ngoaingu);
		
		$query11 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='td'"; 
		$db->setQuery( $query11 );
		$theduc = $db->query();
		$sltheduc = mysql_num_rows($theduc);
		
		$query12 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='qp'"; 
		$db->setQuery( $query12 );
		$quocphong = $db->query();
		$slquocphong = mysql_num_rows($quocphong);
		
		$query13 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='ti'"; 
		$db->setQuery( $query13 );
		$tin = $db->query();
		$sltin = mysql_num_rows($tin);
		
		$query14 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='an'"; 
		$db->setQuery( $query14 );
		$amnhac = $db->query();
		$slamnhac = mysql_num_rows($amnhac);
		
		$query15 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '$mhocki' and mmon ='mt'"; 
		$db->setQuery( $query15 );
		$mythuat = $db->query();
		$slmythuat = mysql_num_rows($mythuat);
		
		if($sltoan+$slvatly+$slhoa+$slsinh+$slcongnghe+$slvan+$slsu+$sldia+$slgdcd+$slngoaingu+$sltheduc+$slquocphong+$sltin+$slamnhac+$slmythuat)
	{
		
		echo '<table><tr><td width ="550" align ="center"><font color ="blue" size ="4"><b>    Bảng điểm tổng kết học kì: </b> </font> ';
		echo '<font color ="red" size ="4"><b>'; echo $mhocki; '</b> </font>';
		echo '</td></tr></table>';
		
		echo '<table width ="550" border ="1" style="border-collapse:collapse">';
		
		echo '<tr>';
		echo '		<th width = "120"align = "center"> Môn </th>';
		echo '		<th width = "60"align = "center"colspan=2> Miệng </th>';
		echo '		<th width = "150"align = "center"colspan=5> 15 phút </th>';
		echo '		<th width = "150"align = "center"colspan=5> 1 tiết </th>';
		echo '		<th width = "60"align = "center"> Thi </th>';
		echo '		<th width = "100"align = "center"> Điểm trung bình </th>';
		echo '		</tr>';

					while ($row = mysql_fetch_array($toan))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>1. Toán</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
					while ($row = mysql_fetch_array($vatly))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>2. Vật lý</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
					while ($row = mysql_fetch_array($hoa))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>3. Hóa học</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
					while ($row = mysql_fetch_array($sinh))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>4. Sinh học</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
				while ($row = mysql_fetch_array($congnghe))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>5. Công nghệ</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
				
					while ($row = mysql_fetch_array($van))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>6. Ngữ văn</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
				while ($row = mysql_fetch_array($su))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>7. Lịch sử</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}

				
	
					while ($row = mysql_fetch_array($dia))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>8. Địa lý</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
				while ($row = mysql_fetch_array($gdcd))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>9. GDCD</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}	
				while ($row = mysql_fetch_array($ngoaingu))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>10. Ngoại ngữ</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
				while ($row = mysql_fetch_array($theduc))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>11. Thể dục</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
				while ($row = mysql_fetch_array($quocphong))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>12. Quốc phòng</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
				while ($row = mysql_fetch_array($tin))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>13. Tin học</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
					while ($row = mysql_fetch_array($amnhac))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>14. Âm nhạc</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
				while ($row = mysql_fetch_array($mythuat))
				{?>
				<tr>
				<td width = "100"> <?php echo '<b>15. Mỹ thuật</b>' ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['dm_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d15_5'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_1'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_2'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_3'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_4'] ;?></td>
				<td width = "30" align = "center"> <?php echo $row['d1t_5'] ;?></td>				
				<td width = "60" align = "center"> <?php echo $row['dthi'] ;?></td>	
				<td width = "100" align = "center"> <?php echo $row['dtb'] ;?></td>	
				</tr>
				<?php
				}
			$query16 = "SELECT * FROM #__xl where mhs ='$mhss' and mhk='$mhocki' and mnam like'$manam'"; 
			
			$db->setQuery( $query16 );
			$xlhs = $db->query();	
			while ($row = mysql_fetch_array($xlhs))
				{
				echo "<table width =550 border =1 style='border-collapse:collapse'><tr><td width=204> <b>Điểm trung bình môn học kì ";
				echo $mhocki;
				echo "</b></td>";
				echo "<td>"; 
				echo $row['dtbm'];
				echo "</td></tr>";
				echo "<tr> <td> <b>Học lực</b></td><td>";
				echo $row['hluc']; "</td></tr>";
				echo "<tr> <td> <b>Hạnh kiểm</b></td><td>";
				echo $row['hkiem']; "</td></tr>";
				echo "<tr> <td> <b>Đã đạt danh hiệu</b></td><td>";
				echo $row['dhieu']; "</td></tr>";
				echo "<tr> <td> <b>Nhận xét của giáo viên</b></td><td>";
				echo $row['nhanxet']; "</td></tr>";
				echo "</table>";
				}
				
	}
	else
	{	echo '<table width ="550">';
		echo '<tr><td align ="center" ><b>Hiện tại điểm của <i>'.$hoten.'</i> chưa được cập nhật!</b></td></tr>';
		echo '</table>';
	}
}
		else 
		if (($mhss)&&($mhocki=='3'))
	{
		$query1 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='to'"; 
		$db->setQuery( $query1 );
		$toan1 = $db->query();
		$sltoan1 = mysql_num_rows($toan1);
		
		$query2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='vl'"; 
		$db->setQuery( $query2 );
		$vatly1 = $db->query();
		$slvatly1 = mysql_num_rows($vatly1);
		
		$query3 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='ho'"; 
		$db->setQuery( $query3 );
		$hoa1 = $db->query();
		$slhoa1 = mysql_num_rows($hoa1);
		
		$query4 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='si'"; 
		$db->setQuery( $query4 );
		$sinh1 = $db->query();
		$slsinh1 = mysql_num_rows($sinh1);
		
		$query5 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='cn'"; 
		$db->setQuery( $query5 );
		$congnghe1 = $db->query();
		$slcongnghe1 = mysql_num_rows($congnghe1);
		
		$query6 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='va'"; 
		$db->setQuery( $query6 );
		$van1 = $db->query();
		$slvan1 = mysql_num_rows($van1);
		
		$query7 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='su'"; 
		$db->setQuery( $query7 );
		$su1 = $db->query();
		$slsu1 = mysql_num_rows($su1);
		
		$query8 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='di'"; 
		$db->setQuery( $query8 );
		$dia1 = $db->query();
		$sldia1 = mysql_num_rows($dia1);
				
		$query9 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='cd'"; 
		$db->setQuery( $query9 );
		$gdcd1 = $db->query();
		$slgdcd1 = mysql_num_rows($gdcd1);
		
		$query10 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='nn'"; 
		$db->setQuery( $query10 );
		$ngoaingu1 = $db->query();
		$slngoaingu1 = mysql_num_rows($ngoaingu1);
		
		$query11 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='td'"; 
		$db->setQuery( $query11 );
		$theduc1 = $db->query();
		$sltheduc1 = mysql_num_rows($theduc1);
		
		$query12 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='qp'"; 
		$db->setQuery( $query12 );
		$quocphong1 = $db->query();
		$slquocphong1 = mysql_num_rows($quocphong1);
		
		$query13 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='ti'"; 
		$db->setQuery( $query13 );
		$tin1 = $db->query();
		$sltin1 = mysql_num_rows($tin1);
		
		$query14 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='an'"; 
		$db->setQuery( $query14 );
		$amnhac1 = $db->query();
		$slamnhac1 = mysql_num_rows($amnhac1);
		
		$query15 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '1' and mmon ='mt'"; 
		$db->setQuery( $query15 );
		$mythuat1 = $db->query();
		$slmythuat1 = mysql_num_rows($mythuat1);
		
		$query1_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='to'"; 
		$db->setQuery( $query1_2 );
		$toan2 = $db->query();
		$sltoan2 = mysql_num_rows($toan2);
		
		$query2_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='vl'"; 
		$db->setQuery( $query2_2 );
		$vatly2 = $db->query();
		$slvatly2 = mysql_num_rows($vatly2);
		
		$query3_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='ho'"; 
		$db->setQuery( $query3_2 );
		$hoa2 = $db->query();
		$slhoa2= mysql_num_rows($hoa2);
		
		$query4_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='si'"; 
		$db->setQuery( $query4_2 );
		$sinh2 = $db->query();
		$slsinh2 = mysql_num_rows($sinh2);
		
		$query5_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='cn'"; 
		$db->setQuery( $query5_2 );
		$congnghe2 = $db->query();
		$slcongnghe2 = mysql_num_rows($congnghe2);
		
		$query6_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='va'"; 
		$db->setQuery( $query6_2 );
		$van2 = $db->query();
		$slvan2 = mysql_num_rows($van2);
		
		$query7_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='su'"; 
		$db->setQuery( $query7_2 );
		$su2 = $db->query();
		$slsu2 = mysql_num_rows($su2);
		
		$query8_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='di'"; 
		$db->setQuery( $query8_2 );
		$dia2 = $db->query();
		$sldia2 = mysql_num_rows($dia2);
		
		$query9_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='cd'"; 
		$db->setQuery( $query9_2 );
		$gdcd2 = $db->query();
		$slgdcd2 = mysql_num_rows($gdcd2);
		
		$query10_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='nn'"; 
		$db->setQuery( $query10_2 );
		$ngoaingu2 = $db->query();
		$slngoaingu2 = mysql_num_rows($ngoaingu2);
		
		$query11_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='td'"; 
		$db->setQuery( $query11_2 );
		$theduc2 = $db->query();
		$sltheduc2 = mysql_num_rows($theduc2);
		
		$query12_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='qp'"; 
		$db->setQuery( $query12_2 );
		$quocphong2 = $db->query();
		$slquocphong2 = mysql_num_rows($quocphong2);
		
		$query13_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='ti'"; 
		$db->setQuery( $query13_2 );
		$tin2 = $db->query();
		$sltin2 = mysql_num_rows($tin2);
		
		$query14_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='an'"; 
		$db->setQuery( $query14_2 );
		$amnhac2 = $db->query();
		$slamnhac2 = mysql_num_rows($amnhac2);
		
		$query15_2 = "SELECT * FROM #__diem where mhs ='$mhss' and mhk = '2' and mmon ='mt'"; 
		$db->setQuery( $query15_2 );
		$mythuat2 = $db->query();
		$slmythuat2 = mysql_num_rows($mythuat2);
		
		if($sltoan1+$sltoan2+$slvatly1+$slvatly2+$slhoa1+$slhoa2+$slsinh1+$slsinh2+$slcongnghe1+$slcongnghe2+$slvan1+$slvan2+$slsu1+$slsu2+$sldia1+$sldia2+$slgdcd1+$slgdcd2+$slngoaingu1+$slngoaingu2+$sltheduc1+$sltheduc2+$slquocphong1+$slquocphong2+$sltin1+$sltin2+$slamnhac1+$slamnhac2+$slmythuat1+$slmythuat2)
	{
		echo '<table><tr><td width ="550" align ="center"><font color ="blue" size ="4"><b>Bảng tổng kết điểm: </b> </font> ';
		echo '<font color ="red" size ="4"><b>Cả năm</b> </font>';
		echo '</td></tr></table>';
		
		echo '<table width ="550" border ="1" style="border-collapse:collapse">';
		
		echo '<tr>';
		echo '		<th width = "120"align = "center"> Môn </th>';
		echo '		<th width = "100"align = "center"> Học kì 1 </th>';
		echo '		<th width = "100"align = "center"> Học kì 2 </th>';
		echo '		<th width = "100"align = "center"> Cả năm </th>';
		echo '		</tr>';

				
			
				if (($sltoan1)&&($sltoan2))
				{
				while ($row = mysql_fetch_array($toan1))
				{
				
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td> <?php echo '<b>1. Toán</b>' ;?></td>	
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($toan2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				<?php
				}
				if (($slvatly1)&&($slvatly2))
				{
				while ($row = mysql_fetch_array($vatly1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>2. Vật lý</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($vatly2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				}
				if (($slhoa1)&&($slhoa2))
				{
					while ($row = mysql_fetch_array($hoa1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>3. Hóa học</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($hoa2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				}	
	
				if (($slsinh1)&&($slsinh2))
				{
				while ($row = mysql_fetch_array($sinh1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>4. Sinh học</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($sinh2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				}
				if (($slcongnghe1)&&($slcongnghe2))
				{
				while ($row = mysql_fetch_array($congnghe1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>5. Công nghệ</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($congnghe2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				
				}
				if (($slvan1)&&($slvan2))
				{
					while ($row = mysql_fetch_array($van1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>6. Ngữ văn</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($van2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php

				}
				if (($slsu1)&&($slsu2))
				{
				while ($row = mysql_fetch_array($su1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>7. Lịch sử</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($su2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				}
				if (($sldia1)&&($sldia2))
				{
	
					while ($row = mysql_fetch_array($dia1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>8. Địa lý</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($dia2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				}
				if (($slgdcd1)&&($slgdcd2))
				{
				
				while ($row = mysql_fetch_array($gdcd1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>9. GDCD</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($gdcd2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				}
				if (($slngoaingu1)&&($slngoaingu2))
				{
	
					while ($row = mysql_fetch_array($ngoaingu1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>10. Ngoại ngữ</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($ngoaingu2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				<?php
				}
				if (($sltheduc1)&&($sltheduc2))
				{
				
				while ($row = mysql_fetch_array($theduc1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>11. Thể dục</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($theduc2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php

				}
				if (($slquocphong1)&&($slquocphong2))
				{
	
					while ($row = mysql_fetch_array($quocphong1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>12. Quốc phòng</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($quocphong2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php

				}
				if (($sltin1)&&($sltin2))
				{
				
				while ($row = mysql_fetch_array($tin1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>13. Tin học</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($tin2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				}
				if (($slamnhac1)&&($slamnhac2))
				{
				
					while ($row = mysql_fetch_array($amnhac1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>14. Âm nhạc</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($amnhac2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				
				<?php
				}
				if (($slmythuat1)&&($slmythuat2))
				{
				
				while ($row = mysql_fetch_array($mythuat1))
				{
				$hk1 =$row['dtb'] ;
				?>
				<tr>
				<td width = "100"> <?php echo '<b>15. Mỹ thuật</b>' ;?></td>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>	
<?php 			
				}
				while ($row = mysql_fetch_array($mythuat2))
				{
				$hk2 =$row['dtb'] ;
				?>
				<td align = "center"> <?php echo $row['dtb'] ;?></td>
				<?php
				}
				?>
				<td align = "center"><?php echo round((($hk1+$hk2*2)/3),1);?></td>
				</tr>
				<?php
				}
			$query16 = "SELECT * FROM #__xl where mhs ='$mhss' and mhk='1' and mnam like'$manam'"; 
			
			$db->setQuery( $query16 );
			$xlhs1 = $db->query();	
			
			$query17 = "SELECT * FROM #__xl where mhs ='$mhss' and mhk='2' and mnam like'$manam'"; 
			$db->setQuery( $query17 );
			$xlhs2 = $db->query();
			
			$query18 = "SELECT * FROM #__xl where mhs ='$mhss' and mhk='3' and mnam like'$manam'"; 
			$db->setQuery( $query18 );
			$xlhs3 = $db->query();
			
			while (($row1 = mysql_fetch_array($xlhs1))&&($row2 = mysql_fetch_array($xlhs2))&&($row3 = mysql_fetch_array($xlhs3)))
				{
				echo "<table width =550 border =1 style='border-collapse:collapse'>";
				echo "<tr><td width=153.5> <b>Điểm TBM học kì 1";
				echo "</b></td>";
				echo "<td width=127 align =center>"; 
				echo $row1['dtbm'];
				echo "</td>";
				echo "<td width=127 align =center>"; 
				echo $row2['dtbm'];
				echo "</td>";
				echo "<td width=127 align =center>"; 
				echo $row3['dtbm'];
				echo "</td></tr>";
				echo "<tr> <td> <b>Học lực</b></td>";
				echo "<td align =center>";
				echo $row1['hluc']; "</td>";
				echo "<td align =center>";
				echo $row2['hluc']; "</td>";
				echo "<td align =center>";
				echo $row3['hluc']; "</td></tr>";
				echo "<tr> <td> <b>Hạnh kiểm</b></td>";
				echo "<td align =center>";
				echo $row1['hkiem']; "</td>";
				echo "<td align =center>";
				echo $row2['hkiem']; "</td>";
				echo "<td align =center>";
				echo $row3['hkiem']; "</td></tr>";
				echo "<tr> <td> <b>Đã đạt danh hiệu</b></td>";
				echo "<td align =center>";
				echo $row1['dhieu']; "</td>";
				echo "<td align =center>";
				echo $row2['dhieu']; "</td>";
				echo "<td align =center>";
				echo $row3['dhieu']; "</td></tr>";
				echo "<tr> <td> <b>Nhận xét của giáo viên</b></td>";
				echo "<td align =center>";
				echo $row1['nhanxet']; "</td>";
				echo "<td align =center>";
				echo $row2['nhanxet']; "</td>";
				echo "<td align =center>";
				echo $row3['nhanxet']; "</td></tr>";
				echo "</table>";
				}
	
	}
		else
			echo '<tr><td align ="center"><b>Hiện tại điểm của <i>'.$hoten.'</i> chưa được cập nhật!</b></td></tr>';
	}
?>		
		<tr>
				<td colspan="22"><center><a href="javascript:history.go(-1)">Quay lại trang trước</a></center></td>
		
		</tr>
</table>