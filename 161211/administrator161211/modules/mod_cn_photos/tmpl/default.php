<?php

/**
 * @version		1.9
 * @package		mod_cn_photos
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2011 demo.calebnance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 *
 *				default.php
 */
 	defined('_JEXEC') or die('Direct Access to this location is not allowed.');
?>

<div class="cn_photos<?php echo $sfx; ?>">
	<div class="slideshow<?php echo $modid; ?>">
	<?php
		for($x=0; $x < $total; $x++){
	?>
		<img src="<?php echo $base . $path .'/'. $photos[$x]; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
		
	<?php
		}
	?>
	</div>
</div>