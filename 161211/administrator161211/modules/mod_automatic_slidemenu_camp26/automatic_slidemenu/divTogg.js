// This function "connects" the item of a group with its header (usually in a tab environment)
function defineHeader(params) {
	
	if (params.item && params.header)
		$("#"+params.item).data('header', { id: params.header});
}
var myImgUp, myImgUpMO, myImgDown, myImgDownMO;

// This function ..
function divIndicatorImages(params) {
	
	myImgUp = ((params.normal)? params.normal: "undefined");
	myImgUpMO = ((params.normalMouseOver)? params.normalMouseOver: (myImgUp)? myImgUp: "undefined");
	myImgDown = ((params.selected)? params.selected: (myImgUpMO)? myImgUpMO: "undefined");
	myImgDownMO = ((params.selectedMouseOver)? params.selectedMouseOver: (myImgDown)? myImgDown: "undefined");
}

// This function associates the indicator images to the header of an item
function divIndicatorSingle(params) {

	if (params.normal) $("#"+params.item).data('swapImgUp', params.normal);
	if (params.normalMouseOver) $("#"+params.item).data('swapImgUpMO', params.normalMouseOver);
	if (params.selected) $("#"+params.item).data('swapImgDown', params.selected);
	if (params.selectedMouseOver) $("#"+params.item).data('swapImgDownMO', params.selectedMouseOver);
}

// This function defines the three states of the header with CSS rules
var myNormalState, myMouseOverState, mySelectedState;
function divHeaderStates(params) {

	myNormalState = ((params.normal)? params.normal: "undefined");
	myMouseOverState = ((params.mouseOver)? params.mouseOver: "undefined");
	mySelectedState = ((params.selected)? params.selected: "undefined");
}

// AJAX
function divAjaxCall(params) {

	if (params.item && params.call) {
		$("#"+params.item).data('ajaxCall', params.call);
		$("#"+params.item).data('ajaxPreloader', params.preloader? params.preloader: 0);
	}
//	alert($("#"+params.item).data('ajaxCall'));
}


