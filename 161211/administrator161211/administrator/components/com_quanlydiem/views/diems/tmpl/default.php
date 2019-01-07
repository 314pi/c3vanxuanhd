<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th width="100">
				<?php echo JText::_( 'Mã học sinh' ); ?>
			</th>			
			<th>
				<?php echo JText::_( 'Mã lớp' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Mã năm học' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Mã Học kỳ' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Mã môn học' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm miệng (1)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm miệng (2)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 15 phút (1)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 15 phút (2)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 15 phút (3)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 15 phút (4)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 15 phút (5)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 1 tiết (1)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 1 tiết (2)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 1 tiết (3)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 1 tiết (4)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm 1 tiết (5)' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm thi' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Điểm trung bình' ); ?>
			</th>
		</tr>			
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_quanlydiem&controller=diem&task=edit&cid[]='. $row->id );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->mhs; ?></a>
			</td>
			<td>
				<?php echo $row->mlop; ?>
			</td>
			<td>
				<?php echo $row->mnam; ?>
			</td>
			<td>
				<?php echo $row->mhk; ?>
			</td>
			<td>
				<?php echo $row->mmon; ?>
			</td>
			<td>
				<?php echo $row->dm_1; ?>
			</td>
			<td>
				<?php echo $row->dm_2; ?>
			</td>
			<td>
				<?php echo $row->d15_1; ?>
			</td>
			<td>
				<?php echo $row->d15_2; ?>
			</td>
			<td>
				<?php echo $row->d15_3; ?>
			</td>
			<td>
				<?php echo $row->d15_4; ?>
			</td>
			<td>
				<?php echo $row->d15_5; ?>
			</td>
			<td>
				<?php echo $row->d1t_1; ?>
			</td>
			<td>
				<?php echo $row->d1t_2; ?>
			</td>
			<td>
				<?php echo $row->d1t_3; ?>
			</td>
			<td>
				<?php echo $row->d1t_4; ?>
			</td>
			<td>
				<?php echo $row->d1t_5; ?>
			</td>
			<td>
				<?php echo $row->dthi; ?>
			</td>
			<td>
				<?php echo $row->dtb; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>

<input type="hidden" name="option" value="com_quanlydiem" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="diem" />
</form>
