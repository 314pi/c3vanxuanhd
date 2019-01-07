Overlay = new Class({
	
	initialize:function(){
		this.overlay =  new Element('div', {'id':'fabrikOverlay', 'styles':{'background-color':'#000'}});
		this.overlay.addEvent('click', this.hide.bindWithEvent(this));
		window.addEvent('domready', function(){
			this.overlay.inject(document.body);	
			this.hide();
		}.bind(this));
		
		this.opacityMorph = new Fx.Morph(this.overlay, {
			'duration': 350,
			transition: Fx.Transitions.Sine.easeInOut
		});
	},
	
	hide:function(){
		this.opacityMorph.set({
			'opacity': 0
		});
		window.fireEvent('fabrik.overlay.hide');
	},
	
	show:function(){
		this.overlay.setStyle('width', window.getCoordinates().width);
		this.overlay.setStyle('height', window.getCoordinates().height + window.getScroll().y) ;
		this.overlay.show();
		this.opacityMorph.start({
			'opacity': 0.6
		});
	}
});

if(typeof(Fabrik)==="undefined"){
	Fabrik={}
	Fabrik.Windows = {};
	Fabrik.iconGen = new IconGenerator({scale:0.5});
	Fabrik.overlay = new Overlay();
}
