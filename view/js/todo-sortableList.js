
$(document).ready(function () {
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


});