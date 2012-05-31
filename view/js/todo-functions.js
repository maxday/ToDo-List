// Home-made functions - MyToDo

/*----------------------------------------------------------------------*/
/* Methodes relatives a l'ajout de taches
/*----------------------------------------------------------------------*/

var lastTagClicked = null;
var priority = -2;
var isImportant = false;


$(document).ready(function () {
	
	$("#newTask").bind("submit", function(event){  

		var title = $('#text_field_task').val();
		if(title=="")
			return;
        if($("#checkimp").attr('checked')) {
			isImportant = true;
		}
		else
			isImportant = false;

		var lastDateChosen = $("#date").val();
		var url = './../ws/addTask.php';
		var complexTask = computeTask(title, lastTagClicked, priority, isImportant, lastDateChosen);
		
		//alert(complexTask);

		$.post(url, { title_task: title},
			function (data) {
				if(data == "1") {
					;
					//alert("rafraichir div liste de taches");
				} else { 
					alert(data + "message error");
				}
			}
		); 
	});
	
	/* SAVE TAG */
	$(".tagButton").bind("click", function(event){
	    lastTagClicked = $(this).attr("value");
	    $(".tagButton").removeClass("buttonPushed");
	    $(this).addClass("buttonPushed");
		event.preventDefault();
	});

	$("#text_field_task").bind("keyup", function(event){
		if($(this).val()=="")
			$(this).removeClass("buttonPushed");
		else
			$(this).attr("class", "buttonPushed");
	});
	
	$("#date").bind("change", function(event){
		if($(this).val() == "")
			$(this).removeClass("buttonPushed");
		else
			$(this).addClass("buttonPushed");
	});
	

	$(".new_label").on("click", function(event){

	        event.preventDefault();

	        var id = $(this).attr("target");
	        $(this).addClass('inactive');
	        $(id).show();
	        //$(id).addClass('active');
	        $(id).focus();
	});

	$(".new_label_input").on("blur",function(){
	        //alert("coucou");

	        var label = $('.new_label.inactive');
	        label.text($(this).val());
                label.removeClass('icon');
                label.removeClass('i_plus');
                label.removeClass('inactive');
                label.addClass('tagButton');
	        label.show();
	        $(this).hide();
	});
/*
	$('.new_label_input.active').bind('keypress', function(e) {
	        if (e.keyCode==13) {
	                console.log("on va blurer mon gros");
	                $(".new_label_input").blur();
	        }
	})
*/

});


function computeTask(title, lastTagClicked, priority, isImportant, lastDateChosen) {
	var toReturn = title;
	if(lastTagClicked != null)
		toReturn += " -l " + lastTagClicked;
	if(priority != null)
		toReturn += " " + computePriorityPrefix(priority);
	if(isImportant)
		toReturn += " -i";
	if(lastDateChosen != "")
		toReturn += " -d " + lastDateChosen;
	return toReturn;
}

function computePriorityPrefix(priority) {
	if(priority == '-2')
		return "--p";
	if(priority == '-1')
		return "-p";
	if(priority == '+1')
		return "+p";
	if(priority == '+2')
		return "++p";	
	return "";	
}
