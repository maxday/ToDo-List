function makeListSortable() {
	
	$("#taskSortList").sortable({ 
	   items: 'li:not(#header_tab)',
		update: function(event, ui) {

			var url = "./../ws/reOrder.php";
			var orderTask = $(this).sortable('toArray').toString();

		    $.post(url, { order: orderTask},
				function (data) {
					//console.log(data);
				}
			);
		}	
	});

	$("#taskSortList").disableSelection();
}