<?php // no direct access

defined('_JEXEC') or die('Restricted access');

foreach ($list as $item) :  ?>

<div class="gn_static_<?php echo $globalnews_id; ?>">
	<?php echo $item->content; ?>
</div>
<?php 
endforeach; ?>
<?php
if ( $more == 1 && $group->link ) : ?>
<div> <?php echo JHTML::_('link', $group->link, JText::_('More Articles...'), array('class'=>'readon') ); ?> </div>
<?php
endif;