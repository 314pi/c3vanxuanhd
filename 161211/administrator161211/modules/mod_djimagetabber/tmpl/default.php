<?php
/**
* @version 1.1.4 stable
* @package DJ Image Tabber
* @subpackage DJ Image Tabber Module
* @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: http://design-joomla.eu
* @author email contact@design-joomla.eu
* @developer Michal Olczyk - michal.olczyk@design-joomla.eu
*
*
* DJ Image Slider is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* DJ Image Slider is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with DJ Image Slider. If not, see <http://www.gnu.org/licenses/>.
*
*/

// no direct access
defined('_JEXEC') or die ('Restricted access'); ?>

<div id="djimagetabber_<?php echo $mid; ?>" class="djimagetabber">
	<div id="djimagetabber-images_<?php echo $mid; ?>" class="djimagetabber-images">
		<?php foreach ($slides as $slide) : ?>
			<div class="djimagetabber-image">
				<div class="djimagetabber-image-in">
					<img src="<?php echo $slide->image; ?>" alt="<?php echo $slide->alt; ?>" />
					<?php if ($params->get('show_desc') || $params->get('show_title')) : ?>
						<div class="djimagetabber-text">
							<?php if ($params->get('show_title') == 1) : ?>
								<h2 class="djimagetabber-title">
									<?php if ($params->get('link_title')) : ?>
										<a href="<?php echo $slide->link; ?>" target="<?php echo $slide->target; ?>">
											<?php echo $slide->title; ?>
										</a>
									<?php else : ?>
										<?php echo $slide->title; ?>
									<?php endif; ?>
								</h2>
							<?php endif; ?>
							<?php if ($params->get('show_desc')) : ?>
								<div class="djimagetabber-desc">
									<?php echo $slide->description; ?>
								</div>
							<?php endif; ?>
							<?php if ($params->get('link_readmore')) : ?>
								<a class="readon" href="<?php echo $slide->link; ?>" target="<?php echo $slide->target; ?>">
									<?php echo JText::_('READ MORE...'); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div id="djimagetabber-tabs_<?php echo $mid; ?>" class="djimagetabber-tabs">
		<?php foreach ($slides as $key => $slide) : ?>
			<div class="djimagetabber-tab <?php if($key==0) echo 'tab-active'; ?>">
				<span class="djimagetabber-tab-in">
					<?php echo $slide->title; ?>
				</span>
			</div>
		<?php endforeach; ?>
	</div>
	<div id="djimagetabber-ind_<?php echo $mid; ?>" class="djimagetabber-ind"></div>
</div>
<div style="clear: both;"></div>
