// Home-made functions - MyToDo

/*----------------------------------------------------------------------*/
/* Methodes relatives a l'ajout de taches
/*----------------------------------------------------------------------*/

var lastTagClicked = null;
var priority = -2;

$(document).ready(function () {
	$("#newTask").bind("submit", function(event){  

		var lastDateChosen = $("#date").val();
		var title = $('#text_field_task').val();
		var url = './ws/addTask.php';
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
		alert("Dernier tag clické = " + lastTagClicked);
		event.preventDefault();
	});
	
});

