// Home-made functions - MyToDo

/*----------------------------------------------------------------------*/
/* Methodes relatives a l'ajout de taches
/*----------------------------------------------------------------------*/

var lastTagClicked = null; 
var isImportant = false;
var lastBlured = null;

var isCreatingNewTag = false;
// Attention: Priorite memorisee par le plugin jRating > Variable SelectedPriority initialisee dans le fichier jRating.jquery.js ... :/

$(document).ready(function () {
	
	//mettre le focus sur le champ de tache au démarrage
	$("#text_field_task").focus();

	//script étoile pour priorité des taches
	$(".basic").jRating({ step:true, 
		length : 3 // nb of stars  
	});
	
	//effet bordure noire si du texte est present dans le champ d'ajout de tache
	$("#text_field_task").bind("keyup", function(event){
		if($(this).val()=="")
			$(this).removeClass("buttonPushed");
		else
			$(this).attr("class", "buttonPushed");
	});
	
	//effet bordure noire si du texte est present dans le champ de date
	$("#date").bind("change", function(event){
		if($(this).val() == "")
			$(this).removeClass("buttonPushed");
		else
			$(this).addClass("buttonPushed");
	});
	
	makeListSortable();
			
	bindAddTask();
	
	/* TODO PROBLEME ICI */
	/* SAVE TAG */ 
	$(".tagButton").live("click", function(event){
		console.log("kikoo");
		if ( this.id != '') {
			// Provient des tris >> Tri par categorie
			addBluebox(this.value, this.textContent);
			if ( $(this).hasClass('buttonPushed') ) {
				$(this).removeClass("buttonPushed");
				// Mise a jour des tris
			}
			else {
			    $(this).addClass("buttonPushed");
				//Mise a jour des tris
			}
			sortByCategory(this.value);
		}
		else {
			// Tags de la div "InsertTache"
	    	lastTagClicked = $(this).attr("value");
	    	$(".tagButton").removeClass("buttonPushed");
		    $(this).addClass("buttonPushed");
	    }
		event.preventDefault();
	});


	bindCreateNewLabel();
	bindDeleteTask();
	bindCreateProtectForm();
	bindDragTag();
	bindDisplayXOnTagButton();
  	bindHideXOnTagButton();
	bindDeleteTag();
	bindTaskListAsDroppable();
	bindSort();


});
 
function handlerDragTask( event ) {
  return '<div id="draggableHelper">Déplacer ce tag sur une tâche</div>';
}

function handlerDragDate( event ) {
  return '<div id="draggableHelper">Déplacer cette date sur une tâche</div>';
}

function handlerDropItemOnList( event, ui ) {
  var draggable = ui.draggable;

//si reorder 
  if(draggable.attr("class").indexOf("task")==0)
		return;

//si date
  if(draggable.attr("class").indexOf("fc-day-number")!=-1) {
		var day = draggable.html();
		var month = $('.calendar').fullCalendar('getDate').getMonth()+1;
		var year = $('.calendar').fullCalendar('getDate').getYear()+1900;
		var url = "../ws/addDateToTask.php";
		var task_value = $(this).attr('id');
		$.post(url, { dateD: day, dateM: month, dateY:year, taskId : task_value }, function (data) {
				;
		  });
		// XXX REFRESH XXX
		return;
  }

//si tag 
  var url = "../ws/addTagToTask.php";
  var task_value = $(this).attr('id');
  var tag_value = draggable.attr('dragNdrop') ;
  $.post(url, { task: task_value, tag: tag_value }, function (data) {
		;
  });
  // XXX REFRESH XXX
}


function launchAjaxNewTag(input, tag, tag_value) { 
        lastBlured = input;
        tag.text(tag_value); 

        tag.removeClass("new_label");
        tag.removeClass("i_plus");
        tag.removeClass("icon");
        tag.removeClass("inactive");
        tag.addClass("tagButton");

		tag.draggable({
			cancel:false,
			//containment:"#newTask",
			helper:handlerDragTask
		});
		
        // appel ajax pour créer le tag :)
        var url = "../ws/addTag.php";
		var url_sort = "../view/sortView.php";
        // il faudra ensuite vérifier peut être qu'on a bien recup un uuid, et si non... que faire?
        $.post(url, { tag: tag_value }, function (data) {
		   tag.attr("value", tag_value);
		   tag.attr("dragNdrop", data);
		   tag.next().next().children().attr("id",data);
		   tag.next().next().children().attr("fakeId",data.replace(".",""));
        });




		// On rafraichit la liste des tris
		$.post(url_sort, function (data) {
		   $("#sortOptions").html(data);
        });	
}


