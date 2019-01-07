/**
* @version 1.1.4 stable
* @package DJ Image Slider
* @subpackage DJ Image Slider Module
* @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: http://design-joomla.eu
* @author email contact@design-joomla.eu
* @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
*
*
* DJ Image Slider is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* DJ Image Slider is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with DJ Image Slider. If not, see <http://www.gnu.org/licenses/>.
*
*/

var onChangeActiveTab = null;

var DJImageTabber = new Class ({
	initialize: function(id,options) {
		this.id = id;
		this.autoplay = options.auto;
		this.interval = options.delay;
		this.duration = options.duration;
		this.tabheight = options.tabheight;
		this.effectType = options.effect;
		this.height = options.height;
		this.effect = 'opacity';
		this.effectStart = '0';
		this.effectEnd = '1';
		if (this.effectType == 'slide') {
			this.effect = 'top';
			this.effectStart = -1 * (this.height + 20);
			this.effectEnd = '0';			
		}
		this.current = 0;
		this.playing = 1;
		this.container = '#djimagetabber_' + this.id;
		this.imagecontainer = '#djimagetabber-images_' + this.id;
		this.tabcontainer = '#djimagetabber-tabs_' + this.id;
		this.arrowcontainer = 'djimagetabber-ind_';
		this.arrow = $(this.arrowcontainer + this.id);
		this.arrowCurrentPos = (this.tabheight - parseInt(this.arrow.getStyle('height')))/2;;
		this.items = $$(this.imagecontainer + ' .djimagetabber-image');
		this.tabs = $$(this.tabcontainer + ' .djimagetabber-tab');
		if(this.total = this.items.length) {
			this.cssSetup();
			this.navSetup();
			this.autoPlay();
		}
		
	},
	cssSetup: function(){
		for (i=0; i < this.items.length; i++) {
			if (i == 0) {
				this.items[i].fx = new Fx.Style(this.items[i],this.effect, {wait: false, duration: this.duration}).set(this.effectEnd);
			}
			else {
				this.items[i].fx = new Fx.Style(this.items[i],this.effect, {wait: false, duration: this.duration}).set(this.effectStart);
			}
		}
		this.tabs[0].addClass('tab-active');
		this.arrowFx =  new Fx.Style(this.arrow,'top', {transition: Fx.Transitions.Back.easeInOut, wait: false, duration: this.duration}).set(this.arrowCurrentPos);
	},
	navSetup: function(){
		this.tabs.each(function(tab,index){
			tab.addEvents({
				'click': function(){
							this.loadItem(index);
						}.bind(this),
						
				'mouseenter': function() {
					this.playing = 0;
				}.bind(this),
				
				'mouseleave': function() {
					this.playing = 1;
				}.bind(this)
			});
		}.bind(this));
	},
	loadPrev: function(){
		if (this.current == 0) {
			this.loadItem(this.total-1);
		}
		else {
			this.loadItem(this.current-1);
		}
	},
	loadNext: function(){
		if (this.current == (this.total-1)) {
			this.loadItem(0);
		}
		else {
			this.loadItem(this.current+1);
		}
	},
	loadItem: function(i) {
		if(this.current == i) return;
		
		if (this.effectType == 'slide') {
			if (i >= this.current) {
				this.items[this.current].fx.start(this.effectEnd, this.effectStart);
				this.items[i].fx.start((this.effectStart * -1), this.effectEnd);
			}
			else {
				this.items[this.current].fx.start(this.effectEnd, (this.effectStart * -1));
				this.items[i].fx.start((this.effectStart), this.effectEnd);
			}
		}
		else {
			this.items[this.current].fx.start(this.effectEnd, this.effectStart);
			this.items[i].fx.start(this.effectStart, this.effectEnd);
		}
		
		this.tabs[this.current].removeClass('tab-active');
		this.tabs[i].addClass('tab-active');
		this.current = i;
		offset = (this.tabheight - parseInt(this.arrow.getStyle('height')))/2;
		arrowNewPos = (i * this.tabheight) + offset;
		this.arrowFx.start(this.arrowCurrentPos, arrowNewPos);
		this.arrowCurrentPos = arrowNewPos;
		if($defined(onChangeActiveTab)) onChangeActiveTab();
	},
	autoPlay: function() {
			(function(){
				if (this.autoplay == 1 && this.playing == 1) {
					this.loadNext();
					this.autoPlay();
				}
				else if (this.autoplay == 1) {
					this.autoPlay();
				}
			}).delay(this.interval, this);
	} 
});
