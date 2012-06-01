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