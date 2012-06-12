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
	$('#sortByDate').addClass("buttonPushed selectedDate");
	launchMultiCritQuery("date");
});

/* Tri par importance */
$('#sortByImportance').bind('click', function() {
	$('#sortByImportance').addClass("buttonPushed selectedImportance");
	launchMultiCritQuery("importance");  
});

/* Tri par priorite - Methode appelee par le plugin jRating */ 
function sortByPriority(priority) {
	$('#sortByPriority').attr('selectedPriority', priority);
	launchMultiCritQuery("priority"); 
}

function sortByCategory(category) {
	$('.cat').remove();
	launchMultiCritQuery("category");
}

/* Desactiver les tris actifs */
$('#reset').bind('click', function() {
	var url = './tasksList.php'; 
	$('#sortByImportance').removeClass("buttonPushed selectedImportance");
	$('#sortByDate').removeClass("buttonPushed selectedDate");
	$('#sortByPriority').removeAttr('selectedPriority');
    $.post(url,
		function (data) {
			// Désactiver les tris actifs
			$('.sortTagButton').removeClass('buttonPushed');
			$('#activeSorts').empty();
			$("#taskListRefresh").html(data);
		}
	);	
});