<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="mhk">
					<?php echo JText::_( 'Mã học kì' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="mhk" id="mhk" size="32" maxlength="250" value="<?php echo $this->hk->mhk;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="hk">
					<?php echo JText::_( 'Học kì' ); ?>:
				</label>
			</td>
			<td>
				
				<input class="text_area" type="text" name="hk" id="hk" size="32" maxlength="250" value="<?php echo $this->hk->hk;?>" />
			</td>
		</tr>

	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_quanlydiem" />
<input type="hidden" name="id" value="<?php echo $this->hk->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="hk" />
</form>
