<?php
/*------------------------------------------------------------------------
 # Vt NewsTicker  - Version 1.0 - YouTech Club
 # ------------------------------------------------------------------------
 # Copyright (C) 2009-2010 YouTech Club. All Rights Reserved.
 # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 # Author: Ytcvn.Com
 # Websites: http://www.ytcvn.com
 -------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );


?>
<script language="javascript">	
	jYTC(document).ready(function() {			
		newsTicker("ticker");		
	});
</script>

<div id="tickerContainer">
  <dl id="ticker" style="width:<?php echo $width == 0 ? "100%" : $width.'px'?>;height:<?php echo $height?>px" class="ticker">
    <?php
			foreach($items as $item) {
		?>
    <dt class="heading">
    	<img width="9" height="11" align="absmiddle" src="modules/mod_vt_newsticker/red_point.gif">
      <a href="<?php echo $item['link']?>" title="<?php echo $item['title']?>"><?php echo $item['sub_title']?></a>
    </dt>
    <dd class="text">	  
	  <?php if($enable_image == 1) :?>
	   <img src="<?php echo $item['thumb']?>" <?php echo $enable_description == 1 ? "align='left' style='padding-right: 5px;'" : ''?> />
	   <?php endif;?>
	   <?php if($enable_description == 1) :?>
	  <p><?php echo $item['sub_content']?></p>
	  <?php endif;?>
	  <?php if($showreadmore == 1) :?>
	  <p class="read-more"> <a href="<?php echo $item['link']?>" class="more"><?php echo JText::_("Read more...")?></a> </p>
	  <?php endif;?>	 
    </dd>
    <!-- /detail -->
    <?php
		}
		?>
  </dl>
</div>
