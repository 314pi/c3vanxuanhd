<?php // no direct access
defined('_JEXEC') or die('Restricted access');?>

<ul class="filterednews">
  <?php foreach ($list as $item) :  ?>
  <li class="filterednews"> <?php echo $item->title; ?> </li>
  <?php endforeach; ?>
</ul>