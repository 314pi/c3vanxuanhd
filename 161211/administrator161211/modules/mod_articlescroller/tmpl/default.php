<?php defined('_JEXEC') or die('Restricted access'); // no direct access ?>

<?php
  // get the parameter values
  $item_id = $params->get('item_id');
  $scroll_direction = $params->get('scroll_direction');
  $scroll_amount = $params->get('scroll_amount');
  $scroll_delay = $params->get('scroll_delay');
  $container_width = $params->get('container_width');
  $container_height = $params->get('container_height');
  
  
  $article_pre_css = $params->get('article_pre_css');
  $article_post_css = $params->get('article_post_css');
  
?>

<?php 
  echo $article_pre_css;
?>

<marquee behavior="scroll" 
	       direction="<?php echo $scroll_direction; ?>"
	       loop="infinite"
         height="<?php echo $container_height; ?>"
         width="<?php echo $container_width; ?>"
         scrollamount="<?php echo $scroll_amount; ?>"
         scrolldelay="<?php echo $scroll_delay; ?>"
         onmouseover="this.stop()" onmouseout="this.start()">

<?php foreach ($items as $item) {
  echo $item->introtext;
}
?>

</marquee>

<?php
  echo $article_post_css;
?>
