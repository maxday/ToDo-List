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
	var date = "";

    $.post(url, { date: date},
		function (data) {
			$("#taskListRefresh").html(data);
		}
	);	
});