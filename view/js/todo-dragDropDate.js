var isMoreOptionAreDisplayed = false; 


$(document).ready(function () {
	$('.fc-day-number').draggable({
		helper:handlerDragDate,
		stop:function(){
			$(".singleDueDate").css("border","0px");
			var tab = $(".singleDueDate");
			for(var i=0; i<tab.length; ++i)
				if(tab[i].innerHTML == "Drop moi !")
					tab[i].innerHTML = "";
			
		}
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
		
		
		
		$(this).html("Plus d'options");
		if ( $(this).hasClass('lessoptions') ) {
			// L'user s'est amuse a faire (afficher plus / afficher moins)*
			$(this).removeClass('lessoptions');
		}
		$(this).addClass("moreoptions");
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
		$(this).html("Moins d'options");	
		if ( $(this).hasClass('moreoptions') ) {
			// L'user s'est amuse a faire (afficher plus / afficher moins)*
			$(this).removeClass('moreoptions');
		}
		$(this).addClass("lessoptions");
		isMoreOptionAreDisplayed = true;	
	}
});
