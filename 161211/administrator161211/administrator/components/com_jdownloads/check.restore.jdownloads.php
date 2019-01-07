<?php
/**
* @version 1.6
* @package JDownloads
* @copyright (C) 2009 www.jdownloads.com
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* functions to check db after restore backup file!
*
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
  

function checkAfterRestore() {
    global $jlistConfig;
    $database = &JFactory::getDBO();

    // insert the new default header, subheader and footer layouts in every layout.
    require_once(JPATH_SITE."/administrator/components/com_jdownloads/jd_layouts.php");

    
  //*********************************************
  // JD VERSION:
     $jd_version = '1.8.2';
     $jd_version_state = 'Stable';
     $jd_version_svn = '855'; 
  //*********************************************
    
    $output = '';
    
//********************************************************************************************
// insert default config data - if not exist
// *******************************************************************************************
      $root_dir = '';
      $sum_configs = 0;
      
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'files.uploaddir'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('files.uploaddir', 'jdownloads')");
            $database->query();
            $sum_configs++;
        }  else {
            $database->setQuery("SELECT setting_value FROM #__jdownloads_config WHERE setting_name = 'files.uploaddir'");
            $dir = $database->loadResult();
            $root_dir = JPATH_SITE.'/'.$dir.'/';   
        }    

        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'global.datetime'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('global.datetime', '".JText::_('JLIST_INSTALL_DEFAULT_DATE_FORMAT')."')");
            $database->query();
            $sum_configs++;
        } else {
            $database->setQuery("UPDATE #__jdownloads_config SET setting_value = '".JText::_('JLIST_INSTALL_DEFAULT_DATE_FORMAT')."' WHERE setting_name = 'global.datetime'");
            $database->query();
            $jlistConfig['global.datetime'] = JText::_('JLIST_INSTALL_DEFAULT_DATE_FORMAT');
        }

        // new param für versionsnummer von jd
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'jd.version'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('jd.version','$jd_version')");
            $database->query();
            $sum_configs++;
        } else {
            // set new value
            $database->setQuery("UPDATE #__jdownloads_config SET setting_value = '$jd_version' WHERE setting_name = 'jd.version'");  
            $database->query();
        } 
        
        // new param für versions status von jd
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'jd.version.state'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('jd.version.state','$jd_version_state')");
            $database->query();
            $sum_configs++;
        } else {
            // set new value
            $database->setQuery("UPDATE #__jdownloads_config SET setting_value = '$jd_version_state' WHERE setting_name = 'jd.version.state'");  
            $database->query();
        }    

        // new param für svn version von jd
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'jd.version.svn'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('jd.version.svn','$jd_version_svn')");
            $database->query();
            $sum_configs++;
        } else {
            // set new value
            $database->setQuery("UPDATE #__jdownloads_config SET setting_value = '$jd_version_svn' WHERE setting_name = 'jd.version.svn'");  
            $database->query();
        }

         // new in 1.5
        
        // options for config: view detail information site - default on 
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'view.detailsite'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('view.detailsite', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('check.leeching', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('allowed.leeching.sites', '')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('block.referer.is.empty', '0')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.author', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.author.url', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.release', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.price', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.license', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.language', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.system', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.pic.upload', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.desc.long', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('mp3.player.config', 'loop=0;showvolume=1;showstop=1;bgcolor1=006699;bgcolor2=66CCFF')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('mp3.view.id3.info', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.php.script.for.download', '1')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('mp3.info.layout', '".$JLIST_BACKEND_SETTINGS_TEMPLATES_ID3TAG."')");
            $database->query();
            $sum_configs++;
        }
        // added in v1.5.1
        // for pad file support
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'pad.exists'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pad.exists', '0')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pad.use', '0')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pad.folder', 'padfiles')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pad.language', 'English')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('google.adsense.active', '0')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('google.adsense.code', '')");
            $database->query();
            $sum_configs++;

            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('countdown.active', '0')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('countdown.start.value', '60')");
            $database->query();
            $sum_configs++;
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('countdown.text', '".JText::_('JLIST_BACKEND_SETTINGS_WAITING_NOTE_TEXT')."')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.extern.file', '0')");
            $database->query();
            $sum_configs++;

            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.select.file', '1')");
            $database->query();
            $sum_configs++;            

            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fe.upload.view.desc.short', '1')");
            $database->query();
            $sum_configs++; 
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fix.upload.filename.blanks', '1')");
            $database->query();
            $sum_configs++;            
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fix.upload.filename.uppercase', '1')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('fix.upload.filename.specials', '1')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.report.download.link', '1')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('send.mailto.report', '')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('download.pic.files', 'download2.png')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('view.sum.jcomments', '1')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('change.cyrillic.chars', '1')");
            $database->query();
            $sum_configs++;  
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('be.new.files.order.first', '1')");
            $database->query();
            $sum_configs++;
            
        }
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'downloads.footer.text'");
        $temp = $database->loadResult();
        if (!$temp) {             
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('downloads.footer.text', '')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('view.back.button', '1')");
            $database->query();
            $sum_configs++;
                                                                                                                                            
        }
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'create.auto.cat.dir'");
        $temp = $database->loadResult();
        if (!$temp) {   
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('create.auto.cat.dir', '1')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('reset.counters', '0')");
            $database->query();
            $sum_configs++;
        }

        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'report.link.only.regged'");
        $temp = $database->loadResult();
        if (!$temp) {   
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('report.link.only.regged', '1')");
            $database->query();
            $sum_configs++;
        }
        
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'view.ratings'");
        $temp = $database->loadResult();
        if (!$temp) {   
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('view.ratings', '1')");
            $database->query();
            $sum_configs++;                    
        }
        
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'rating.only.for.regged'");
        $temp = $database->loadResult();
        if (!$temp) {   
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('rating.only.for.regged', '0')");
            $database->query();
            $sum_configs++;                    
        }
        
        // added in version 1.7.0
        // **********************
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'view.also.download.link.text'");
        $temp = $database->loadResult();
        if (!$temp) {   
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('view.also.download.link.text', '1')");
            $database->query();
            $sum_configs++;                    
        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('auto.file.short.description', '0')");
            $database->query();
            $sum_configs++;                    

            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('auto.file.short.description.value', '200')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('view.jom.comment', '0')");
            $database->query();
            $sum_configs++; 
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.lightbox.function', '1')");
            $database->query();
            $sum_configs++;                               
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.alphauserpoints', '0')");
            $database->query();
            $sum_configs++;
            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.alphauserpoints.with.price.field', '0')");
            $database->query();
            $sum_configs++;

            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('user.can.download.file.when.zero.points', '1')");
            $database->query();
            $sum_configs++;

            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('user.message.when.zero.points', '".JText::_('JLIST_BACKEND_SET_AUP_FE_MESSAGE_NO_DOWNLOAD')."')");
            $database->query();
            $sum_configs++;
                         
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('limited.download.number.per.day', '0')");
            $database->query();
            $sum_configs++;                    

            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('limited.download.reached.message', '".JText::_('JLIST_FE_MESSAGE_AMOUNT_FILES_LIMIT')."')");
            $database->query();
            $sum_configs++;                                
        
        }            
  
        // added in version 1.7.4 for content plugin
        // **********************
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'download.pic.plugin'");
        $temp = $database->loadResult();
        if (!$temp) {   
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('download.pic.plugin', 'download2.png')");
            $database->query();
            $sum_configs++;                    
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('plugin.auto.file.short.description', '0')");
            $database->query();
            $sum_configs++;                    
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('plugin.auto.file.short.description.value', '200')");
            $database->query();
            $sum_configs++;                    
        }
        
        // added in version 1.8
        // **********************
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'view.sort.order'");
        $temp = $database->loadResult();
        if (!$temp) {   
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('view.sort.order', '1')");
            $database->query();
            $sum_configs++;
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('activate.general.plugin.support', '0')");
            $database->query();
            $sum_configs++;
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('activate.download.log', '0')");
            $database->query();
            $sum_configs++;                                
            $database->setQuery("SELECT setting_value FROM #__jdownloads_config WHERE setting_name = 'files.per.side'");
            $temp = $database->loadResult();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('categories.per.side', '$temp')");
            $database->query();
            $sum_configs++;        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('upload.access.group', '0')");
            $database->query();
            $sum_configs++;        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('redirect.after.download', '0')");
            $database->query();
            $sum_configs++;  
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.tabs.type', '0')");
            $database->query();
            $sum_configs++;                  
        } 
        
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'additional.tab.title.1'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('additional.tab.title.1', '".JText::_('JLIST_FE_TAB_CUSTOM_TITLE')."')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('additional.tab.title.2', '".JText::_('JLIST_FE_TAB_CUSTOM_TITLE')."')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('additional.tab.title.3', '".JText::_('JLIST_FE_TAB_CUSTOM_TITLE')."')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('remove.field.title.when.empty', '0')");
            $database->query(); 
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.download.title.as.download.link', '0')");
            $database->query(); 
            $sum_configs = $sum_configs + 5;
        }
            
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'custom.field.6.title'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.1.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.2.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.3.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.4.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.5.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.6.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.7.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.8.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.9.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.10.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.11.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.12.title', '')");
            $database->query();            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.13.title', '')");
            $database->query();            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.14.title', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.1.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.2.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.3.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.4.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.5.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.6.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.7.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.8.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.9.values', '')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('custom.field.10.values', '')");
            $database->query();
            $sum_configs = $sum_configs + 24;                        
        }

        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'group.can.edit.fe'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('group.can.edit.fe', '0')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('uploader.can.edit.fe', '0')");
            $database->query();
            $sum_configs = $sum_configs + 2;                        
        }
        
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'use.sef.with.file.titles'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.sef.with.file.titles', '1')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.general.plugin.support.only.for.descriptions', '0')");
            $database->query();
            $sum_configs = $sum_configs + 2;                        
        }
        
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'com'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('com', '')");
            $database->query();        
        }
        
        // added in 1.8.2
        $database->setQuery("SELECT * FROM #__jdownloads_config WHERE setting_name = 'use.blocking.list'");
        $temp = $database->loadResult();
        if (!$temp) {
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('use.blocking.list', '0')");
            $database->query();        
            $blocking_list = file_get_contents ( JPATH_SITE.'/administrator/components/com_jdownloads/blacklist.txt' );
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('blocking.list', '$blocking_list')");
            $database->query();        
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('remove.empty.tags', '0')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('create.pdf.thumbs', '0')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('create.pdf.thumbs.by.scan', '0')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pdf.thumb.height', '200')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pdf.thumb.width', '200')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pdf.thumb.pic.height', '400')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pdf.thumb.pic.width', '400')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('pdf.thumb.image.type', 'GIF')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('create.auto.thumbs.from.pics', '0')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('create.auto.thumbs.from.pics.image.height', '400')");
            $database->query();
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('create.auto.thumbs.from.pics.image.width', '400')");
            $database->query();            
            $database->SetQuery("INSERT INTO #__jdownloads_config (setting_name, setting_value) VALUES ('create.auto.thumbs.from.pics.by.scan', '0')");
            $database->query();
            $sum_configs = $sum_configs + 14;         
        }    
                          
        if ($sum_configs == 0) {
            $output .= '<font color="green"><strong> '.JText::_('JLIST_INSTALL_1').'</strong></font><br />';
        } else {
            $output .= '<font color="green"> '.$sum_configs.' '.JText::_('JLIST_INSTALL_2').'</font><br />';
        }

        //***************************** config data end **********************************************

        $sum_added_fields = 0;
        $prefix = $database->_table_prefix;
        $tables = array( $prefix.'jdownloads_templates' );
        $result = $database->getTableFields( $tables );
        
        if (!$result[$prefix.'jdownloads_templates']['cols']){
            $database->SetQuery("ALTER TABLE #__jdownloads_templates ADD cols TINYINT(1) NOT NULL DEFAULT 1 AFTER note");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }
        
        // false fieldname delete from prior svn if exist
        if ($result[$prefix.'jdownloads_templates']['columns']){
            $database->SetQuery("ALTER TABLE #__jdownloads_templates DROP columns");
        }
        
        // new alias fields
        $tables = array( $prefix.'jdownloads_cats' );
        $result = $database->getTableFields( $tables );
        if (!$result[$prefix.'jdownloads_cats']['cat_alias']){
            $database->SetQuery("ALTER TABLE #__jdownloads_cats ADD cat_alias varchar(255) NOT NULL default '' AFTER cat_title");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }
        // new alias fields
        $tables = array( $prefix.'jdownloads_files' );
        $result = $database->getTableFields( $tables );
        if (!$result[$prefix.'jdownloads_files']['file_alias']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD file_alias varchar(255) NOT NULL default '' AFTER file_title");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }        
        // new field for created file user-id - submitted by id
        if (!$result[$prefix.'jdownloads_files']['submitted_by']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD submitted_by INT(11) NOT NULL default '0' AFTER modified_date");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }

        // new field for add AUP points when published
        if (!$result[$prefix.'jdownloads_files']['set_aup_points']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD set_aup_points TINYINT(1) NOT NULL default '0' AFTER submitted_by");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }          
        
        // new field for file date
        if (!$result[$prefix.'jdownloads_files']['file_date']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD file_date datetime NOT NULL default '0000-00-00 00:00:00' AFTER date_added");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }       
        // new field for publish date
        if (!$result[$prefix.'jdownloads_files']['publish_from']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD publish_from datetime NOT NULL default '0000-00-00 00:00:00' AFTER file_date");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }       
        // new field for publish date
        if (!$result[$prefix.'jdownloads_files']['publish_to']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD publish_to datetime NOT NULL default '0000-00-00 00:00:00' AFTER publish_from");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }   
        // new field for use publish from and end date
        if (!$result[$prefix.'jdownloads_files']['use_timeframe']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD use_timeframe TINYINT(1) NOT NULL default '0' AFTER publish_to");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        } 
        // new thumbnail fields
        if (!$result[$prefix.'jdownloads_files']['thumbnail2']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD thumbnail2 varchar(255) NOT NULL default '' AFTER thumbnail");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }                

        if (!$result[$prefix.'jdownloads_files']['thumbnail3']){
            $database->SetQuery("ALTER TABLE #__jdownloads_files ADD thumbnail3 varchar(255) NOT NULL default '' AFTER thumbnail2");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        } 
  
        // add new custom fields when not exists
        if (!$result[$prefix.'jdownloads_files']['custom_field_3']){
            $database->SetQuery("ALTER table #__jdownloads_files add "
            . " custom_field_1 tinyint(2) NOT NULL default '0',"
            . " add custom_field_2 tinyint(2) NOT NULL default '0',"
            . " add custom_field_3 tinyint(2) NOT NULL default '0',"
            . " add custom_field_4 tinyint(2) NOT NULL default '0',"
            . " add custom_field_5 tinyint(2) NOT NULL default '0',"
            . " add custom_field_6 varchar(255) NOT NULL default '',"
            . " add custom_field_7 varchar(255) NOT NULL default '',"
            . " add custom_field_8 varchar(255) NOT NULL default '',"
            . " add custom_field_9 varchar(255) NOT NULL default '',"
            . " add custom_field_10 varchar(255) NOT NULL default '',"
            . " add custom_field_11 date NOT NULL default '0000-00-00',"        
            . " add custom_field_12 date NOT NULL default '0000-00-00',"                  
            . " add custom_field_13 TEXT NOT NULL default '',"                  
            . " add custom_field_14 TEXT NOT NULL default '' AFTER update_active");
            if ($database->query()) {
                $sum_added_fields = $sum_added_fields + 14;        
            }
            $database->SetQuery("ALTER table #__jdownloads_files add license_agree tinyint(1) NOT NULL default '0' AFTER url_license");
            if ($database->query()) {
                $sum_added_fields++;        
            }        
        }  
        
        $tables = array( $prefix.'jdownloads_cats' );
        $result = $database->getTableFields( $tables );
        $database->SetQuery("ALTER TABLE #__jdownloads_cats CHANGE ordering ordering int(11) NOT NULL default '0'");
        $database->query();
        
       // new groups field
        $tables = array( $prefix.'jdownloads_cats' );
        $result = $database->getTableFields( $tables );
        if (!$result[$prefix.'jdownloads_cats']['cat_group_access']){
            $database->SetQuery("ALTER TABLE #__jdownloads_cats ADD cat_group_access int(11) NOT NULL default '0' AFTER cat_access");
            if ($database->query()) {
            $sum_added_fields++;
            }    
        }
                   

        if ($sum_added_fields == 0) {
            $output .= "<font color='green'><strong> ".JText::_('JLIST_INSTALL_1_2')."</strong></font><br />";
        } else {
            $output .= "<font color='green'> ".$sum_added_fields." ".JText::_('JLIST_INSTALL_2_2')."</font><br />";        
        }
        
        // new  categories layout with 4 columns
        $database->setQuery("SELECT * FROM #__jdownloads_templates WHERE template_typ = '1' AND locked = '1' AND template_name ='".JText::_('JLIST_BACKEND_SETTINGS_TEMPLATES_CATS_COL_TITLE')."'");
        $temp = $database->loadResult();
        if (!$temp) {
            $file_layout = stripslashes($JLIST_BACKEND_SETTINGS_TEMPLATES_CATS_COL_DEFAULT); 
            $database->setQuery("INSERT INTO #__jdownloads_templates (template_name, template_typ, template_text, template_active, locked, note, cols)  VALUES ('".JText::_('JLIST_BACKEND_SETTINGS_TEMPLATES_CATS_COL_TITLE')."', 1, '".$file_layout."', 0, 1, '".JText::_('JLIST_BACKEND_SETTINGS_TEMPLATES_CATS_COL_NOTE')."', 4)");
            $database->query();
            $sum_layouts++;
        }
        // layout for download details with tabs
        $database->setQuery("SELECT * FROM #__jdownloads_templates WHERE template_typ = '5' AND locked = '1' AND  template_name ='".JText::_('JLIST_BACKEND_SETTINGS_TEMPLATES_DETAILS_WITH_TABS_TITLE')."'");
        $temp = $database->loadResult();
        if (!$temp){
            $detail_layout = stripslashes($JLIST_BACKEND_SETTINGS_TEMPLATES_DETAILS_DEFAULT_WITH_TABS);
            $database->setQuery("INSERT INTO #__jdownloads_templates (template_name, template_typ, template_text, template_active, locked)  VALUES ('".JText::_('JLIST_BACKEND_SETTINGS_TEMPLATES_DETAILS_WITH_TABS_TITLE')."', 5, '$detail_layout', '0', 1)");
            $database->query();
            $sum_layouts++;
        }    


        // cat layouts
        $database->setQuery("UPDATE #__jdownloads_templates SET template_header_text = '$cats_header', template_subheader_text = '$cats_subheader', template_footer_text = '$cats_footer' WHERE template_typ = '1' AND template_header_text = ''");
        $database->query();
        // file layouts
        $database->setQuery("UPDATE #__jdownloads_templates SET template_header_text = '$files_header', template_subheader_text = '$files_subheader', template_footer_text = '$files_footer' WHERE template_typ = '2' AND template_header_text = ''");
        $database->query();
        //details layouts
        $database->setQuery("UPDATE #__jdownloads_templates SET template_header_text = '$details_header', template_subheader_text = '$details_subheader', template_footer_text = '$details_footer' WHERE template_typ = '5' AND template_header_text = ''");
        $database->query();
        // summary layouts
        $database->setQuery("UPDATE #__jdownloads_templates SET template_header_text = '$summary_header', template_subheader_text = '$summary_subheader', template_footer_text = '$summary_footer' WHERE template_typ = '3' AND template_header_text = ''");
        $database->query();
         
        checkAlias();
   
   return $output;
}      
?>