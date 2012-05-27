// Home-made functions - MyToDo

/*----------------------------------------------------------------------*/
/* Methodes relatives a l'ajout de taches
/*----------------------------------------------------------------------*/

$(document).ready(function () {
	$("#text_field_task").bind("keypress", function(event){  
		// Touche entree
        if(event.keyCode==13){
			var title = $('#text_field_task').val();
			var url = 'ws/addTask.php';
			$.post(url, { title_task: title},
				function (data) {
					if(data == "1") {
						alert("rafraichir div liste de taches");
					} else { 
						alert("message error");
					}
				}
			);
        }
	});
});