// Home-made functions - MyToDo

/*----------------------------------------------------------------------*/
/* Methodes relatives a l'ajout de taches
/*----------------------------------------------------------------------*/

var lastTagClicked = null;
var priority = -2;
var isImportant = false;

$(document).ready(function () {
	
	$("#newTask").bind("submit", function(event){  

        if($("#checkimp").attr('checked')) {
			isImportant = true;
		}
		else
			isImportant = false;

		var lastDateChosen = $("#date").val();
		var title = $('#text_field_task').val();
		var url = './../ws/addTask.php';

		
		var complexTask = computeTask(title, lastTagClicked, priority, isImportant, lastDateChosen);
		
		alert(complexTask);

		

		$.post(url, { title_task: title},
			function (data) {
				if(data == "1") {
					alert("rafraichir div liste de taches");
				} else { 
					alert(data + "message error");
				}
			}
		); 
	});
	
	/* SAVE TAG */
	$(".tagButton").bind("click", function(event){
	    lastTagClicked = $(this).attr("value");
		event.preventDefault();
	});
	
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
		return "-pp";
	if(priority == '-1')
		return "-p";
	if(priority == '+1')
		return "+p";
	if(priority == '+2')
		return "+pp";	
	return "";	
}
