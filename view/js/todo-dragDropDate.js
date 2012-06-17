var isMoreOptionAreDisplayed = false; 


$(document).ready(function () {
	bindDraggableCalendar();
});




$('#moreOption').live("click", function(event){
	if(isMoreOptionAreDisplayed) {
		var url = "../ws/displayFullOptions.php";
		$.post(url, { show: 0}, function (data) {
		  console.log(data);
		});
	  
		$(".fullOption").hide();
		
		$("#text_field_task").animate({
		    width: "235%",
		    opacity: 0.4,
		    fontSize: "3em",
		    borderWidth: "10px"
		  }, 1000 );
		
		$(".i_bended_arrow_down").css("margin-left", "72%");
		
		
		
		$(this).html("<span id='txtOptions'>Plus d'options</span>");
		if ( $(this).hasClass('lessoptions') ) {
			// L'user s'est amuse a faire (afficher plus / afficher moins)*
			$(this).removeClass('lessoptions');
		}
		$(this).addClass("moreoptions");
		isMoreOptionAreDisplayed = false;
	}
	else {
		var url = "../ws/displayFullOptions.php";
		$.post(url, { show: 1}, function (data) {
		   console.log(data);
		});
	  
		$("#text_field_task").animate({
		    width: "95%",
		    opacity: 0.4,
		    fontSize: "2em",
		    borderWidth: "5px"
		  }, 200 );
		$(".i_bended_arrow_down").css("margin-left", "10px");
		$(".fullOption").show();
		$(this).html("<span id='txtOptions'>Moins d'options</span>");	
		if ( $(this).hasClass('moreoptions') ) {
			// L'user s'est amuse a faire (afficher plus / afficher moins)*
			$(this).removeClass('moreoptions');
		}
		$(this).addClass("lessoptions");
		isMoreOptionAreDisplayed = true;	
	}
});
