/**
 * @package Xpert Tabs
 * @version 1.1 January 27, 2011
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

if ($defined(window.jQuery) && $type(jQuery.noConflict)=='function') {
    jQuery.noConflict();
}

jQuery(document).ready( function(){  
    jQuery('#param-page').hide();   

    //Set default open/close settings
    jQuery('.acc_container').hide(); //Hide/close all containers
    jQuery('.acc_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

    //On Click
    jQuery('.acc_trigger').click(function(){
        if( jQuery(this).next().is(':hidden') ) { //If immediate next container is closed...
            jQuery('.acc_trigger').removeClass('active').next().slideUp(); //Remove all "active" state and slide up the immediate next container
            jQuery(this).toggleClass('active').next().slideDown(); //Add "active" state to clicked trigger and slide down the immediate next container
        }
        else{
            jQuery('.acc_trigger').removeClass('active');
            jQuery(this).next().slideUp();
        }
        return false; //Prevent the browser jump to the link anchor
    });

    
    //Joomla, k2 and modules  Accordion hide and show effect depend on content source.
    function showJoomla(){
        jQuery('.xt_joomla').addClass('active').slideDown();
        jQuery('.xt_k2').removeClass('active').hide();
        jQuery('.xt_mods').removeClass('active').hide();
    }
    function showK2(){
        jQuery('.xt_joomla').removeClass('active').hide();
        jQuery('.xt_mods').removeClass('active').hide();
        jQuery('.xt_k2').addClass('active').slideDown();
    }
    function showMods(){
        jQuery('.xt_joomla').removeClass('active').hide();
        jQuery('.xt_k2').removeClass('active').hide();
        jQuery('.xt_mods').addClass('active').slideDown();
    }
    
    //determine which settings is enable in content source and show related container
    switch(jQuery('#paramscontent_source').val()){
        case 'joomla':
            showJoomla();
            break;
        case 'k2':
            showK2();
            break;
        case 'mods':
            showMods();
            break;
    }
    
    //change accordion realtime 
    jQuery('#paramscontent_source').change(function(){
        switch(jQuery('#paramscontent_source').val()){
        case 'joomla':
            showJoomla();
            break;
        case 'k2':
            showK2();
            break;
        case 'mods':
            showMods();
            break;
    }
    });
});