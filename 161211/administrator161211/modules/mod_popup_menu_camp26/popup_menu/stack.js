var laskarstack = jQuery.noConflict();


laskarstack(function () { 
	// Stack initialize
	var openspeed = 300;
	var closespeed = 300;
	laskarstack('.laskarstack>img').toggle(function(){
		var vertical = 0;
		var horizontal = 0;
		var $el=laskarstack(this);
		$el.next().children().each(function(){
			laskarstack(this).animate({top: '-' + vertical + 'px', left: horizontal + 'px'}, openspeed);
			vertical = vertical + 55;
			horizontal = (horizontal+.75)*2;
		});
		$el.next().animate({top: '-50px', left: '10px'}, openspeed).addClass('openStack')
		   .find('li a>img').animate({width: '50px', marginLeft: '9px'}, openspeed);
		$el.animate({paddingTop: '0'});
	}, function(){
		//reverse above
		var $el=laskarstack(this);
		$el.next().removeClass('openStack').children('li').animate({top: '55px', left: '-10px'}, closespeed);
		$el.next().find('li a>img').animate({width: '79px', marginLeft: '0'}, closespeed);
		$el.animate({paddingTop: '35px'});
	});
	
	// Stacks additional animation
	laskarstack('.laskarstack li a').hover(function(){
		laskarstack("img",this).animate({width: '56px'}, 100);
		laskarstack("span",this).animate({marginRight: '30px'});
	},function(){
		laskarstack("img",this).animate({width: '50px'}, 100);
		laskarstack("span",this).animate({marginRight: '0'});
	});
});