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
			<input class="text_area" type="text" name="mhs" id="mhs" size="32" maxlength="250" value="<?php echo $this->xl->mhs;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="mlop">
					<?php echo JText::_( 'Mã lớp' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mlop" id="mlop" size="32" maxlength="250" value="<?php echo $this->xl->mlop;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="mnam">
					<?php echo JText::_( 'Mã năm học' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mnam" id="mnam" size="32" maxlength="250" value="<?php echo $this->xl->mnam;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="mhk">
					<?php echo JText::_( 'Mã học kỳ' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mhk" id="mhk" size="32" maxlength="250" value="<?php echo $this->xl->mhk;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="dtbm">
					<?php echo JText::_( 'Điểm trung bình môn' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="dtbm" id="dtbm" size="32" maxlength="250" value="<?php echo $this->xl->dtbm;?>" />
			</td>
		</tr>
		
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="hluc">
					<?php echo JText::_( 'Học lực' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="hluc" id="hluc" size="32" maxlength="250" value="<?php echo $this->xl->hluc;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="hkiem">
					<?php echo JText::_( 'Hạnh kiểm' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="hkiem" id="hkiem" size="32" maxlength="250" value="<?php echo $this->xl->hkiem;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="snncp">
					<?php echo JText::_( 'Số ngày nghỉ có phép' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="snncp" id="snncp" size="32" maxlength="250" value="<?php echo $this->xl->snncp;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="snnkp">
					<?php echo JText::_( 'Số ngày nghỉ không phép' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="snnkp" id="snnkp" size="32" maxlength="250" value="<?php echo $this->xl->snnkp;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="dhieu">
					<?php echo JText::_( 'Danh hiệu' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="dhieu" id="dhieu" size="32" maxlength="250" value="<?php echo $this->xl->dhieu;?>" />
			</td>
		</tr>
		
		
		<tr>
			<td width="1000" align="right" class="key">
				<label for="nhanxet">
					<?php echo JText::_( 'Nhận xét của giáo viên' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="nhanxet" id="nhanxet" size="32" maxlength="250" value="<?php echo $this->xl->nhanxet;?>" />
			</td>
		</tr>
		
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_quanlydiem" />
<input type="hidden" name="id" value="<?php echo $this->xl->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="xl" />
</form>
