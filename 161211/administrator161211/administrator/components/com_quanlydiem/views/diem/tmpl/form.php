<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="mhs">
					<?php echo JText::_( 'Mã học sinh' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mhs" id="mhs" size="32" maxlength="250" value="<?php echo $this->diem->mhs;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="mlop">
					<?php echo JText::_( 'Mã lớp' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mlop" id="mlop" size="32" maxlength="250" value="<?php echo $this->diem->mlop;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="mnam">
					<?php echo JText::_( 'Mã năm học' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mnam" id="mnam" size="32" maxlength="250" value="<?php echo $this->diem->mnam;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="mhk">
					<?php echo JText::_( 'Mã học kỳ' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mhk" id="mhk" size="32" maxlength="250" value="<?php echo $this->diem->mhk;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="mmon">
					<?php echo JText::_( 'Mã môn' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mmon" id="mmon" size="32" maxlength="250" value="<?php echo $this->diem->mmon;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="dm_1">
					<?php echo JText::_( 'Miệng (1)' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="dm_1" id="dm_1" size="32" maxlength="250" value="<?php echo $this->diem->dm_1;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="dm_2">
					<?php echo JText::_( 'Miệng (2)' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="dm_2" id="dm_2" size="32" maxlength="250" value="<?php echo $this->diem->dm_2;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d15_1">
					<?php echo JText::_( '15 phút (1)' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="d15_1" id="d15_1" size="32" maxlength="250" value="<?php echo $this->diem->d15_1;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d15_2">
					<?php echo JText::_( '15 phút (2)' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="d15_2" id="d15_2" size="32" maxlength="250" value="<?php echo $this->diem->d15_2;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d15_3">
					<?php echo JText::_( '15 phút (3)' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="d15_3" id="d15_3" size="32" maxlength="250" value="<?php echo $this->diem->d15_3;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d15_4">
					<?php echo JText::_( '15 phút (4)' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="d15_4" id="d15_4" size="32" maxlength="250" value="<?php echo $this->diem->d15_4;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d15_5">
					<?php echo JText::_( '15 phút (5)' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="d15_5" id="d15_5" size="32" maxlength="250" value="<?php echo $this->diem->d15_5;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d1t_1">
					<?php echo JText::_( '1 tiết (1)' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="d1t_1" id="d1t_1" size="32" maxlength="250" value="<?php echo $this->diem->d1t_1;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d1t_2">
					<?php echo JText::_( '1 tiết (2)' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="d1t_2" id="d1t_2" size="32" maxlength="250" value="<?php echo $this->diem->d1t_2;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d1t_3">
					<?php echo JText::_( '1 tiết (3)' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="d1t_3" id="d1t_3" size="32" maxlength="250" value="<?php echo $this->diem->d1t_3;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d1t_4">
					<?php echo JText::_( '1 tiết (4)' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="d1t_4" id="d1t_4" size="32" maxlength="250" value="<?php echo $this->diem->d1t_4;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="d1t_5">
					<?php echo JText::_( '1 tiết (5)' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="d1t_5" id="d1t_5" size="32" maxlength="250" value="<?php echo $this->diem->d1t_5;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="thi">
					<?php echo JText::_( 'Thi' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="thi" id="thi" size="32" maxlength="250" value="<?php echo $this->diem->thi;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="dtb">
					<?php echo JText::_( 'Điểm trung bình' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="dtb" id="dtb" size="32" maxlength="250" value="<?php echo $this->diem->dtb;?>" />
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_quanlydiem" />
<input type="hidden" name="id" value="<?php echo $this->diem->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="diem" />
</form>
