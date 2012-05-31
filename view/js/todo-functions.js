// Home-made functions - MyToDo

/*----------------------------------------------------------------------*/
/* Methodes relatives a l'ajout de taches
/*----------------------------------------------------------------------*/

$(document).ready(function () {
	$("#newTask").bind("submit", function(event){  
		// Touche entree 
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
});

/* sauvegarde du tag */

$(".tagButton").bind("click", function(event){
	alert("kikoo");  
}