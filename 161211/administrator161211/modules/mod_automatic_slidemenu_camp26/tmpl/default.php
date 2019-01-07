<?php
/**
* Module Automatic SlideMenu For Joomla 1.5.x
* Versi			: 1.2
* Created by	: Reza Erauansyah
* Email			: old_smu17@yahoo.com
* Created on	: 09 November 2009
* Las Modified 	: --
* URL			: www.camp26.biz
* License GPLv2.0 - http://www.gnu.org/licenses/gpl-2.0.html
* Based on jquery(http://www.jquery.com)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$txtcolor				= $params->get( 'txtcolor' );
$fontsize				= $params->get( 'fontsize' );
$marginleft				= $params->get( 'margin_left' );
$baseurl 				= JURI::base();

$menu_status1 	= $params->get( 'menu_status1' );
$menu_img1 		= $params->get( 'menu_img1' );
$menu_url1 		= str_replace('&', '&amp;', $params->get( 'menu_url1' ));
$menu_txt1 		= $params->get( 'menu_txt1' );
$menu_txt1b 	= $params->get( 'menu_txt1b' );
$target_url1 	= $params->get( 'target_url1' );

$menu_status2 	= $params->get( 'menu_status2' );
$menu_img2		= $params->get( 'menu_img2' );
$menu_url2 		= str_replace('&', '&amp;', $params->get( 'menu_url2' ));
$menu_txt2 		= $params->get( 'menu_txt2' );
$menu_txt2b 	= $params->get( 'menu_txt2b' );
$target_url2 	= $params->get( 'target_url2' );

$menu_status3 	= $params->get( 'menu_status3' );
$menu_img3		= $params->get( 'menu_img3' );
$menu_url3 		= str_replace('&', '&amp;', $params->get( 'menu_url3' ));
$menu_txt3 		= $params->get( 'menu_txt3' );
$menu_txt3b 	= $params->get( 'menu_txt3b' );
$target_url3 	= $params->get( 'target_url3' );

$menu_status4 	= $params->get( 'menu_status4' );
$menu_img4		= $params->get( 'menu_img4' );
$menu_url4 		= str_replace('&', '&amp;', $params->get( 'menu_url4' ));
$menu_txt4 		= $params->get( 'menu_txt4' );
$menu_txt4b 	= $params->get( 'menu_txt4b' );
$target_url4 	= $params->get( 'target_url4' );

$menu_status5 	= $params->get( 'menu_status5' );
$menu_img5		= $params->get( 'menu_img5' );
$menu_url5 		= str_replace('&', '&amp;', $params->get( 'menu_url5' ));
$menu_txt5 		= $params->get( 'menu_txt5' );
$menu_txt5b 	= $params->get( 'menu_txt5b' );
$target_url5 	= $params->get( 'target_url5' );

$menu_status6 	= $params->get( 'menu_status6' );
$menu_img6		= $params->get( 'menu_img6' );
$menu_url6 		= str_replace('&', '&amp;', $params->get( 'menu_url6' ));
$menu_txt6 		= $params->get( 'menu_txt6' );
$menu_txt6b 	= $params->get( 'menu_txt6b' );
$target_url6 	= $params->get( 'target_url6' );

$menu_status7 	= $params->get( 'menu_status7' );
$menu_img7		= $params->get( 'menu_img7' );
$menu_url7 		= str_replace('&', '&amp;', $params->get( 'menu_url7' ));
$menu_txt7 		= $params->get( 'menu_txt7' );
$menu_txt7b 	= $params->get( 'menu_txt7b' );
$target_url7 	= $params->get( 'target_url7' );

$menu_status8 	= $params->get( 'menu_status8' );
$menu_img8		= $params->get( 'menu_img8' );
$menu_url8 		= str_replace('&', '&amp;', $params->get( 'menu_url8' ));
$menu_txt8 		= $params->get( 'menu_txt8' );
$menu_txt8b 	= $params->get( 'menu_txt8b' );
$target_url8 	= $params->get( 'target_url8' );

$menu_status9 	= $params->get( 'menu_status9' );
$menu_img9		= $params->get( 'menu_img9' );
$menu_url9 		= str_replace('&', '&amp;', $params->get( 'menu_url9' ));
$menu_txt9 		= $params->get( 'menu_txt9' );
$menu_txt9b 	= $params->get( 'menu_txt9b' );
$target_url9 	= $params->get( 'target_url9' );



echo "  <link rel=\"stylesheet\" href=\"".$baseurl."modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/likno.css\" type=\"text/css\" />";
echo "  <script type=\"text/javascript\" src=\"".$baseurl."modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/jquery-1.3.2.min.js\"></script>";
echo "  <script type=\"text/javascript\" src=\"".$baseurl."modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/divTogg.js\"></script>";
echo "  <script type=\"text/javascript\" src=\"".$baseurl."modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/jquery.easing.1.3.js\"></script>";


?>
<!-- automatic_slidemenu by Reza Erauansyah-->
<div style="margin-left:<?php echo $marginleft; ?>; text-align: left;">
		<div>
			<?php if ($menu_status1==1) { ?>
		    <div class="divToggle" id="divItem1">
				<div class="divHead divHeadHeader"><a href="<?php echo $menu_url1 ?>" target="<?php echo $target_url1; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img1 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
				<a href="<?php echo $menu_url1 ?>" target="<?php echo $target_url1; ?>" class="divBody divBodyHeader">
					<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt1; ?><br /><?php echo $menu_txt1b; ?></b></span></p>
				</a>
			</div>
			
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status2==1) { ?>
				<div class="divToggle" id="divItem2">
					<div class="divHead divHeadHeader"><a href="<?php echo $menu_url2 ?>" target="<?php echo $target_url2; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img2 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
					<a href="<?php echo $menu_url2 ?>" target="<?php echo $target_url2; ?>" class="divBody divBodyHeader">
						<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt2; ?><br /><?php echo $menu_txt2b; ?></b></span></p>
					</a>
				</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status3==1) { ?>
				<div class="divToggle" id="divItem3">
					<div class="divHead divHeadHeader"><a href="<?php echo $menu_url3 ?>" target="<?php echo $target_url3; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img3 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
					<a href="<?php echo $menu_url3 ?>" target="<?php echo $target_url3; ?>" class="divBody divBodyHeader">
						<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt3; ?><br /><?php echo $menu_txt3b; ?></b></span></p>
					</a>
				</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status4==1) { ?>
				<div class="divToggle" id="divItem4">
					<div class="divHead divHeadHeader"><a href="<?php echo $menu_url4 ?>" target="<?php echo $target_url1; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img4 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
					<a href="<?php echo $menu_url4 ?>" target="<?php echo $target_url4; ?>" class="divBody divBodyHeader">
						<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt4; ?><br /><?php echo $menu_txt4b; ?></b></span></p>
					</a>
				</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status5==1) { ?>
				<div class="divToggle" id="divItem5">
					<div class="divHead divHeadHeader"><a href="<?php echo $menu_url5 ?>" target="<?php echo $target_url5; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img5 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
					<a href="<?php echo $menu_url5 ?>" target="<?php echo $target_url5; ?>" class="divBody divBodyHeader">
						<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt5; ?><br /><?php echo $menu_txt5b; ?></b></span></p>
					</a>
				</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status6==1) { ?>
				<div class="divToggle" id="divItem6">
					<div class="divHead divHeadHeader"><a href="<?php echo $menu_url6 ?>" target="<?php echo $target_url6; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img6 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
					<a href="<?php echo $menu_url6 ?>" target="<?php echo $target_url6; ?>" class="divBody divBodyHeader">
						<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt6; ?><br /><?php echo $menu_txt6b; ?></b></span></p>
					</a>
				</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status7==1) { ?>
				<div class="divToggle" id="divItem7">
					<div class="divHead divHeadHeader"><a href="<?php echo $menu_url7 ?>" target="<?php echo $target_url7; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img7 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
					<a href="<?php echo $menu_url7 ?>" target="<?php echo $target_url7; ?>" class="divBody divBodyHeader">
						<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt7; ?><br /><?php echo $menu_txt7b; ?></b></span></p>
					</a>
				</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status8==1) { ?>
				<div class="divToggle" id="divItem8">
					<div class="divHead divHeadHeader"><a href="<?php echo $menu_url8 ?>" target="<?php echo $target_url8; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img8 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
					<a href="<?php echo $menu_url8 ?>" target="<?php echo $target_url8; ?>" class="divBody divBodyHeader">
						<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt8; ?><br /><?php echo $menu_txt8b; ?></b></span></p>
					</a>
				</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status9==1) { ?>
				<div class="divToggle" id="divItem9">
					<div class="divHead divHeadHeader"><a href="<?php echo $menu_url9 ?>" target="<?php echo $target_url9; ?>"><img src="<?php echo $baseurl?>/modules/mod_automatic_slidemenu_camp26/automatic_slidemenu/images/<?php echo $menu_img9 ?>" alt="AllWebMenus" width="36" height="36" border="0" /></a></div>
					<a href="<?php echo $menu_url9 ?>" target="<?php echo $target_url9; ?>" class="divBody divBodyHeader">
						<p><span style="color:<?php echo $txtcolor ?>;font-size:<?php echo $fontsize ?>;"><b><?php echo $menu_txt9; ?><br /><?php echo $menu_txt9b; ?></b></span></p>
					</a>
				</div>
			<?php } else { ?>
			<?php } ?>
			
						
			<div style="clear: both;"></div>

		</div>
		
			<script charset="UTF-8" type="text/javascript" >
			$(".divBody").css("display","none");
			jQuery(function() {
				$(".divBody").css("display","");
				var theGroup = createDivGroup({prefix:'divItem', type:'header-dual', vhm: 'horizontal', widen: true, effect:['width'], duration:500, minTrans:'jswing', 	maxTrans:'jswing', transOrder:'both', eventTrigger: 'mouseover', selectedDiv: '', clickableHeader: true});
				var allElements = theGroup.myElements.length;
				var curElement = 0;
				setInterval(function () { theGroup.myElements[curElement++ % allElements].myBody.toggleMe(); }, 3000);
			});
			</script>
			
</div>

