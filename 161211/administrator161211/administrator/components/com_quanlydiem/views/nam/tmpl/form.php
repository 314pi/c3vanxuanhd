<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="mnam">
					<?php echo JText::_( 'Mã năm học' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mnam" id="mnam" size="32" maxlength="250" value="<?php echo $this->nam->mnam;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="nam">
					<?php echo JText::_( 'Năm học' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="nam" id="nam" size="32" maxlength="250" value="<?php echo $this->nam->nam;?>" />
			</td>
		</tr>

	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_quanlydiem" />
<input type="hidden" name="id" value="<?php echo $this->nam->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="nam" />
</form>
