Fabrik.Window = new Class({

	Extends:Options,
	
	options:{
		id:'FabrikWindow',
		title:'',
		container:false,
		loadMethod:'html',
		contentURL:'',
		content:'',
		width:100,
		height:200,
		createShowOverLay:true,
		onContentLoaded: function(){}
	},
	
	modal: false,
	
	initialize:function(opts)
	{
		if (Fabrik.Windows[this.options.id]) {
			Fabrik.overlay.show();
			//this = Fabrik.Windows[this.options.id];
		} else {
			this.setOptions(opts);
			if(this.options.createShowOverLay){
				Fabrik.overlay.show();
			}
			this.makeWindow();
		}
	},
	
	makeWindow:function()
	{
		var d = {'width':this.options.width+'px', 'height':this.options.height+'px'};
		d.top = window.getSize().y/2 + window.getScroll().y;
		d.left = window.getSize().x/2  + window.getScroll().x - this.options.width/2;
		this.window = new Element('div', {'id':this.options.id, 'class':'fabrikWindow'}).setStyles(d);
		this.contentWrapperEl = this.window;
		var art = Fabrik.iconGen.create(icon['cross']);
		var del = new Element('a', {'href':'#', 'class':'close', 'events':{
			'click':this.close.bindWithEvent(this)
		}});
		art.inject(del);
		
		var hclass = 'handlelabel';
		if (!this.modal){
			hclass += ' draggable';
		}
		var label = new Element('span', {'class':hclass}).set('text', this.options.title);
		var handle = new Element('div', {'class':'handle'}).adopt([label, del]);
		
		if (!this.modal){
		var dragger = new Element('div', {'class':'dragger'});
		}
		var content = new Element('div', {'class':'itemContent'});
		this.contentEl = content;
		if (this.modal) {
			var ch = this.options.height-30;
			cw = this.options.width ;
			content.setStyles({'height':ch+'px', 'width':cw+'px'});
			this.window.adopt([handle, content]);
		}else{
			this.window.adopt([handle, content, dragger]);
			this.window.makeResizable({'handle':dragger,
				onComplete: function(){
					window.fireEvent('fabrik.window.resized', this.window);
				}
			});
			var dragOpts = {'handle':handle};
			dragOpts.container = this.options.container ?	$(this.options.container) : window;
			this.window.makeDraggable(dragOpts);
		}

		document.body.adopt(this.window);
		switch(this.options.loadMethod){
			
			case 'html':
				if (typeof(this.options.content) == 'element'){
					this.options.content.inject(content);
				}else{
					content.setHTML(this.options.content);
				}
				this.options.onContentLoaded();
				break;
			case 'xhr':
				var u = this.window.getElement('.itemContent');
				new Request.HTML({
					'url':this.options.contentURL,
					'update':u,
					onSuccess:this.options.onContentLoaded()
				}).post();
				break;
		}
		Fabrik.Windows[this.options.id] = this;
		window.addEvent('fabrik.overlay.hide', function(){
			this.window.hide();
		}.bind(this));
	},
	
	close:function(e)
	{
		if(e){e.stop()};
		Fabrik.overlay.hide();
		//cant destroy as we want to be able to reuse them (see crop in fileupload element)
		this.window.hide();
	},
	
	showSpinner:function()
	{
		fconsole('need to do show spinner for window.js');
	},
	
	hideSpinner:function(){
		fconsole('need to do hide spinner for window.js');
	}
	
});

Fabrik.Modal = new Class({
	Extends: Fabrik.Window,
	
	modal:true
	
});
