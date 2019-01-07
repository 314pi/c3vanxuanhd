<?php
/*------------------------------------------------------------------------
 # Vt NewsTicker  - Version 1.0 - Licence Owner vThemes.Net
 # ------------------------------------------------------------------------
 # Copyright (C) 2009-2010 VThemes. All Rights Reserved.
 # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 # Author: vThemes.Net
 # Websites: http://www.vthemes.net
 -------------------------------------------------------------------------*/
 
 /**
 $items[0] = array(
		'img'=> 'images/img.jpg',
		'title' => 'this is a test',
		'content' => 'Companies know they have got it made when...<br/><b>Price: <span class="so_price">$12</span></b> <br/><a href="#">Read more..</a>',
		'link' => '#'
	);	
	$items[1] = array(
		'img'=> 'images/img1.jpg',
		'title' => 'this is a test',
		'content' => 'Companies know they have got it made when....<br/><b>Price: <span class="so_price">$12</span></b> <br/><a href="#">Read more..</a>',
		'link' => '#'
	);
	$items[2] = array(
		'img'=> 'images/img2.jpg',
		'title' => 'this is a test',
		'content' => 'Companies know they have got it made when...<br/><b>Price: <span class="so_price">$12</span></b> <br/><a href="#">Read more..</a>',
		'link' => '#'
	);
	$items[3] = array(
		'img'=> 'images/img3.jpg',
		'title' => 'this is a test',
		'content' => 'Companies know they have got it made when...<br/><b>Price: <span class="so_price">$12</span></b> <br/><a href="#">Add to Card</a>',
		'link' => '#'
	);
	$items[4] = array(
		'img'=> 'images/img4.jpg',
		'title' => 'this is a test',
		'content' => 'Companies know they have got it made when...<br/><b>Price: <span class="so_price">$12</span></b> <br/><a href="#">Add to Card</a>',
		'link' => '#'
	);
	$items[5] = array(
		'img'=> 'images/img5.jpg',
		'title' => 'this is a test',
		'content' => 'Companies know they have got it made when...<br/><b>Price: <span class="so_price">$12</span></b> <br/><a href="#">Add to Card</a>',
		'link' => '#'
	);
 **/
 
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if (! class_exists("Vthemes") ) { 
class Vthemes {
	
	public $id = '';	
	public $items = array();
	public $auto = '0';
	public $speed = '200';
	public $pause = '1';
	public $element_number = '1';
	public $btnNext = '';
	public $btnPre = '';	
	public $thumb_width = '40';
	public $thumb_height = '40';
	public $theme = 'basic';
	public $web_url = '';
	public $no_image_message = '';
	public $thumb_padding = '4';
	public $jquery_enable = '1';
	public $start = 0;
	public $scroll = '1';
	public $vertical = 0;
	/*Enable*/
	public $enable_navigation = '1';
	public $enable_summary = '1';
	public $enable_title = '1';
	public $enable_image = '1';
	public $enable_description = '1';
	public $showreadmore = 0;
	public $note = '';
	public $cropresizeimage = 0;
	public $max_title = 0;
	public $max_description = 0;
	public $resize_folder = '';
	public $url_to_resize = '';
	public $url_to_module = '';
	
				
	function process() {		
		$items = array();
		/*Check elements*/
		if (sizeof($this->items) < $this->element_number ) {
			 $this->element_number = sizeof($this->items);
		}
		
		
		foreach ($this->items as $key => $item) {
			if (!isset($item['sub_title'])) {
				$item['sub_title'] = $this->cutStr($item['title'], $this->max_title);
			}
			if (!isset($item['sub_content'])) {
				$item['sub_content'] = $this->cutStr($item['content'], $this->max_description);
			}
			
			if (!isset($item['thumb']) && $item['img'] != '') {
				$item['thumb'] = $this->processImage($item['img'], $this->thumb_width, $this->thumb_height);
			} else {
				$item['thumb'] = '';
			}		
			
			if ($item['thumb'] != '') {			
				$items[] = $item;
			}
		}		
		
		
		return $items;				
	}
	
	function processImage($img, $width, $height) {
				
		if ($this->cropresizeimage == 0) {
			return $this->resizeImage($img, $width, $height);
		} else {
			return $this->cropImage($img, $width, $height);
		}
	}
		
	function resizeImage($imagePath, $width, $height) {
		global $module;
		include_once("simpleimage.php");
		
		$folderPath = $this->resize_folder;
		 
		 if(!JFolder::exists($folderPath)){
		 		JFolder::create($folderPath);	 
		 }
		 
		 $nameImg = str_replace('/','',strrchr($imagePath,"/"));
			
		 $ext = substr($nameImg, strrpos($nameImg, '.'));
		
		 $file_name = substr($nameImg, 0,  strrpos($nameImg, '.'));
		
		 $nameImg = $file_name . "_" . $width . "_" . $height .  $ext;
		 
		 
		 if(!JFile::exists($folderPath.DS.$nameImg)){
			 $image = new SimpleImage();
	  		 $image->load($imagePath);
	  		 $image->resize($width,$height);
	   		 $image->save($folderPath.DS.$nameImg);
		 }else{
		 		 list($info_width, $info_height) = @getimagesize($folderPath.DS.$nameImg);
		 		 if($width!=$info_width||$height!=$info_height){
		 		 	 $image = new SimpleImage();
	  				 $image->load($imagePath);
	  				 $image->resize($width,$height);
	   				 $image->save($folderPath.DS.$nameImg);
		 		 }
		 }
   		 return $this->url_to_resize . $nameImg;
	}
	
	function cropImage($imagePath, $width, $height) {
		global $module;
		include_once("simpleimage.php");
		 $folderPath = $this->resize_folder;
		 
		 if(!JFolder::exists($folderPath)){
		 		JFolder::create($folderPath);	 
		 }
		 
		 $nameImg = str_replace('/','',strrchr($imagePath,"/"));		 
		 
		 if(!JFile::exists($folderPath.DS.$nameImg)){
			 $image = new SimpleImage();
	  		 $image->load($imagePath);
	  		 $image->crop($width,$height);
	   		 $image->save($folderPath.DS.$nameImg);
		 }else{
		 		 list($info_width, $info_height) = @getimagesize($folderPath.DS.$nameImg);
		 		 if($width!=$info_width||$height!=$info_height){
		 		 	 $image = new SimpleImage();
	  				 $image->load($imagePath);
	  				 $image->crop($width,$height);
	   				 $image->save($folderPath.DS.$nameImg);
		 		 }
		 }
		 
   		 return $this->url_to_resize . $nameImg;
	}
	
	/*Cut string*/
	function cutStr( $str, $number){
		//If length of string less than $number
		$str = strip_tags($str);
		if(strlen($str) <= $number){
			return $str;
		}
		$str = substr($str,0,$number);
	
		$pos = strrpos($str,' ');
	
		return substr($str,0,$pos).'...';
	}
	
}
}
?>