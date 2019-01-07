<?php // no direct access

defined('_JEXEC') or die('Restricted access');

foreach ($list as $item) :  ?>

<div class="fn_static_<?php echo $filterednews_id; ?>">
	 <?php echo $item->content; ?>
</div>
<?php 
endforeach; ?>
