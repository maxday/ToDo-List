
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


});