function computeTask(title, lastTagClicked, priority, isImportant, lastDateChosen) {
        // il faut vérifier que l'utilisateur est avancé ou non, complex
	var toReturn = title;
	if(lastTagClicked != null)
		toReturn += " -l " + lastTagClicked;
	if(priority != null)
		toReturn += " " + computePriorityPrefix(priority);
	if(isImportant)
		toReturn += " -i";
	if(lastDateChosen != "")
		toReturn += " -d " + lastDateChosen.replace(/\//g, '-');
	return toReturn;
}

function computePriorityPrefix(priority) {
	if(priority == '1')
		return "-p";
	if(priority == '2')
		return "-q";
	if(priority == '3')
		return "-r"; 	
	return "";	
}

function getLibelleForBluebox(identifier, val) {
	if ( identifier == "Priority") {
		return "+" + val;
	}
	if ( identifier == "Importance") {
		if ( val == 1 ) {
			return "Important";
		}
		return "Pas important";
	}
	if ( identifier == "Date") {
		if ( val == "" )
			return "Date décroissante"; 
	}
	return val;
}

function getClass(identifier) {
	if ( identifier == 'Date' || identifier == 'Importance' || identifier == 'Priority' ) {
		return "sortableItem";
	}
	else {
		return "cat";
	}
	
} 


/* Tri par priorite - Methode appelee par le plugin jRating */ 
function sortByPriority(priority) {
	$('#sortByPriority').attr('selectedPriority', priority);
	launchMultiCritQuery("priority"); 
}
// Appelé ligne 50 
function sortByCategory(category) {
	$('.cat').remove();
	addBluebox(category);
	launchMultiCritQuery("category");
}

function launchMultiCritQuery(sender) {
	var selectedFilters = $('#sortOptions .buttonPushed');
	var serializedSt = "";
	var date, priority, importance;
	
	// Parse des catégories
	for ( var i = 0 ; i < selectedFilters.length ; i++) {
		if ( selectedFilters[i].innerHTML != "undefined")
			serializedSt += '&&' + selectedFilters[i].value;
	}
	
	// Parse de la date
	if ( $('#sortOptions .selectedDate').length != 0 ) {
		date = "2012-06-07"; // Ce sera dynamique avant le 15 juin inchallah !
	}
	
	// Parse de l'importance
	if ( $('#sortOptions .selectedImportance').length != 0 ) {
		importance = 1;
	}
	else {
		importance = 0;
	}
	
	// Parse de la priorité
	if ( $('#sortByPriority').length != 0 ) {
		priority = $('#sortByPriority').attr('selectedPriority'); 
	}
	var senderF = sender;
	// Requete Multi-critères  
	console.log("Resultat serialization: " + serializedSt);
	var url = './../ws/sortTasksByParameters.php';
	$.post(url, { date: date, importance: importance, priority: priority, category : serializedSt}, function (data) {
		if ( data == "" ) {
			data = "Pas de tâches correspondant à ces critères. Ajoutez une tâche en utilisant le panel juste au-dessus !";
		}
		$("#taskListRefresh").html(data);  
		if ( sender == "importance" ) { 
			addBluebox("Importance", importance);
		}
		if ( sender == "priority") { 
			addBluebox("Priority", priority);
		}
		if ( sender == "date") { 
			addBluebox("Date", date);
		}  
    });	
}

function addBluebox(identifier, value) {  
	console.log(identifier + " hello " + value);
	var activeFilters = $('#activeSorts'); 
	identifier = identifier.replace('.', '_');
	var divId = "selected" + identifier; 
	var lblCat = getLibelleForBluebox(identifier, value);
	var divClass = getClass(identifier);
	if ( $('#' + divId).length == 0 ) {
		jQuery("<div>", {
	 		id: divId,
			//class: divClass,
	 		html: '<b>' + lblCat + '</b>',
	    	css: {
	        	height: "25px",
				borderRadius: "3px white",
				marginLeft : "10px",
				fontSize : "16px",
				paddingLeft: "15px",
				paddingRight : "15px",
				lineHeight: "20px",
	        	width: "70px",
	        	color: "#f1f3ff",
	        	backgroundColor: "#7894e5",
				display : "inline"
	    	},
			realValue : value,
	    	click: function() { 
	       		$(this).remove();
				if ( $('#activeSorts').children().size() == 0 ) {
					// On a désactivé tous les filtres
					$('#sortByImportance').removeClass("buttonPushed selectedImportance");
					$('#sortByDate').removeClass("buttonPushed selectedDate");
					$('#sortByPriority').removeAttr('selectedPriority');
					$('.sortTagButton').removeClass('buttonPushed');
					launchMultiCritQuery(sender);	
				}
				else {			
					var sender = "undefined";
					if ( identifier == "Date") {
						$('#sortByDate').removeClass("buttonPushed selectedDate");
					}
					if ( identifier == "Priority") {
						$('#sortByPriority').removeAttr('selectedPriority');
					}
					if ( identifier == "Importance") {
						$('#sortByImportance').removeClass("buttonPushed selectedImportance");
					}
					if ( identifier.indexOf('_') > 0 ) {
						// Categorie 
						$('.sortTagButton').removeClass('buttonPushed');
					}
					// On rafraichit la liste avec les filtres selectionnes
					launchMultiCritQuery(sender);
				}
				
	    	}
		}).appendTo(activeFilters);
		$("#" + divId).addClass(divClass);
	}
}