// This function is just an "unreadable" version of createDivGroup i.e. excepts all possible parameters in the form of numbers (except prefix and selectedDiv)
function newDivGroup(prefix, type, vertical_horizontal_menu, enlarge, effect, duration, minTrans, maxTrans, transOrder, selectedDiv, eventTrigger, clickableHeader, normalState, mouseOverState, selectedState, containerWidth, containerHeight) {
	var typeCodes = [
		'header-single',	 		//	0
		'header-group', 			//	1
		'header-dual',				//	2
		'header-dual-container',	//	3
		'header-dual-closecontainer',//	4
		'header-group-container', 	//	5
		'tab-group',				//	6
		'tab-dual',					//	7
		'tab-group-container',		//	8
		'tab-dual-container',		//	9
		'tab-dual-closecontainer'	//	10
	];
	var vhmCodes = [
		'vertical',					//	0
		'horizontal',				//	1
		'horiz-menu'				//	2
	];
	var widenCodes = [
		true,						//	0
		false						//	1
	];
	var effectCodes = [
		['height'],							//	0
		['width'],							//	1
		['opacity'],						//	2
		['height', 'width'],				//	3
		['height', 'opacity'],				//	4
		['width', 'opacity'],				//	5
		['height', 'width', 'opacity']		//	6
	];
	var transCodes = [
		'none',				//	0
		'jswing',			//	1
		'easeInQuad',		//	2
		'easeOutQuad',		//	3
		'easeInOutQuad',	//	4
		'easeInCubic',		//	5
		'easeOutCubic',		//	6
		'easeInOutCubic',	//	7
		'easeInQuart',		//	8
		'easeOutQuart',		//	9
		'easeInOutQuart',	//	10
		'easeInQuint',		//	11
		'easeOutQuint',		//	12
		'easeInOutQuint',	//	13
		'easeInSine',		//	14
		'easeOutSine',		//	15
		'easeInOutSine',	//	16
		'easeInExpo',		//	17
		'easeOutExpo',		//	18
		'easeInOutExpo',	//	19
		'easeInCirc',		//	20
		'easeOutCirc',		//	21
		'easeInOutCirc',	//	22
		'easeInElastic',	//	23
		'easeOutElastic',	//	24
		'easeInOutElastic',	//	25
		'easeInBack',		//	26
		'easeOutBack',		//	27
		'easeInOutBack',	//	28
		'easeInBounce',		//	29
		'easeOutBounce',	//	30
		'easeInOutBounce'	//	31
	];
	var transOrderCodes = [
		'close',
		'open',
		'both'
	];
	var clickableHeaderCodes = [
		true,				//	0
		false				//	1
	];
	var eventTriggerCodes = [
		'click',
		'mouseover'
	];
	
	var myType = typeCodes[(type)? type: 2];
	var myVhm = vhmCodes[(vertical_horizontal_menu)?vertical_horizontal_menu: 0];
	var myWiden = widenCodes[(enlarge)?enlarge: 0];
	var myEffect = effectCodes[(effect)? effect: 2];
	var myMinTrans = transCodes[(minTrans)? minTrans: 0];
	var myMaxTrans = transCodes[(maxTrans)? maxTrans: 0];
	var myTransOrder = transOrderCodes[(transOrder)? transOrder: 2];
	var myClickableHeader = clickableHeaderCodes[(clickableHeader)? clickableHeader: 0];
	var myEventTrigger = eventTriggerCodes[(eventTrigger)? eventTrigger: 0];
	
//	if (myType==="single" && myHasContainer) myType="dual";
//	return createDivGroup({prefix:prefix, type:myType, effect:myEffect, duration:duration, minTrans:myMinTrans, maxTrans:myMaxTrans, transOrder:myTransOrder, selectedDiv:selectedDiv, eventTrigger: myEventTrigger, imgUp: myImgUp, imgDown: myImgDown});
	return createDivGroup({prefix:prefix, type:myType, vhm: myVhm, widen: myWiden, effect:myEffect, duration:duration, minTrans:myMinTrans, maxTrans:myMaxTrans, transOrder:myTransOrder, selectedDiv: selectedDiv, eventTrigger: myEventTrigger, clickableHeader: myClickableHeader, containerWidth: containerWidth, containerHeight: containerHeight, normalState: normalState, mouseOverState: mouseOverState, selectedState: selectedState});
}
var dualFlag = 0;
//*************************   function for populating the div container   **************************
function createDivGroup(params) {
	
	// myDivs is the single object that holds the whole set of divs
	var myDivs = {
		// prefix holds the prefix that was used to identify and group the divs
		prefix: ((params.prefix)? params.prefix: ''),
		// myElements keeps an array of all "div items" in the group
		myElements: [],
		// groupType defines how the div items react in the group 
		groupType: ((params.type)? params.type: "dual"),
		// addDiv allows the addition of more div items after the original group is created
		addDiv: addDivToGroup,
		// effect keeps an array of all style properties that should be transformed
		effect: ((params.effect)? params.effect: ['opacity']),
		// duration is the total time it takes for a full state transition
		duration: ((params.duration)? params.duration: 1),
		// delay is the time the effect waits before it takes off ---> FUTURE (?)
		delay: ((params.delay)? params.delay: 0),
		// minTrans is the transition effect for the closing of a div
		minTrans: ((params.minTrans)? params.minTrans: "linear"),
		// maxTrans is the transition effect for the opening of a div
		maxTrans: ((params.maxTrans)? params.maxTrans: "linear"),
		// transOrder is the order in which to close/open divs in a transition (close/open/both)
		transOrder: ((params.transOrder)? params.transOrder: "both"),
		// selectedDiv holds the id of the div that should be preselected.
		selectedDiv: ((params.selectedDiv)? params.selectedDiv: 'noDivSelection'),
		// eventTrigger holds the id of the div that should be preselected.
		eventTrigger: ((params.eventTrigger)? params.eventTrigger: 'click'),
		// clickableHeader is true when we want the whole header to be clickable (and not a specific area - like an image)
		clickableHeader: ((params.clickableHeader)? params.clickableHeader: true),
		// imgUp holds the image of the group that appears when in Up state (unselected).
		imgUp: ((myImgUp != 'undefined')? myImgUp: 'noImg'),
		// imgUpMO holds the image of the group that appears when in Up and Mouse Over state (unselected).
		imgUpMO: ((myImgUpMO != 'undefined')? myImgUpMO: 'noImg'),
		// imgDown holds the image of the group that appears when in Down state (selected).
		imgDown: ((myImgDown != 'undefined')? myImgDown: 'noImg'),
		// imgDownMO holds the image of the group that appears when in Down and Mouse Over state (selected).
		imgDownMO: ((myImgDownMO != 'undefined')? myImgDownMO: 'noImg'),
		// containerHeight
		containerHeight: ((params.containerHeight)? params.containerHeight: 0),
		// containerWidth
		containerWidth: ((params.containerWidth)? params.containerWidth: 0),
		// normal state of header
		normalState: ((myNormalState != 'undefined')? myNormalState: 'notDefined'),
		// mouse over state of header
		mouseOverState: ((myMouseOverState != 'undefined')? myMouseOverState: 'notDefined'),
		// selected state of header
		selectedState: ((mySelectedState != 'undefined')? mySelectedState: 'notDefined'),
		// add float: left; in the style of the container
		floatLeft: ((params.floatLeft)? 'float: left;': ''), // float: none; ?
		// vertical or horizontal menu
		vhm: ((params.vhm)? params.vhm: 'vertical'),
		// widen or not the items so all will have the same size (when container is added)
		widen: ((params.widen)? params.widen: false)
	};

	// Here we allow the group creation by use of prefix. we should also allow the use of ['id1', 'id2', 'id3']
	var els = $("*[class*='divToggle'][id^='"+myDivs.prefix+"']");
	
	// if we need to create the "container" layer, initialize its maximum width and height (set to 0)
	if (myDivs.groupType.indexOf("container") > -1) {														/* HIDDEN?? MEGALI DEFTERA*/
		document.write("<div id='myToggleDivContainer_"+myDivs.prefix+"' style='"+myDivs.floatLeft+" overflow: hidden; z-index: 1; position: relative;'>&nbsp;</div>");
		myDivs.container = $('#myToggleDivContainer_'+myDivs.prefix);
		// the following are required in order for maxinize/minimize to work with the container
		myDivs.container.maxDimens = new Array();
		myDivs.container.minDimens = new Array();
		myDivs.container.maxDimens['height'] = myDivs.containerHeight;
		myDivs.container.maxDimens['width'] = myDivs.containerWidth;
		myDivs.container.maxDimens['opacity'] = 1;
		myDivs.container.allDivs = myDivs;
		myDivs.container.divItem = myDivs.container;
		myDivs.container.isClosed = false;
		
		myDivs.container.insertBefore(els[0]); //??
	}

	if (myDivs.selectedDiv == 'noDivSelection')
		myDivs.openDiv = 'undefined';
		
	// for each div in the divs array
	for(var i=0; i<els.length; i++){
		myDivs.addDiv(els[i].id);
	}

	// MOUSEOUT!!
	if (myDivs.groupType.indexOf("dual-container") > -1) {
		$("#myToggleDivContainer_"+myDivs.prefix).bind('mouseleave', function(e){
			if (myDivs.openDiv != 'undefined') {
				var tmpDiv = myDivs.openDiv;
//				setTimeout(function() { 
					dualFlag = 1;
					myDivs.openDiv.myHead.trigger(myDivs.eventTrigger); 
//				}, 100);
				tmpDiv.myHead.attr('style', myDivs.normalState);
				divsToggleImg(tmpDiv, 0);
			}
		});
	}

	// for(var i=0; i<els.length; i++){
		// alert(i+': '+myDivs.myElements[i].myBody.maxDimens['height']);
	// }	

	// fix the minimum, maximum dimentions of the container
	if (myDivs.groupType.indexOf("container") > -1) {
		
		if (myDivs.containerHeight && myDivs.containerWidth) {
				myDivs.container.maxDimens['height'] = myDivs.containerHeight;
				myDivs.container.maxDimens['width'] = myDivs.containerWidth;

		} else {
			
//				alert('height:'+myDivs.container.maxDimens['height']);
//				alert('width:'+myDivs.container.maxDimens['width']);

			if (myDivs.groupType.indexOf("tab") > -1) {
				
//				alert('tab! don\'t need anything else!');

			} else { 
				
				myDivs.container.headerHeight = 0;
				myDivs.container.headerWidth = 0;
				if (myDivs.vhm == 'vertical') {
					$.each(els, function(i, prop) {
						
						var headerWidthExtra = 0,
							headerHeightExtra = 0;
						
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginLeft')));
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginRight')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginTop')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginBottom')));

						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingLeft')));
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingRight')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingTop')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingBottom')));
						
			//			alert(headerWidthExtra);
			//			alert(headerHeightExtra);

						myDivs.container.headerHeight += myDivs.myElements[i].myHead.outerHeight(true) + headerHeightExtra;
//						alert(myDivs.myElements[i].myHead.outerHeight({margin: true, padding: true}));
						myDivs.container.headerWidth = myDivs.myElements[i].myHead.outerWidth(true) + headerWidthExtra;
					});
					myDivs.container.maxDimens['height'] += myDivs.container.headerHeight;
					myDivs.container.minDimens['height'] = myDivs.container.headerHeight;
					
					myDivs.container.maxDimens['width'] = myDivs.container.headerWidth;
					myDivs.container.minDimens['width'] = myDivs.container.headerWidth;

				} else if (myDivs.vhm == 'horizontal') {
					$.each(els, function(i, prop) {
						
						var headerWidthExtra = 0,
							headerHeightExtra = 0;
						
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginLeft')));
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginRight')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginTop')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginBottom')));

						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingLeft')));
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingRight')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingTop')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingBottom')));
						
			//			alert(headerWidthExtra);
			//			alert(headerHeightExtra);

						myDivs.container.headerHeight = myDivs.myElements[i].myHead.outerHeight(true) + headerHeightExtra; // !!!! .height()
						myDivs.container.headerWidth += myDivs.myElements[i].myHead.outerWidth(true) + headerWidthExtra; // !!!! .height()
					});
					
					myDivs.container.maxDimens['height'] = myDivs.container.headerHeight;
					myDivs.container.minDimens['height'] = myDivs.container.headerHeight;
					
					myDivs.container.maxDimens['width'] += myDivs.container.headerWidth;
					myDivs.container.minDimens['width'] = myDivs.container.headerWidth;

					
				} else if (myDivs.vhm == 'horiz-menu') { 
					$.each(els, function(i, prop) {
						
						var headerWidthExtra = 0,
							headerHeightExtra = 0;
						
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginLeft')));
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginRight')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginTop')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('marginBottom')));

						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingLeft')));
						headerWidthExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingRight')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingTop')));
						headerHeightExtra += parseInt(stripAlphaChars(myDivs.myElements[i].css('paddingBottom')));
						
						myDivs.container.headerHeight = (myDivs.myElements[i].myHead.outerHeight(true) + ((!headerHeightExtra)? 0:headerHeightExtra)); // !!!! .height()
						myDivs.container.headerWidth += (myDivs.myElements[i].myHead.outerWidth(true) + ((!headerWidthExtra)? 0:headerWidthExtra)); // !!!! .height()

