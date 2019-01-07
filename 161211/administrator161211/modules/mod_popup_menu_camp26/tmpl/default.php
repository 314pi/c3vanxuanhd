<?php
/**
* Module PopUp Menu For Joomla 1.5.x
* Versi			: 1.0
* Created by	: Reza Erauansyah
* Email			: old_smu17@yahoo.com
* Created on	: 26 January 2010
* Las Modified 	: -
* URL			: www.camp26.biz
* License GPLv2.0 - http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$txtcolor				= $params->get( 'txtcolor' );
$js_system 				= $params->get( 'js_system' );
$baseurl 				= JURI::base();

$menu_status1 	= $params->get( 'menu_status1' );
$menu_img1 		= $params->get( 'menu_img1' );
$menu_url1 		= str_replace('&', '&amp;', $params->get( 'menu_url1' ));
$menu_txt1 		= $params->get( 'menu_txt1' );
$target_url1 	= $params->get( 'target_url1' );

$menu_status2 	= $params->get( 'menu_status2' );
$menu_img2		= $params->get( 'menu_img2' );
$menu_url2 		= str_replace('&', '&amp;', $params->get( 'menu_url2' ));
$menu_txt2 		= $params->get( 'menu_txt2' );
$target_url2 	= $params->get( 'target_url2' );

$menu_status3 	= $params->get( 'menu_status3' );
$menu_img3		= $params->get( 'menu_img3' );
$menu_url3 		= str_replace('&', '&amp;', $params->get( 'menu_url3' ));
$menu_txt3 		= $params->get( 'menu_txt3' );
$target_url3 	= $params->get( 'target_url3' );

$menu_status4 	= $params->get( 'menu_status4' );
$menu_img4		= $params->get( 'menu_img4' );
$menu_url4 		= str_replace('&', '&amp;', $params->get( 'menu_url4' ));
$menu_txt4 		= $params->get( 'menu_txt4' );
$target_url4 	= $params->get( 'target_url4' );

$menu_status5 	= $params->get( 'menu_status5' );
$menu_img5		= $params->get( 'menu_img5' );
$menu_url5 		= str_replace('&', '&amp;', $params->get( 'menu_url5' ));
$menu_txt5 		= $params->get( 'menu_txt5' );
$target_url5 	= $params->get( 'target_url5' );

$menu_status6 	= $params->get( 'menu_status6' );
$menu_img6		= $params->get( 'menu_img6' );
$menu_url6 		= str_replace('&', '&amp;', $params->get( 'menu_url6' ));
$menu_txt6 		= $params->get( 'menu_txt6' );
$target_url6 	= $params->get( 'target_url6' );


echo "  <link rel=\"stylesheet\" href=\"".$baseurl."modules/mod_popup_menu_camp26/popup_menu/menu.css\" type=\"text/css\" />";
if ($js_system) {
echo "  <script type=\"text/javascript\" src=\"".$baseurl."modules/mod_popup_menu_camp26/popup_menu/jquery.js\"></script>";
}
echo "  <script type=\"text/javascript\" src=\"".$baseurl."modules/mod_popup_menu_camp26/popup_menu/stack.js\"></script>";

?>

<div id="laskarstack" class="laskarstack" style="position: fixed; bottom: 28px; right: 40px; ">
		<img style="padding-top: 35px;" src="<?php echo $baseurl; ?>/modules/mod_popup_menu_camp26/popup_menu/images/stack.png" alt="stack">
		<ul style="top: -50px; left: 10px; margin: 0;" id="stack">
		<?php if ($menu_status1==1) { ?>
			<li style="top: 55px; left: -10px; padding:0;background: none; border: none;">
				<a href="<?php echo $menu_url1 ?>" target="<?php echo $target_url1; ?>" style="padding: 0; border: none; background: none;" ><span style="margin-right: 0px; color: <?php echo $txtcolor; ?>"><?php echo $menu_txt1 ?></span><img style="width: 79px; display: inline; margin-left: 0px;" src="<?php echo $baseurl?>/modules/mod_popup_menu_camp26/popup_menu/images/<?php echo $menu_img1 ?>" alt="popupmenu"></a>
			</li>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status2==1) { ?>
			<li style="top: 55px; left: -10px;padding:0;background: none; border: none;">
				<a href="<?php echo $menu_url2 ?>" target="<?php echo $target_url2; ?>"  style="padding: 0; border: none; background: none;" ><span style="margin-right: 0px; color: <?php echo $txtcolor; ?>"><?php echo $menu_txt2 ?></span><img style="width: 79px; display: inline; margin-left: 0px;" src="<?php echo $baseurl?>/modules/mod_popup_menu_camp26/popup_menu/images/<?php echo $menu_img2 ?>" alt="popupmenu"></a>
			</li>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status3==1) { ?>
			<li style="top: 55px; left: -10px;padding:0;background: none; border: none;">
				<a href="<?php echo $menu_url3 ?>" target="<?php echo $target_url3; ?>"  style="padding: 0; border: none; background: none;" ><span style="margin-right: 0px; color: <?php echo $txtcolor; ?>"><?php echo $menu_txt3 ?></span><img style="width: 79px; display: inline; margin-left: 0px;" src="<?php echo $baseurl?>/modules/mod_popup_menu_camp26/popup_menu/images/<?php echo $menu_img3 ?>" alt="popupmenu"></a>
			</li>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status4==1) { ?>
			<li style="top: 55px; left: -10px;padding:0;background: none; border: none;">
				<a href="<?php echo $menu_url4 ?>" target="<?php echo $target_url4; ?>"  style="padding: 0; border: none; background: none;" ><span style="margin-right: 0px; color: <?php echo $txtcolor; ?>"><?php echo $menu_txt4 ?></span><img style="width: 79px; display: inline; margin-left: 0px;" src="<?php echo $baseurl?>/modules/mod_popup_menu_camp26/popup_menu/images/<?php echo $menu_img4 ?>" alt="popupmenu"></a>
			</li>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status5==1) { ?>
			<li style="top: 55px; left: -10px;padding:0;background: none; border: none;">
				<a href="<?php echo $menu_url5 ?>" target="<?php echo $target_url5; ?>" style="padding: 0; border: none; background: none;"  ><span style="margin-right: 0px; color: <?php echo $txtcolor; ?>"><?php echo $menu_txt5 ?></span><img style="width: 79px; display: inline; margin-left: 0px;" src="<?php echo $baseurl?>/modules/mod_popup_menu_camp26/popup_menu/images/<?php echo $menu_img5 ?>" alt="popupmenu"></a>
			</li>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($menu_status6==1) { ?>
			<li style="top: 55px; left: -10px;padding:0; background: none; border: none;">
				<a href="<?php echo $menu_url6 ?>" target="<?php echo $target_url6; ?>"  style="padding: 0; border: none; background: none;" ><span style="margin-right: 0px; color: <?php echo $txtcolor; ?>"><?php echo $menu_txt6 ?></span><img style="width: 79px; display: inline; margin-left: 0px;" src="<?php echo $baseurl?>/modules/mod_popup_menu_camp26/popup_menu/images/<?php echo $menu_img6 ?>" alt="popupmenu"></a>
			</li>
			<?php } else { ?>
			<?php } ?>			
</ul>
</div>

