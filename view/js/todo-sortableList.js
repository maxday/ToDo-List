/**
Fonctions relatives au tri sur les tâches
**/

$("#taskSortList").sortable({ 
	update: function(event, ui) {

		var url = "./../ws/reOrder.php";
		var orderTask = $(this).sortable('toArray').toString();

	    $.post(url, { order: orderTask},
			function (data) {
				;
			}
		);
	}		
});

$("#taskSortList").disableSelection();

/* Tri par date */
$('#sortByDate').bind('click', function() {
	var url = "./../ws/sortTasksByParameters.php";
	var date = ""; //choper ici une valeur qui aurait pu etre selectionnee dans le futur calendrier

    $.post(url, { date: date},
		function (data) {
			$("#taskListRefresh").html(data);
		}
	);	
});

/* Tri par importance */
$('#sortByImportance').bind('click', function() {
	var url = "./../ws/sortTasksByParameters.php"; 
	var important = 1; // Trouver un moyen de choper une checkbox
    $.post(url, { importance : important},
		function (data) {
			$("#taskListRefresh").html(data);
		}
	);	
});

/* Tri par priorite - Methode appellee par le plugin jRating */ 
function sortByPriority(priority) {
	var url = "./../ws/sortTasksByParameters.php";
    $.post(url, { priority : priority},
		function (data) {
			$("#taskListRefresh").html(data);
		}
	);
}