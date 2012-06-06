/** Drag n drop **/
$('.tagButton').draggable({
	cancel:false,
	//containment:"#newTask",
	helper:maxDhelper
});

$('.task').droppable( {
	drop: maxDhandler
});

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
			// Désactiver les tris actifs
			$('.sortTagButton').removeClass('buttonPushed');
			$("#taskListRefresh").html(data); 
			addBluebox("Date", date);
		}
	);	
});

/* Tri par importance */
$('#sortByImportance').bind('click', function() {
	var url = "./../ws/sortTasksByParameters.php"; 
	var important = 1; // Trouver un moyen de choper une checkbox
    $.post(url, { importance : important},
		function (data) {
			// Désactiver les tris actifs
			$('.sortTagButton').removeClass('buttonPushed');
			$("#taskListRefresh").html(data);
			addBluebox("Importance", important);
		}
	);	
});

/* Tri par priorite - Methode appelee par le plugin jRating */ 
function sortByPriority(priority) {
	var url = "./../ws/sortTasksByParameters.php";
    $.post(url, { priority : priority},
		function (data) { 
			// Désactiver les tris actifs
			$('.sortTagButton').removeClass('buttonPushed');
			$("#taskListRefresh").html(data);
			addBluebox("Priority", priority);
		}
	);
}

function sortByCategory(category) {
	var url = "./../ws/sortTasksByParameters.php";
    $.post(url, { category : category},
		function (data) {
			$("#taskListRefresh").html(data);
		}
	);	
}

/* Desactiver les tris actifs */
$('#reset').bind('click', function() {
	var url = './tasksList.php'; 
    $.post(url,
		function (data) {
			// Désactiver les tris actifs
			$('.sortTagButton').removeClass('buttonPushed');
			$('#activeSorts').empty();
			$("#taskListRefresh").html(data);
		}
	);	
});