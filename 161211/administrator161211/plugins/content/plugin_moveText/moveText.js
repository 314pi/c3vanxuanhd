/*moving text Plugin
*@author Sakis Terzis @ breakDesigns.net
* @copyright	Copyright (C) 2008 breakDesigns.net
 * @license		GNU/GPL, see LICENSE.php
 *more info @ joomla.breakdesigns.net
 *developer Terzis Sakis
 * Updated version by Martin Rose - toughtomato.com  
*/

// JavaScript Document
window.addEvent('domready', function(){
divs=$$('.movingObj');//takes all the spans

 
var initspeed;
var topSpeed;
var intId;
var textDiv=new Array;
var widths=new Array;
var topSpeed=new Array;
var curSpeed=new Array;
var tables=new Array;
var contenPanes=new Array;

function getWidth(){
	if (arguments.callee.done) return;
	 arguments.callee.done = true;


	
	initspeed=maskwidth;
	var widdth=maskwidth+'px';
	var div=$$('#maskBlock');
	
	for(var k=0; k<div.length; k++){	
		div[k].setStyle('width',widdth);	
	}
	
	for(var i=0; i<divs.length; i++){		
		divs[i].setStyle('position','relative');
		topSpeed.push(divs[i].offsetWidth);
		curSpeed.push(initspeed);
					
		}
	intId=setInterval(function(){ moveText(divs,curSpeed,topSpeed,speed)  ;},time);
}


function moveText(divId,dist,endPoint,speed){

	for(var j=0; j<divId.length; j++){
		divId[j].setStyle('left',dist[j]+'px');	
		dist[j]-=speed;
		
		if(dist[j]<=(-endPoint[j])){
			dist[j]=initspeed;
		}
	}
}

divs.addEvent('mouseover',function(){
  clearInterval(intId);
})

divs.addEvent('mouseout',function(){
  intId=setInterval(function(){ moveText(divs,curSpeed,topSpeed,speed)  ;},time);
})
getWidth(); 
});

	