//						alert(myDivs.container.headerHeight);
//						alert(myDivs.container.headerWidth);
					});
					
					myDivs.container.maxDimens['height'] = myDivs.container.headerHeight;
					myDivs.container.minDimens['height'] = myDivs.container.headerHeight;
					
					myDivs.container.maxDimens['width'] = myDivs.container.headerWidth;
					myDivs.container.minDimens['width'] = myDivs.container.headerWidth;

				}
			}
		}

		if (myDivs.groupType.indexOf("tab") > -1)	myDivs.container.insertAfter(myDivs.myElements[i-1]);

		if ((myDivs.selectedDiv != 'noDivSelection') || (myDivs.groupType.indexOf("close") == -1)) {
//			alert(myDivs.container.maxDimens['height']);
			myDivs.container.css('height',myDivs.container.maxDimens['height']);
//			alert(myDivs.container.maxDimens['width']);
			myDivs.container.css('width',myDivs.container.maxDimens['width']);
			
		} else if (myDivs.groupType.indexOf("close") > -1) {
			myDivs.container.css('height',myDivs.container.minDimens['height']);
			myDivs.container.css('width',myDivs.container.minDimens['width']);
		}

	} 
	
	// finally return the generated object
	return myDivs;
}

var tmpForSTO = 0;
var tmpItemForSTO = 'null';
//*************************   function for adding extra divs in a div container after this has been created   **************************
function addDivToGroup(id) {

	if (!arrayContains(this.myElements, id)) {

		// get the number of existing elements
		var i = this.myElements.length;
		// create the element
		this.myElements[i] = $("#"+id);
		// move the new element under the last
		if (i>0 && this.container) this.myElements[i].insertAfter(this.myElements[i-1]);
		// link to the "parent" object (that holds everything)
		this.myElements[i].allDivs = this;
		// link to the "body" element (div) which is going to close/open
		this.myElements[i].myBody = $("#"+id+" > .divBody"); //elem with class='divBody' and is child of elem with id=id.id (current element)!
		// link to the item
		this.myElements[i].myBody.divItem = this.myElements[i];
		// link to the "parent" object (that holds everything)
		this.myElements[i].myBody.allDivs = this;
		// funtion to open/close this div
		this.myElements[i].myBody.toggleMe = internalToggleDiv;
		// initialize the style and effect values for this item
//		this.myElements[i].myBody.css("display", 'block'); // WHAT?????????????????????????????????????????????????????????????????????
//		alert('aa');
		this.myElements[i].myBody.css("overflow", "hidden"); // EDW?

		this.myElements[i].myBody.maxDimens = new Array();
		this.myElements[i].myBody.minDimens = new Array();

		if (!this.containerHeight) {
			if (this.myElements[i].myBody.attr('height') && this.myElements[i].myBody.attr('height') != 'auto')
				this.myElements[i].myBody.maxDimens['height'] = this.myElements[i].myBody.attr('height');
			else
				this.myElements[i].myBody.maxDimens['height'] = this.myElements[i].myBody.height();
		} else
			this.myElements[i].myBody.maxDimens['height'] = this.containerHeight;
		if (!this.containerWidth) {
			if (this.myElements[i].myBody.attr('width') && this.myElements[i].myBody.attr('width') != 'auto')
				this.myElements[i].myBody.maxDimens['width'] = this.myElements[i].myBody.attr('width');
			else
				this.myElements[i].myBody.maxDimens['width'] = this.myElements[i].myBody.width();
		} else
			this.myElements[i].myBody.maxDimens['width'] = this.containerWidth;
		
//		alert(this.myElements[i].myBody.height());
//		alert(this.myElements[i].myBody.width());
//alert('sssssssss');
		this.myElements[i].myBody.maxDimens['borderBottomWidth'] = (this.myElements[i].myBody.css('borderBottomWidth')=='medium')?'0px':this.myElements[i].myBody.css('borderBottomWidth');
		this.myElements[i].myBody.maxDimens['borderTopWidth'] = (this.myElements[i].myBody.css('borderTopWidth')=='medium')?'0px':this.myElements[i].myBody.css('borderTopWidth');
		this.myElements[i].myBody.maxDimens['borderLeftWidth'] = (this.myElements[i].myBody.css('borderLeftWidth')=='medium')?'0px':this.myElements[i].myBody.css('borderLeftWidth');
		this.myElements[i].myBody.maxDimens['borderRightWidth'] = (this.myElements[i].myBody.css('borderRightWidth')=='medium')?'0px':this.myElements[i].myBody.css('borderRightWidth');
		this.myElements[i].myBody.maxDimens['paddingBottom'] = (this.myElements[i].myBody.css('paddingBottom')=='auto')?'0px':this.myElements[i].myBody.css('paddingBottom');
		this.myElements[i].myBody.maxDimens['paddingTop'] = (this.myElements[i].myBody.css('paddingTop')=='auto')?'0px':this.myElements[i].myBody.css('paddingTop');
		this.myElements[i].myBody.maxDimens['paddingLeft'] = (this.myElements[i].myBody.css('paddingLeft')=='auto')?'0px':this.myElements[i].myBody.css('paddingLeft');
		this.myElements[i].myBody.maxDimens['paddingRight'] = (this.myElements[i].myBody.css('paddingRight')=='auto')?'0px':this.myElements[i].myBody.css('paddingRight');
		this.myElements[i].myBody.maxDimens['marginBottom'] = (this.myElements[i].myBody.css('marginBottom')=='auto')?'0px':this.myElements[i].myBody.css('marginBottom');
		this.myElements[i].myBody.maxDimens['marginTop'] = (this.myElements[i].myBody.css('marginTop')=='auto')?'0px':this.myElements[i].myBody.css('marginTop');
		this.myElements[i].myBody.maxDimens['marginLeft'] = (this.myElements[i].myBody.css('marginLeft')=='auto')?'0px':this.myElements[i].myBody.css('marginLeft');
		this.myElements[i].myBody.maxDimens['marginRight'] = (this.myElements[i].myBody.css('marginRight')=='auto')?'0px':this.myElements[i].myBody.css('marginRight');
		
		
		this.myElements[i].myBody.maxDimens['opacity'] = $(this.myElements[i].myBody).css("opacity");
		
		// If you want a tab-pane style then make divs floating
		if (this.groupType.indexOf("container") > -1) {
			if (this.groupType.indexOf("header") > -1) {
				if (!this.container.children().html()) {
					this.container.html(this.myElements[i]);
				}
				else {
				this.myElements[i].appendTo(this.container);}
			}
//		alert(this.myElements[i].myBody.maxDimens['width']);
//		alert(this.myElements[i].myBody.outerWidth({margin: true}));

//			alert(this.myElements[i].myBody.outerHeight());
			if (!this.containerHeight) {
				if (this.container.maxDimens['height']<this.myElements[i].myBody.outerHeight({margin: true})) {
					this.container.maxDimens['height']=this.myElements[i].myBody.outerHeight({margin: true});
		
					if (this.openDiv && (this.openDiv!='undefined') && this.widen) {
						this.openDiv.myBody.css("height", this.myElements[i].myBody.maxDimens['height']);

						this.openDiv.myBody.css("borderBottomWidth", this.myElements[i].myBody.maxDimens['borderBottomWidth']);
						this.openDiv.myBody.css("borderTopWidth", this.myElements[i].myBody.maxDimens['borderTopWidth']);
						this.openDiv.myBody.css("paddingBottom", this.myElements[i].myBody.maxDimens['paddingBottom']);
						this.openDiv.myBody.css("paddingTop", this.myElements[i].myBody.maxDimens['paddingTop']);
						this.openDiv.myBody.css("marginBottom", this.myElements[i].myBody.maxDimens['marginBottom']);
						this.openDiv.myBody.css("marginTop", this.myElements[i].myBody.maxDimens['marginTop']);
					}
				}
			} else {
				if (this.myElements[i].myBody.outerHeight({margin: true}) > this.containerHeight) {
//					alert('changing height...');
//					this.myElements[i].myBody.maxDimens['height'] = this.containerHeight;
					this.myElements[i].myBody.css('overflow', 'auto');
//					alert('changed height...'+this.myElements[i].myBody.outerHeight(true));
				}
			}
			if (!this.containerWidth) {
				if (this.container.maxDimens['width']<this.myElements[i].myBody.outerWidth({margin: true})) {
					this.container.maxDimens['width']=this.myElements[i].myBody.outerWidth({margin: true});
	//				alert(this.myElements[i].myBody.outerWidth({margin: true}));
	//				alert(this.myElements[i].myBody.width());
					
					if (this.openDiv && (this.openDiv!='undefined') && this.widen) {
						this.openDiv.myBody.css("width", this.myElements[i].myBody.maxDimens['width']);

						this.openDiv.myBody.css("borderBottomWidth", this.myElements[i].myBody.maxDimens['borderBottomWidth']);
						this.openDiv.myBody.css("borderTopWidth", this.myElements[i].myBody.maxDimens['borderTopWidth']);
						this.openDiv.myBody.css("paddingBottom", this.myElements[i].myBody.maxDimens['paddingBottom']);
						this.openDiv.myBody.css("paddingTop", this.myElements[i].myBody.maxDimens['paddingTop']);
						this.openDiv.myBody.css("marginBottom", this.myElements[i].myBody.maxDimens['marginBottom']);
						this.openDiv.myBody.css("marginTop", this.myElements[i].myBody.maxDimens['marginTop']);
					}
				}
			} else {
				if (this.myElements[i].myBody.outerWidth({margin: true}) > this.containerWidth) {
//					alert('width bigger..');
//					this.myElements[i].myBody.maxDimens['width'] = this.containerHeight;
					this.myElements[i].myBody.css('overflow', 'auto');
//					alert('changed width...'+this.myElements[i].myBody.outerWidth(true));
				}
			}
			
			if (this.widen) {
				for (k=0;k<=i;k++) {

					if (this.myElements[k].myBody.maxDimens['height'] < this.myElements[i].myBody.maxDimens['height']) {
						this.myElements[k].myBody.maxDimens['height'] = this.myElements[i].myBody.maxDimens['height'];
						if ((this.selectedDiv != 'noDivSelection') && (this.myElements[i].attr('id')==this.selectedDiv))
							this.myElements[k].myBody.css('height', this.myElements[i].myBody.maxDimens['height']);
					} else {
						this.myElements[i].myBody.maxDimens['height'] = this.myElements[k].myBody.maxDimens['height'];
						if ((this.selectedDiv != 'noDivSelection') && (this.myElements[i].attr('id')==this.selectedDiv))
							this.myElements[i].myBody.css('height', this.myElements[k].myBody.maxDimens['height']);
					}
					
					if (this.myElements[k].myBody.maxDimens['width'] < this.myElements[i].myBody.maxDimens['width']) {
						this.myElements[k].myBody.maxDimens['width'] = this.myElements[i].myBody.maxDimens['width'];
						if ((this.selectedDiv == 'noDivSelection') && (this.myElements[i].attr('id')==this.selectedDiv))
							this.myElements[k].myBody.css('width', this.myElements[i].myBody.maxDimens['width']);
					} else {
						this.myElements[i].myBody.maxDimens['width'] = this.myElements[k].myBody.maxDimens['width'];
						if ((this.selectedDiv != 'noDivSelection') && (this.myElements[i].attr('id')==this.selectedDiv))
							this.myElements[i].myBody.css('width', this.myElements[k].myBody.maxDimens['width']);
					}
						
//					(k+': '+this.myElements[k].myBody.maxDimens['height']+', css: '+this.myElements[k].myBody.css('height'));
				}
			}

			//this.myElements[i].myBody.css("z-index", "2");	// ???? afto?
		}
			

		
		if (this.groupType.indexOf("tab") > -1) { // MHPWS EXEI PROVLIMA?? (sto newhome.html)
			this.myElements[i].myBody.css("position", "absolute");
			this.myElements[i].myBody.css("z-index", "2");
		}
		
		// determine the effects to be applied
		this.myElements[i].myBody.minDimens['height'] = (jQuery.inArray("height", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['height'];
		this.myElements[i].myBody.minDimens['width'] = (jQuery.inArray("width", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['width'];
		this.myElements[i].myBody.minDimens['opacity'] = (jQuery.inArray("opacity", this.effect) != -1)?0:this.myElements[i].myBody.maxDimens['opacity'];

		this.myElements[i].myBody.minDimens['borderLeftWidth'] = (jQuery.inArray("width", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['borderLeftWidth'];
		this.myElements[i].myBody.minDimens['borderRightWidth'] = (jQuery.inArray("width", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['borderRightWidth'];
		this.myElements[i].myBody.minDimens['borderTopWidth'] = (jQuery.inArray("height", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['borderTopWidth'];
		this.myElements[i].myBody.minDimens['borderBottomWidth'] = (jQuery.inArray("height", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['borderBottomWidth'];
		this.myElements[i].myBody.minDimens['paddingLeft'] = (jQuery.inArray("width", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['paddingLeft'];
		this.myElements[i].myBody.minDimens['paddingRight'] = (jQuery.inArray("width", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['paddingRight'];
		this.myElements[i].myBody.minDimens['paddingTop'] = (jQuery.inArray("height", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['paddingTop'];
		this.myElements[i].myBody.minDimens['paddingBottom'] = (jQuery.inArray("height", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['paddingBottom'];
		this.myElements[i].myBody.minDimens['marginLeft'] = (jQuery.inArray("width", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['marginLeft'];
		this.myElements[i].myBody.minDimens['marginRight'] = (jQuery.inArray("width", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['marginRight'];
		this.myElements[i].myBody.minDimens['marginTop'] = (jQuery.inArray("height", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['marginTop'];
		this.myElements[i].myBody.minDimens['marginBottom'] = (jQuery.inArray("height", this.effect) != -1)?'0px':this.myElements[i].myBody.maxDimens['marginBottom'];

		if ((this.groupType.indexOf("group") > -1) && (this.selectedDiv == 'noDivSelection')) {
			this.selectedDiv = this.myElements[0].attr('id');
		}

		if ((this.groupType.indexOf("container") > -1) && (this.myElements[i].allDivs.openDiv == 'undefined'))
			this.container.isClosed = true;

		// Show or hide the div...
		if (this.myElements[i].attr('id')!=this.selectedDiv) {
			$(this.myElements[i].myBody).css("height", this.myElements[i].myBody.minDimens['height']);
			$(this.myElements[i].myBody).css("width", this.myElements[i].myBody.minDimens['width']);
			$(this.myElements[i].myBody).css("filter", 0);
			$(this.myElements[i].myBody).css("opacity", this.myElements[i].myBody.minDimens['opacity']);
			$(this.myElements[i].myBody).css("filter", 'alpha(opacity:'+this.myElements[i].myBody.minDimens['opacity']*100+')');
//			$(this.myElements[i].myBody).css("display", "none");

			$(this.myElements[i].myBody).css("borderLeftWidth", this.myElements[i].myBody.minDimens['borderLeftWidth']);
			$(this.myElements[i].myBody).css("borderRightWidth", this.myElements[i].myBody.minDimens['borderRightWidth']);
			$(this.myElements[i].myBody).css("borderBottomWidth", this.myElements[i].myBody.minDimens['borderBottomWidth']);
			$(this.myElements[i].myBody).css("borderTopWidth", this.myElements[i].myBody.minDimens['borderTopWidth']);
			$(this.myElements[i].myBody).css("paddingLeft", this.myElements[i].myBody.minDimens['paddingLeft']);
			$(this.myElements[i].myBody).css("paddingRight", this.myElements[i].myBody.minDimens['paddingRight']);
			$(this.myElements[i].myBody).css("paddingBottom", this.myElements[i].myBody.minDimens['paddingBottom']);
			$(this.myElements[i].myBody).css("paddingTop", this.myElements[i].myBody.minDimens['paddingTop']);
			$(this.myElements[i].myBody).css("marginLeft", this.myElements[i].myBody.minDimens['marginLeft']);
			$(this.myElements[i].myBody).css("marginRight", this.myElements[i].myBody.minDimens['marginRight']);
			$(this.myElements[i].myBody).css("marginBottom", this.myElements[i].myBody.minDimens['marginBottom']);
			$(this.myElements[i].myBody).css("marginTop", this.myElements[i].myBody.minDimens['marginTop']);
			this.myElements[i].isClosed = true;
			
			if (jQuery.inArray(("opacity"), this.myElements[i].allDivs.effect) != -1)
				this.myElements[i].myBody.hide();
		} else {
			$(this.myElements[i].myBody).css("height", this.myElements[i].myBody.maxDimens['height']);
			$(this.myElements[i].myBody).css("width", this.myElements[i].myBody.maxDimens['width']);
			$(this.myElements[i].myBody).css("opacity", this.myElements[i].myBody.maxDimens['opacity']);
			$(this.myElements[i].myBody).css("filter", 0);
//			$(this.myElements[i].myBody).css("filter", 'alpha(opacity:'+this.myElements[i].myBody.maxDimens['opacity'] * 100+')');
//			$(this.myElements[i].myBody).css("display", "block");

			$(this.myElements[i].myBody).css("borderLeftWidth", this.myElements[i].myBody.maxDimens['borderLeftWidth']);
			$(this.myElements[i].myBody).css("borderRightWidth", this.myElements[i].myBody.maxDimens['borderRightWidth']);
			$(this.myElements[i].myBody).css("borderBottomWidth", this.myElements[i].myBody.maxDimens['borderBottomWidth']);
			$(this.myElements[i].myBody).css("borderTopWidth", this.myElements[i].myBody.maxDimens['borderTopWidth']);
			$(this.myElements[i].myBody).css("paddingLeft", this.myElements[i].myBody.maxDimens['paddingLeft']);
			$(this.myElements[i].myBody).css("paddingRight", this.myElements[i].myBody.maxDimens['paddingRight']);
			$(this.myElements[i].myBody).css("paddingBottom", this.myElements[i].myBody.maxDimens['paddingBottom']);
			$(this.myElements[i].myBody).css("paddingTop", this.myElements[i].myBody.maxDimens['paddingTop']);
			$(this.myElements[i].myBody).css("marginLeft", this.myElements[i].myBody.maxDimens['marginLeft']);
			$(this.myElements[i].myBody).css("marginRight", this.myElements[i].myBody.maxDimens['marginRight']);
			$(this.myElements[i].myBody).css("marginBottom", this.myElements[i].myBody.maxDimens['marginBottom']);
			$(this.myElements[i].myBody).css("marginTop", this.myElements[i].myBody.maxDimens['marginTop']);
			this.myElements[i].isClosed = false;
			
			this.myElements[i].allDivs.openDiv = this.myElements[i];
		
			// load AJAX on Selected Div
			tmpForSTO = i;
			tmpItemForSTO = this.myElements[i];
			if (tmpItemForSTO.data('ajaxCall')) {
				tmpItemForSTO.myBody.html('<div style="width:100%; height:100%; background-image: url('+this.myElements[i].data('ajaxPreloader')+'); background-repeat:no-repeat; background-position:center center;"></div>');
				setTimeout("loadAjax(tmpItemForSTO.myBody)", tmpItemForSTO.allDivs.duration+10);
			}

		}

		// The head is not required for an item, hence we "try" to retrieve it
		try {
			if (!this.myElements[i].data('header')) {
				//elem with class='divHead' and is child of elem with id=id.id (current element)!
				this.myElements[i].myHead = $("#"+id+" > .divHead"); 
				if (this.myElements[i].myHead.attr('class').indexOf('divHead') == -1) {
					this.myElements[i].myHead = 'undefined'; throw "no such element";
				}

			} else this.myElements[i].myHead = $("#"+this.myElements[i].data('header').id);

			this.myElements[i].myHead.divItem = this.myElements[i];
			this.myElements[i].myHead.allDivs = this;
			divsToggleImg(this.myElements[i], 0);

			var toBeToggled = this.myElements[i].myBody;
			if (this.myElements[i].allDivs.clickableHeader || (typeof this.myElements[i].data('header').id != 'undefined')) {
				if (this.myElements[i].allDivs.eventTrigger == 'click')
				{
//					alert(this.prefix+": "+this.myElements[i].myHead.click());
					this.myElements[i].myHead.click(function () {internalToggleDiv(toBeToggled);});
				}
				else if (this.myElements[i].allDivs.eventTrigger == 'mouseover')
					this.myElements[i].myHead.hover(function () {internalToggleDiv(toBeToggled);});
				
				// change cursor to pointer to the clickable headers
				var mytmp1 = this.normalState;
				var mytmp2 = this.mouseOverState;
				var mytmp3 = this.myElements[i];
				var mytmp4 = this.selectedState;
				if (this.groupType.indexOf("group") == -1) {
					if (this.myElements[i].attr('id')!=this.selectedDiv) {
						this.myElements[i].myHead.attr('style', mytmp1); //alert(1);
						this.myElements[i].myHead.hover(
							function (){$(this).attr('style', mytmp2); divsToggleImg(mytmp3, 1);},
							function (){$(this).attr('style', mytmp1); divsToggleImg(mytmp3, 0);}
						);
						//this.myElements[i].myHead.mouseout(function (){$(this).attr('style', mytmp1); divsToggleImg(mytmp3, 0);});//alert(2);

					} else {
						this.myElements[i].myHead.attr('style', mytmp4); //alert(2);
						divsToggleImg(mytmp3, 2);
						this.myElements[i].myHead.hover(
							function (){$(this).attr('style', mytmp2); divsToggleImg(mytmp3, 3);},
							function (){$(this).attr('style', mytmp4); divsToggleImg(mytmp3, 2);}
						);
						//this.myElements[i].myHead.mouseout(function (){$(this).attr('style', mytmp4); divsToggleImg(mytmp3, 2);});//alert(2);
					}

				} else {
					if (this.myElements[i].attr('id')!=this.selectedDiv) { //alert(1);
						this.myElements[i].myHead.attr('style', mytmp1);
						this.myElements[i].myHead.hover(
							function (){$(this).attr('style', mytmp2); divsToggleImg(mytmp3, 1);},
							function (){$(this).attr('style', mytmp1); divsToggleImg(mytmp3, 0);}
						);
						//this.myElements[i].myHead.mouseout(function (){$(this).attr('style', mytmp1); divsToggleImg(mytmp3, 0);});
					
					} else {//alert(this.myElements[i].myHead.attr('style'));
						this.myElements[i].myHead.attr('style', mytmp4);//alert(this.myElements[i].myHead.attr('style'));
						divsToggleImg(mytmp3, 2);
						this.myElements[i].myHead.hover(
							function (){$(this).attr('style', mytmp4); /*divsToggleImg(mytmp3, 3);*/},
							function (){$(this).attr('style', mytmp4); /*divsToggleImg(mytmp3, 2);*/}
						);
						//this.myElements[i].myHead.mouseout(function (){$(this).attr('style', mytmp4); /*divsToggleImg(mytmp3, 2);*/});
					}
				}
			}
		} catch (e) {/*alert('no title!');*/}
	}
}

function divsToggleImg(item, mode) {
	if (mode == 0) {
		if (item.data('swapImgUp')) {
			if (item.myHead.find('.divToggleImg').attr('src'))
				item.myHead.find('.divToggleImg').attr('src', item.data('swapImgUp'));
			else if (item.myHead.attr('src'))
				item.myHead.attr('src', item.data('swapImgUp'));
		}
		else if (item.allDivs.imgUp != 'noImg') {
			if (item.myHead.find('.divToggleImg').attr('src'))
				item.myHead.find('.divToggleImg').attr('src', item.allDivs.imgUp);
			else if (item.myHead.attr('src'))
				item.myHead.attr('src', item.allDivs.imgUp);
		}
			
		
	} else if (mode == 1) {
		if (item.data('swapImgUpMO')) {
			if (item.myHead.find('.divToggleImg').attr('src'))
				item.myHead.find('.divToggleImg').attr('src', item.data('swapImgUpMO'));
			else if (item.myHead.attr('src'))
				item.myHead.attr('src', item.data('swapImgUpMO'));
		}
		else if (item.allDivs.imgUp != 'noImg') {
			if (item.myHead.find('.divToggleImg').attr('src'))
				item.myHead.find('.divToggleImg').attr('src', item.allDivs.imgUpMO);
			else
				item.myHead.attr('src', item.allDivs.imgUpMO);
		}

	} else if (mode == 2) {
		if (item.data('swapImgDown')) {
			if (item.myHead.find('.divToggleImg').attr('src'))
				item.myHead.find('.divToggleImg').attr('src', item.data('swapImgDown'));
			else if (item.myHead.attr('src'))
				item.myHead.attr('src', item.data('swapImgDown'));
		}
		else if (item.allDivs.imgUp != 'noImg') {
			if (item.myHead.find('.divToggleImg').attr('src'))
				item.myHead.find('.divToggleImg').attr('src', item.allDivs.imgDown);
			else
				item.myHead.attr('src', item.allDivs.imgDown);
		}
			
	} else if (mode == 3) {
		if (item.data('swapImgDownMO')) {
			if (item.myHead.find('.divToggleImg').attr('src'))
				item.myHead.find('.divToggleImg').attr('src', item.data('swapImgDownMO'));
			else if (item.myHead.attr('src'))
				item.myHead.attr('src', item.data('swapImgDownMO'));
		}
		else if (item.allDivs.imgUp != 'noImg') {
			if (item.myHead.find('.divToggleImg').attr('src'))
				item.myHead.find('.divToggleImg').attr('src', item.allDivs.imgDownMO);
			else
				item.myHead.attr('src', item.allDivs.imgDownMO);
		}
			
	}
	
}

//*************************   help function for finding if an object is contained in an array - id (Antonis)   **************************
function arrayContains(array, index) {
	for (var i=0; i<array.length; i++){
		if (array[i].attr("id") == index) return true;
	}
	return false;
}


//*************************   "open" function for toggling a div by means of div container & id   **************************
function toggleDiv(grp, id) {
	for(var i=0; i<grp.myElements.length; i++){
		if (grp.myElements[i].attr("id")==id) {
			toBeToggled_man = grp.myElements[i].myBody;
			toBeToggled_man.toggleMe(toBeToggled_man);
			break;
		}
	}
}

var multClick = true; // var that does not allow multiple clicks
	
//*************************   the actual toggle function   **************************
function internalToggleDiv(id)
{
	if (typeof id == "undefined") {
		id = this;
	}
	var toggleThis = id.divItem.myBody;
	var toggleElems;
	var chk = false;

	if ((id.allDivs.groupType.indexOf("group") > -1) && (id.divItem!=id.allDivs.openDiv)) {
	// if the type is "group"
		if (multClick) {
//			multClick = false;
			if (id.allDivs.openDiv!='undefined') {
				toggleElems = id.allDivs.openDiv.myBody;
				if (id.allDivs.openDiv.myHead != 'undefined') {
					if  (id.allDivs.clickableHeader || (typeof this.myElements[i].data('header').id != 'undefined')) { // noImgUp
						var mytmp0 = id.allDivs.openDiv;
						id.allDivs.openDiv.myHead.attr('style', id.allDivs.normalState);
						divsToggleImg(mytmp0, 0);
						id.allDivs.openDiv.myHead.hover(
							function () {
								$(this).attr('style', id.allDivs.mouseOverState);
								divsToggleImg(mytmp0, 1);
							},
							function () {
								$(this).attr('style', id.allDivs.normalState);
								divsToggleImg(mytmp0, 0);
							}
						);
						//id.allDivs.openDiv.myHead.mouseout(function () {
						//		$(this).attr('style', id.allDivs.normalState);
						//		divsToggleImg(mytmp0, 0);
						//	});
					}
				}
				chk = true;
			}
			
			if (id.divItem.myHead != 'undefined') {
//				id.divItem.myHead.css('cursor', 'auto');
				id.divItem.myHead.attr('style', id.allDivs.selectedState);
				divsToggleImg(id.divItem, 2);
				id.divItem.myHead.hover(
					function () {$(this).attr('style', id.allDivs.selectedState); divsToggleImg(id.divItem, 2);},
					function () {$(this).attr('style', id.allDivs.selectedState); divsToggleImg(id.divItem, 2);}
				);
				//id.divItem.myHead.mouseout(function () {$(this).attr('style', id.allDivs.selectedState); divsToggleImg(id.divItem, 2);});
			}

			// change "opened Div" var
			id.allDivs.openDiv = id.divItem;

			if (chk)
				doAnimate(toggleElems, toggleThis);
			
			// RETURN TO DEFAULT ON MOUSE OUT 
			var divDefault = $("*[class*='divToggle'][id='"+id.allDivs.prefix+"-default']"); //alert(divDefault.attr('id'));
			if (divDefault.attr('id')) {// alert('antonis');
				$.each(id.allDivs.myElements, function () {
					var dvTmp = this;
					if (this.attr('id') == divDefault.attr('id')) {
						toggleThis.divItem.myHead.mouseout(function () {
							setTimeout(function() { 
								dvTmp.myHead.trigger(id.allDivs.eventTrigger); 
							}, id.allDivs.duration+10);
						});
					}
				});
			}
		}
		
	} else if (id.allDivs.groupType.indexOf("single") > -1) {
	// if the type is "single"
		
//		if (multClick) {			--> do allow multiple clicks!
//			multClick = false;
			if (id.divItem.isClosed) {
				doAnimate(toggleThis, 0, 1);
				toggleThis.divItem.isClosed = false;
				divsToggleImg(id.divItem, 2);
				id.divItem.myHead.attr('style', id.divItem.allDivs.selectedState);
				id.divItem.myHead.hover(
					function () {
						$(this).attr('style', id.allDivs.mouseOverState);
						divsToggleImg(id.divItem, 3);
					},
					function () {
						$(this).attr('style', id.allDivs.selectedState);
						divsToggleImg(id.divItem, 2);
					}
				);
				//id.divItem.myHead.mouseout(function () {
				//		$(this).attr('style', id.allDivs.selectedState);
				//		divsToggleImg(id.divItem, 2);
				//	});
			} else {
				doAnimate(toggleThis);
				toggleThis.divItem.isClosed = true;
				divsToggleImg(id.divItem, 0);
				id.divItem.myHead.attr('style', id.divItem.allDivs.normalState);
				id.divItem.myHead.hover(
					function () {
						$(this).attr('style', id.allDivs.mouseOverState);
						divsToggleImg(id.divItem, 1);
					},
					function () {
						$(this).attr('style', id.allDivs.normalState);
						divsToggleImg(id.divItem, 0);
					}
				);
				//id.divItem.myHead.mouseout(function () {
				//		$(this).attr('style', id.allDivs.normalState);
				//		divsToggleImg(id.divItem, 0);
				//	});
			}

//		}
		
	} else if (id.allDivs.groupType.indexOf("dual") > -1) {
	// if the type is "dual"
		if (multClick) {
			multClick = false;
			
			if (id.allDivs.openDiv!='undefined') {
				toggleElems = id.allDivs.openDiv.myBody;
				if (id.allDivs.openDiv.myHead != 'undefined') {
					var mytmp0 = id.allDivs.openDiv;
					id.allDivs.openDiv.myHead.attr('style', id.allDivs.normalState);
					divsToggleImg(mytmp0, 0);
					id.allDivs.openDiv.myHead.hover(function () {
							$(this).attr('style', id.allDivs.mouseOverState);
							divsToggleImg(mytmp0, 1);
						},
						function () {
							$(this).attr('style', id.allDivs.normalState);
							divsToggleImg(mytmp0, 0);
						}
					);
					//id.allDivs.openDiv.myHead.mouseout(function () {
					//		$(this).attr('style', id.allDivs.normalState);
					//		divsToggleImg(mytmp0, 0);
					//	});
				}
//				id.allDivs.openDiv.myHead.mouseover(function () {$(this).attr('style', id.allDivs.mouseOverState);});
				chk = true;
			}
			
//			alert('isclosed? '+id.divItem.isClosed);
			if (id.divItem.isClosed) {
				//if every tab was closed
				
				if (id.divItem.myHead != 'undefined') {
	//				id.divItem.myHead.css('cursor', 'auto');
					id.divItem.myHead.attr('style', id.allDivs.selectedState);
					divsToggleImg(id.divItem, 2);
					id.divItem.myHead.hover(
						function () {$(this).attr('style', id.allDivs.mouseOverState); divsToggleImg(id.divItem, 3);},
						function () {$(this).attr('style', id.allDivs.selectedState); divsToggleImg(id.divItem, 2);}
					);
					//id.divItem.myHead.mouseout(function () {$(this).attr('style', id.allDivs.selectedState); divsToggleImg(id.divItem, 2);});					
				}

//				alert('aa '+(id.allDivs.groupType.indexOf("closecontainer") > -1) && id.allDivs.container.isClosed);
				if ((id.allDivs.groupType.indexOf("closecontainer") > -1) && id.allDivs.container.isClosed) {
					id.allDivs.container.isClosed = false;
					doAnimate(toggleThis.allDivs.container, 0, 1);
				}
				
				// change "opened Div" var
				id.allDivs.openDiv = id.divItem;

//				alert('chk='+chk);
				if (chk) {
					toggleElems.divItem.isClosed = true;
					doAnimate(toggleElems, toggleThis);
				} else {
					toggleThis.divItem.isClosed = false;
					doAnimate(toggleThis, 0, 1);
				}
				
			} else {
				// change "opened Div" var - none will be opened!
				
				if ((id.allDivs.eventTrigger != 'mouseover') || dualFlag) {

					dualFlag = 0;
					id.allDivs.openDiv = 'undefined';

					if (id.divItem.myHead != 'undefined') {
						id.divItem.myHead.attr('style', id.allDivs.normalState);
						divsToggleImg(id.divItem, 0);
						id.divItem.myHead.hover(
							function () {$(this).attr('style', id.allDivs.mouseOverState); divsToggleImg(id.divItem, 1);},
							function () {$(this).attr('style', id.allDivs.normalState); divsToggleImg(id.divItem, 0);}
						);
						//id.divItem.myHead.mouseout(function () {$(this).attr('style', id.allDivs.normalState); divsToggleImg(id.divItem, 0);});
						
					}

					toggleThis.divItem.isClosed = true;
					doAnimate(toggleThis);
					if (id.allDivs.groupType.indexOf("closecontainer") > -1) {
						id.allDivs.container.isClosed = true;
						doAnimate(id.allDivs.container); //if closing the last tab
					}
				} else {
					multClick = true;
				}
			}
		}
	}
	
}


var options = {};
var toLoadAjaxTo = 'null';
//*************************   helper functions for opening/closing divs   **************************
function doAnimate(div, afterDiv, flag)
{
//	alert(1);
	time = div.allDivs.duration;
	effect = div.allDivs.minTrans;
	autoHeight = div.allDivs.widen;
	
//	if (!div.divItem.isClosed) {
//		div.divItem.isClosed=true;
//	alert('afterDiv='+afterDiv);
		if (afterDiv)	afterDiv.divItem.isClosed=false;
		multClick = false;
//		if ((typeof div.allDivs.container == 'undefined') || (div.attr('id') != div.allDivs.container.attr('id')))

//			var complete = function() { if(!self) return; return self._completed.apply(self, arguments); };

			options = {
				toShow: (afterDiv)? afterDiv : 'no',
				toHide: div,
//				complete: complete,
//				down: '',
				autoHeight: autoHeight,
				easing: effect,
				duration: time
			};
				
			var overflow = 'hidden'/*MAYBE AUTO?*/,	//MEGALI DEFTERA (voitheia mas)
				zIndex = (options.toShow!='no')? options.toShow.css('z-index'): 'no',
				showProps = {},
				hideProps = {},
				fxAttrs = [],
				fxHeightAttrs = ["height", "paddingTop", "paddingBottom", "borderTopWidth", "borderBottomWidth"],
				fxWidthAttrs = ["width", "paddingLeft", "paddingRight", "borderRightWidth", "borderLeftWidth"],
				fxOpacityAttrs = ["opacity"];
			
			if (jQuery.inArray(("height"), div.allDivs.effect) != -1) {		
				fxAttrs = fxAttrs.concat(fxHeightAttrs);
			}
			if (jQuery.inArray(("width"), div.allDivs.effect) != -1) {				
				fxAttrs = fxAttrs.concat(fxWidthAttrs);
			}
			if (jQuery.inArray(("opacity"), div.allDivs.effect) != -1) {				
				fxAttrs = fxAttrs.concat(fxOpacityAttrs);
			}
						
			$.each(fxAttrs, function(i, prop) {
				hideProps[prop] = (flag)? parseFloat(options.toHide.maxDimens[prop]): parseFloat(options.toHide.minDimens[prop]);
				showProps[prop] = (options.toShow!='no')? parseFloat(options.toShow.maxDimens[prop]): 'no';
			});
			
//			options.toHide.hide();
			
			
			/*M TRITH*/
			if (div.allDivs.containerWidth || div.allDivs.containerHeight) {
				overflow = 'auto';
			}
			
			/* ANIMATION */
			if (options.toShow == 'no') {
				dAnimateDual(options, hideProps, fxAttrs);
			}
			else if (div.allDivs.transOrder==="both") {
//				alert('pre: height:'+options.toShow.divItem.myHead.css('height'));
//				alert('pre: marginTop:'+options.toShow.divItem.myHead.css('marginTop'));
//				alert('pre: marginBottom:'+options.toShow.divItem.myHead.css('marginBottom'));
				if (jQuery.inArray(("opacity"), div.allDivs.effect) != -1)
					options.toShow.show(); //exit();
//				alert('post: height:'+options.toShow.divItem.myHead.css('height'));
//				alert('post: marginTop:'+options.toShow.divItem.myHead.css('marginTop'));
//				alert('post: marginBottom:'+options.toShow.divItem.myHead.css('marginBottom'));
//				(options.toShow!='no')? options.toShow.css({overflow: 'hidden'}).show(): 'no';
				dAnimateBoth(options, hideProps, showProps, fxAttrs, overflow);
			} else if (div.allDivs.transOrder==="open") {
				(options.toShow!='no')? options.toShow.css({overflow: 'hidden'}).show(): 'no';
				dAnimateOpen(options, hideProps, showProps, fxAttrs, zIndex, overflow);
			} else if (div.allDivs.transOrder==="close") {
				dAnimateClose(options, hideProps, showProps, fxAttrs, overflow);
			} 

			toLoadAjaxTo = (options.toShow == 'no')? options.toHide: options.toShow;
			// AJAX
			if (toLoadAjaxTo.divItem && toLoadAjaxTo.divItem.data('ajaxCall')) {
				toLoadAjaxTo.html('<div style="width:100%; height:100%; background-image: url('+toLoadAjaxTo.divItem.data('ajaxPreloader')+'); background-repeat:no-repeat; background-position:center center;"></div>');
				setTimeout("loadAjax(toLoadAjaxTo)", options.duration+10);
			}
			/* --- */
//	}
	setTimeout('multClick = true; ',time); //do not allow multiple clicks!
}

function loadAjax(itemAjax) {
	itemAjax.load(itemAjax.divItem.data('ajaxCall'), function() {
//		alert("height: "+"#"+itemAjax.attr('id')+":first ~ *");
//		alert($(itemAjax+":first").nextAll().html());
		//each(function () {alert("height: ");});
	});
}


function dAnimateDual(options, hideProps, fxAttrs) {

//	alert('...: '+hideProps['height']);
	options.toHide.animate(hideProps,{
		step: function(now, settings) {
			// if the alwaysOpen option is set to false, we may not have
			// a content pane to show
			if (!options.toShow[0]) { return; }
		},
		duration: options.duration,
		easing: options.easing,
		complete: function() {
			$.each(fxAttrs, function(i, prop) {
				options.toHide.css(prop, hideProps[prop]);
			});

			options.toHide.css('overflow', 'hidden');
//			if (options.toHide.divItem.isClosed) options.toHide.hide();
			/*options.complete();*/
		}
	});
}

function dAnimateBoth(options, hideProps, showProps, fxAttrs, overflow) {
			
	options.toHide.animate(hideProps,{
		step: function(now, settings) {
			// if the alwaysOpen option is set to false, we may not have
			// a content pane to show
			if ((options.toShow == 'no') || (!options.toShow[0])) { return; }
//	alert(1);

			if (settings.prop == 'opacity') {
				options.toHide[0].style["filter"] = 'alpha(opacity:'+options.toHide[0].style["opacity"]+')';
				options.toShow[0].style["filter"] = 'alpha(opacity:'+options.toShow[0].style["opacity"]+')';
			}
	
				var percentDone = settings.start != settings.end
					? (settings.now - settings.start) / (settings.end - settings.start)
					: 0,
					current = percentDone * showProps[settings.prop];
				if ($.browser.msie || $.browser.opera) {
					current = Math.ceil(current);
				}
				
//				alert(settings.prop);
				if (settings.prop == 'opacity') {
					if ($.browser.msie) {
//						alert(11);
						options.toShow.fadeIn();
					}
					else {
						options.toShow[0].style["filter"] = 'alpha(opacity='+current*100+')';
						options.toShow[0].style[settings.prop] = current;
					}
//						alert('filter = '+options.toShow[0].style["filter"]);
				} else {
						options.toShow[0].style[settings.prop] = current+'px';
				}
//				options.toShow[0].style[settings.prop] = (settings.prop == 'opacity')? ((settings.prop=='filter')?current*100:current): current+'px';
		},
		duration: options.duration,
		easing: options.easing,
		complete: function() {
			options.toShow[0].style["filter"] = 0;
//			alert('completed! '+options.toShow[0].style["filter"]); 
			$.each(fxAttrs, function(i, prop) {
				options.toHide.css(prop, hideProps[prop]);
//				alert('inwhile: hideprops['+prop+']='+hideProps[prop]);
			});

//			alert(2);
			if (options.toShow != 'no')	options.toShow.css('overflow', overflow);
//			alert(3);
			options.toHide.css('overflow', 'hidden');
			if (jQuery.inArray(("opacity"), fxAttrs) != -1)
				options.toHide.hide();
			/*options.complete();*/
				
//				alert('width: '+options.toShow.css('width'));
//				alert('height: '+options.toShow.css('height'));
		}
	});
}

function dAnimateOpen(options, hideProps, showProps, fxAttrs, zIndex, overflow) {
	options.toShow.css('z-index', parseInt(zIndex)+1);
				
	options.toShow.animate(showProps,{
		step: function(now, settings) {
			// if the alwaysOpen option is set to false, we may not have
			// a content pane to show
			if ((options.toShow == 'no') || (!options.toShow[0])){ return; }
		},
		duration: options.duration,
		easing: options.easing,
		complete: function() {

			options.toShow.css({overflow: overflow});
			/*options.complete();*/
		
			options.toHide.animate(hideProps,{
				step: function(now, settings) {
					// if the alwaysOpen option is set to false, we may not have
					// a content pane to show
					if (!options.toShow[0]) { return; }
				},
				duration: options.duration,
				easing: options.easing,
				complete: function() {
					$.each(fxAttrs, function(i, prop) {
						options.toHide.css(prop, hideProps[prop]);
					});
					options.toHide.css('overflow', 'hidden');
					
					options.toShow.css('z-index', zIndex);
					if (jQuery.inArray(("opacity"), fxAttrs) != -1)
						options.toHide.hide();
					/*options.complete();*/
				}
			});
		}
	});
}

function dAnimateClose(options, hideProps, showProps, fxAttrs, overflow) {
	options.toHide.animate(hideProps,{
		step: function(now, settings) {
			// if the alwaysOpen option is set to false, we may not have
			// a content pane to show
			if ((options.toShow == 'no') || (!options.toShow[0])) { return; }
		},
		duration: options.duration,
		easing: options.easing,
		complete: function() {
			$.each(fxAttrs, function(i, prop) {
				options.toHide.css(prop, hideProps[prop]);
			});

			if (jQuery.inArray(("opacity"), fxAttrs) != -1)
				options.toHide.hide();
			
			options.toHide.css('overflow', 'hidden');
			
			$.each(fxAttrs, function(i, prop) {
				showProps[prop] = parseFloat(options.toShow.maxDimens[prop]);
			});


			if (jQuery.inArray(("opacity"), fxAttrs) != -1)
				options.toShow.css({overflow: 'hidden'}).show();
			options.toShow.animate(showProps,{
				step: function(now, settings) {
					// if the alwaysOpen option is set to false, we may not have
					// a content pane to show
					if ((options.toShow == 'no') || (!options.toShow[0])) { return; }
				},
				duration: options.duration,
				easing: options.easing,
				complete: function() {
					options.toShow.css({overflow: overflow});
					/*options.complete();*/
				}
			});
			/*options.complete();*/
		}
	});
}

// keep only numbers of a string (remove non-numbers ---> http://www.27seconds.com/kb/article_view.aspx?id=31
function stripAlphaChars(pstrSource) 
{ 

	var m_strOut = new String(pstrSource); 

    m_strOut = m_strOut.replace(/[^0-9]/g, ''); 

    return m_strOut; 
}