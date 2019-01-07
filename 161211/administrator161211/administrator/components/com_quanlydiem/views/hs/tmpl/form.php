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
			<input class="text_area" type="text" name="mhs" id="mhs" size="32" maxlength="250" value="<?php echo $this->hs->mhs;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="mnam">
					<?php echo JText::_( 'Mã năm học' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mnam" id="mnam" size="32" maxlength="250" value="<?php echo $this->hs->mnam;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="hoten">
					<?php echo JText::_( 'Họ và tên' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="hoten" id="hoten" size="32" maxlength="250" value="<?php echo $this->hs->hoten;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="mlop">
					<?php echo JText::_( 'Mã lớp' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mlop" id="mlop" size="32" maxlength="250" value="<?php echo $this->hs->mlop;?>" />
			</td>
		</tr>
		
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="phai">
					<?php echo JText::_( 'Giới tính (0: nam, 1: nữ)' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="phai" id="phai" size="32" maxlength="250" value="<?php echo $this->hs->phai;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="namsinh">
					<?php echo JText::_( 'Ngày sinh' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="namsinh" id="namsinh" size="32" maxlength="250" value="<?php echo $this->hs->namsinh;?>" />
			</td>
		</tr>
		<tr>
			<td width="300" align="right" class="key">
				<label for="noisinh">
					<?php echo JText::_( 'Nơi sinh' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="noisinh" id="noisinh" size="32" maxlength="250" value="<?php echo $this->hs->noisinh;?>" />
			</td>
		</tr>

	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_quanlydiem" />
<input type="hidden" name="id" value="<?php echo $this->hs->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="hs" />
</form>
