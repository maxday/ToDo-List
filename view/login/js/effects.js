jQuery(document).ready(function() {




launchTime = new Date(); // Set launch: [year], [month], [day], [hour]...
launchTime.setDate(launchTime.getDate() + 15); // Add 15 days
$("#countdown").countdown({until: launchTime, format: "odHMS"});
	});
		  

	
	
/*-----------------------------------------------------------------------------------*/
/*	Opacity changes
/*-----------------------------------------------------------------------------------*/

	jQuery(".archimage, .entry_title").css({
		opacity: 1
	});
	
	jQuery(".archimage, .entry_title").hover(function() {
		jQuery(this).stop().animate({
			opacity: 0.6
			}, 200);
	},function() {
		jQuery(this).stop().animate({
			opacity: 1
			}, 500);
	});
	
	
		
	
});
