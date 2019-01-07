<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<script src = "<?php echo JURI::root(); ?>modules/mod_camp26_easyslideshow/scripts/jquery-1.3.2.min.js" language="JavaScript1.2"></script>
<script src = "<?php echo JURI::root(); ?>modules/mod_camp26_easyslideshow/scripts/jquery.easing.1.3.js" language="JavaScript1.2"></script>
<script src = "<?php echo JURI::root(); ?>modules/mod_camp26_easyslideshow/scripts/jquery-galleryview-1.1/jquery.galleryview-1.1.js" language="JavaScript1.2"></script>
<script src = "<?php echo JURI::root(); ?>modules/mod_camp26_easyslideshow/scripts/jquery-galleryview-1.1/jquery.timers-1.1.2.js" language="JavaScript1.2"></script>
<link rel="stylesheet" href="<?php echo JURI::root(); ?>modules/mod_camp26_easyslideshow/css/s3Slider.css" type="text/css" />


<script type="text/javascript">
    var baru = jQuery.noConflict();
</script>



<?php
$image1=trim($params->get( 'images1' ));
$image2=trim($params->get( 'images2' ));
$image3=trim($params->get( 'images3' ));
$image4=trim($params->get( 'images4' ));
$image5=trim($params->get( 'images5' ));

$text1=$params->get('text1');
$text2=$params->get('text2');
$text3=$params->get('text3');
$text4=$params->get('text4');
$text5=$params->get('text5');

$url1=$params->get('url1');
$url2=$params->get('url2');
$url3=$params->get('url3');
$url4=$params->get('url4');
$url5=$params->get('url5');
?>


	<div id="photos" class="galleryview">
<div class="panel">
     <img src="<?php echo JURI::root() . trim ( $params->get ( 'folder' ) ) . "/" . $image1;?>" /> 
    <div class="panel-overlay">
		<?php echo "<br />";echo $text1 . " ... <a href='" . $url1. "'>read more</a>"; ?>
    </div>
  </div>
  <div class="panel">
     <img src="<?php echo JURI::root() . trim ( $params->get ( 'folder' ) ) . "/" . $image2;?>" /> 
    <div class="panel-overlay">
		<?php echo "<br />";echo $text2. " ... <a href='".$url2. "'>read more</a>"; ?>
    </div>
  </div>
  <div class="panel">
     <img src="<?php echo JURI::root() . trim ( $params->get ( 'folder' ) ) . "/" . $image3;?>" /> 
    <div class="panel-overlay">
		<?php echo "<br />"; echo $text3. " ... <a href='".$url3. "'>read more</a>"; ?>
    </div>
  </div>
  <div class="panel">
     <img src="<?php echo JURI::root() . trim ( $params->get ( 'folder' ) ) . "/" . $image4;?>" /> 
    <div class="panel-overlay">
		<?php echo "<br />"; echo $text4. " ... <a href='".$url4. "'>read more</a>"; ?>
    </div>
  </div>
  <div class="panel">
     <img src="<?php echo JURI::root() . trim ( $params->get ( 'folder' ) ) . "/" . $image5;?>" /> 
    <div class="panel-overlay">
		<?php echo "<br />"; echo $text5. " ... <a href='".$url5. "'>read more</a>"; ?>
    </div>
  </div>
</div>
<span style="font-size: 5px; float: left;"><a style="color:grey;" href="http://www.camp26.biz" target="_blank">by camp26</a></span>
<div style="clear: both;"></div>
<script type="text/javascript">
	baru(document).ready(function(){		
		baru('#photos').galleryView({
			panel_width: <?php echo ($params->get('width'));?>,
			panel_height: <?php echo ($params->get('height'));?>,
			transition_speed: <?php echo ($params->get('transition_speed'));?>,
			transition_interval: <?php echo ($params->get('transition_interval'));?>,
			nav_theme: 'camp26',
			border: '5px solid #DFDFDF',
			pause_on_hover: true
		});
	});
</script>
