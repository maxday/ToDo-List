$(document).ready(function () {
	$('.fc-day-number').draggable({
		helper:maxDhelper
	});
});


function maxDhelper( event ) {
	return '<div id="draggableHelper">Déplacer ce tag sur une tâche</div>';
}