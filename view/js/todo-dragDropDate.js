var isMoreOptionAreDisplayed = false; 


$(document).ready(function () {
	$('.fc-day-number').draggable({
		helper:handlerDragDate
	});
});





$('#moreOption').live("click", function(event){
	if(isMoreOptionAreDisplayed) {
		$(".fullOption").hide();
		
		$("#text_field_task").animate({
		    width: "235%",
		    opacity: 0.4,
		    fontSize: "3em",
		    borderWidth: "10px"
		  }, 1000 );
		
		$(".i_bended_arrow_down").css("margin-left", "72%");
		
		
		
		$(this).html("Afficher PLUS");
		isMoreOptionAreDisplayed = false;
	}
	else {
		$("#text_field_task").animate({
		    width: "95%",
		    opacity: 0.4,
		    fontSize: "2em",
		    borderWidth: "5px"
		  }, 200 );
		$(".i_bended_arrow_down").css("margin-left", "10px");
		$(".fullOption").show();
		$(this).html("Afficher MOINS");	
		isMoreOptionAreDisplayed = true;	
	}
});
