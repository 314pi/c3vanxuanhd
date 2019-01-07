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
				<?php echo JText::_( 'Mã học kỳ' ); ?>
			</th>
			
			<th>
				<?php echo JText::_( 'Điểm TBM' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Học lực' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Hạnh kiểm' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Số NNCP' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Số NNKP' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Danh hiệu' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Nhận xét của GV' ); ?>
			</th>
		</tr>			
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_quanlydiem&controller=xl&task=edit&cid[]='. $row->id );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->mhs; ?>
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
				<?php echo $row->dtbm; ?>
			</td>
			<td>
				<?php echo $row->hkiem; ?></a>
			</td>
			<td>
				<?php echo $row->hluc; ?></a>
			</td>
			<td>
				<?php echo $row->snncp; ?>
			</td>

			<td>
				<?php echo $row->snnkp; ?>
			</td>
			<td>
				<?php echo $row->dhieu; ?></a>
			</td>
			<td>
				<?php echo $row->nhanxet; ?></a>
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
<input type="hidden" name="controller" value="xl" />
</form>
