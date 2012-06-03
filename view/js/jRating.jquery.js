/************************************************************************
*************************************************************************
@Name :       	jRating - jQuery Plugin
@Revison :    	2.2
@Date : 		26/01/2011
@Author:     	 ALPIXEL - (www.myjqueryplugins.com - www.alpixel.fr) 
@License :		 Open Source - MIT License : http://www.opensource.org/licenses/mit-license.php
 
**************************************************************************
*************************************************************************/
(function($) {
	$.fn.jRating = function(op) {
		var defaults = {
			/** String vars **/
			bigStarsPath : './css/light/images/stars.png', // path of the icon stars.png
			smallStarsPath : './css/light/images/small.png', // path of the icon small.png 
			type : 'big', // can be set to 'small' or 'big'
			
			/** Boolean vars **/
			step:true, // if true,  mouseover binded star by star,
			isDisabled:false,
			showRateInfo: true,
			
			/** Integer vars **/
			length:3, // number of star to display
			decimalLength : 0, // number of decimals.. Max 3, but you can complete the function 'getNote'
			rateMax : 20, // maximal rate - integer from 0 to 9999 (or more)
			rateInfosX : -45, // relative position in X axis of the info box when mouseover
			rateInfosY : 5, // relative position in Y axis of the info box when mouseover
			
			/** Functions **/
			onSuccess : null,
			onError : null
		}; 
		
		if(this.length>0)
		return this.each(function() {
			var opts = $.extend(defaults, op),    
			newWidth = 0,
			starWidth = 0,
			starHeight = 0,
			bgPath = '';

			if($(this).hasClass('jDisabled') || opts.isDisabled)
				var jDisabled = true;
			else
				var jDisabled = false;

			getStarWidth();
			$(this).height(starHeight);

			var average = parseFloat($(this).attr('id').split('_')[0]),
			idBox = parseInt($(this).attr('id').split('_')[1]), // get the id of the box
			widthRatingContainer = starWidth*opts.length, // Width of the Container
			widthColor = average/opts.rateMax*widthRatingContainer, // Width of the color Container
			
			quotient = 
			$('<div>', 
			{
				'class' : 'jRatingColor',
				css:{
					width:widthColor
				}
			}).appendTo($(this)),
			
			average = 
			$('<div>', 
			{
				'class' : 'jRatingAverage',
				css:{
					width:0,
					top:- starHeight
				}
			}).appendTo($(this)),

			 jstar =
			$('<div>', 
			{
				'class' : 'jStar',
				css:{
					width:widthRatingContainer,
					height:starHeight,
					top:- (starHeight*2),
					background: 'url('+bgPath+') repeat-x'
				}
			}).appendTo($(this));

			$(this).css({width: widthRatingContainer,overflow:'hidden',zIndex:1,position:'relative'});

			if(!jDisabled)
				$(this).bind({
					mouseenter : function(e){
						var realOffsetLeft = findRealLeft(this);
						var relativeX = e.pageX - realOffsetLeft;
						if (opts.showRateInfo)
							var tooltip =
							$('<p>',{
								'class' : 'jRatingInfos',
								html : ' <span class="maxRate"> '+ getPriority(newWidth) +' </span>',
								css : {
									top: (e.pageY + opts.rateInfosY),
									left: (e.pageX + opts.rateInfosX)
								}
							}).appendTo('body').show();
					},
					mouseover : function(e){ $(this).css('cursor','pointer'); },
					mouseout : function(e){
						$(this).css('cursor','default');
						var realOffsetLeft = findRealLeft(this);
						var relativeX = e.pageX - realOffsetLeft;
					},
					mousemove : function(e){
						var realOffsetLeft = findRealLeft(this);
						var relativeX = e.pageX - realOffsetLeft;
						if(opts.step) newWidth = Math.floor(relativeX/starWidth)*starWidth + starWidth;
						else newWidth = relativeX;
						average.width(newWidth);
						if (opts.showRateInfo)
						$("p.jRatingInfos").css({
							left: (e.pageX + opts.rateInfosX)
						}).html( ' <span class="maxRate"> '+ getPriority(newWidth) +' </span>');
					},
					mouseleave : function(){ $("p.jRatingInfos").remove();},
					click : function(e){
						var realOffsetLeft = findRealLeft(this);
						var relativeX = e.pageX - realOffsetLeft;
						if (opts.showRateInfo) {$("p.jRatingInfos").fadeOut('fast',function(){$(this).remove();});
						alert(getPriorityLevel(newWidth) + " a sauvegarder qque part");
					} 
				}
				});
 
			function getStarWidth(){
				switch(opts.type) {
					case 'small' :
						starWidth = 12; // width of the picture small.png
						starHeight = 10; // height of the picture small.png
						bgPath = opts.smallStarsPath;
					break;
					default :
						starWidth = 23; // width of the picture stars.png
						starHeight = 20; // height of the picture stars.png
						bgPath = opts.bigStarsPath;
				}
			};
			
			function getPriorityLevel(width) {
				var prio;
				switch (width) {
					case 23:
					prio = 1;
					break;
					case 46:
					prio = 2;
					break;
					case 69:
					prio = 3;
					break;
				}
				return prio;
			}
			
			function getPriority(width) {
				var prio;
				switch (width) {
					case 23:
					prio = "Normal";
					break;
					case 46:
					prio = "Urgent";
					break;
					case 69:
					prio = "Critique";
					break;
				}
				return prio;
			}
			
			function findRealLeft(obj) {
			  if( !obj ) return 0;
			  return obj.offsetLeft + findRealLeft( obj.offsetParent );
			};
		});

	}
})(jQuery);