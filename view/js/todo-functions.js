// Home-made functions - MyToDo

/*----------------------------------------------------------------------*/
/* Methodes relatives a l'ajout de taches
/*----------------------------------------------------------------------*/

var lastTagClicked = null; 
var isImportant = false;
var lastBlured = null;

var isCreatingNewTag = false;
// Attention: Priorite memorisee par le plugin jRating > Variable SelectedPriority initialisee dans le fichier jRating.jquery.js ... :/
var clip;

$(document).ready(function () {
	expandAll();
	bindCloseTour();
	//mettre le focus sur le champ de tache au démarrage
	$("#text_field_task").focus();

	//script étoile pour priorité des taches
	$(".basic").jRating({ step:true, 
		length : 3 // nb of stars  
	});
	
	// afficher les options completes si 
	if (displayFullOptions) {
	  $('#moreOption').trigger('click');
	}
	
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
	
	// Bouton reinitialiser les criteres
	$('#reinit_crit').bind("click", function(event) {
		var cats = $('#taskzone .buttonPushed');
		for ( var i = 0 ; i < cats.size(); ++i ) {
			cats.eq(i).removeClass("buttonPushed");
		}
		// Reinitialisation des criteres (23px, 20px chopés depuis jRating.jquery.js, lastTagClicked à nul)
		SelectedPriority = 0;
	  	$(".jRatingAverage").css("width","23px");
	  	$(".jRatingAverage").css("top","-20px"); 
		lastTagClicked = null;
		$('#checkimp').attr('checked', false);
		$('#date').val("");
	});
	makeListSortable();
			
	bindAddTask();
	
	/* TODO PROBLEME ICI */
	/* SAVE TAG */ 
	$(".tagButton").live("click", function(event){
		// Tags de la div "InsertTache"
		if ($(this).attr("class").indexOf("buttonPushed") != -1) {
		   lastTagClicked = null;
		   $(this).removeClass("buttonPushed");
		} else {
	      lastTagClicked = $(this).attr("value");
         $(".tagButton").removeClass("buttonPushed");
		   $(this).addClass("buttonPushed");
	   }
		event.preventDefault();
	});
	
	// Evenements clic surchargé pour les boutons de tri (catégorie)
	$(".sortTagButton").live("click", function(event) {
		// Provient des tris >> Tri par categorie
		if ( $(this).hasClass('buttonPushed') ) {
			$(this).removeClass("buttonPushed");
			// Mise a jour des tris
		}
		else {
		    $(this).addClass("buttonPushed"); 
			//Mise a jour des tris
		} 
		sortByCategory(this.value, this.innerHTML);
		event.preventDefault();	
	});  
	
     clip = new ZeroClipboard.Client();
	 $('#d_clip_button').bind("click", function(event) {
			var textToCopy = $('#urlToShare').val();
			clip.setHandCursor( true );
            clip.setText( textToCopy );
			clip.glue( 'd_clip_button', 'd_clip_container' );
			console.log("je viens de faire un copier coller lol");
			$('#contentOfShareFancyBox').append("<div class='alert success'>Le texte a été copié/collé</div>");
	});
	
	$('#deleteAllTask').live('click', function () {
	   
	   if ($('#taskSortList li.ui-droppable:not(#header_tab)').length > 0) {
	   
   	   var res_confirm = confirm("Voulez vous vraiment supprimer toutes les tâches ?");
	   
   	   if (res_confirm){
      	   var url = "../ws/completeAllTask.php"
      	   $.post(url, {},
      			function (data) { 
      				refreshList();
      			}
      		);
   		}
	   }
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


   $("#draggableHelper").mousedown(console.log("kkk"));

});
 
function handlerDragTask( event ) {
  return '<div class="draggableHelper">Déplacer ce tag sur une tâche</div>';
}

function handlerDragDate( event ) {

  $(".singleDueDate").css("border","1px dashed");
  var tabDate = $(".singleDueDate");
  for(var i=0; i< tabDate.length; ++i) {
		if(tabDate[i].innerHTML=="") {
	 		tabDate[i].innerHTML = "Drop moi !";	
		}	
  }
 

  return '<div class="draggableHelper">Déplacer cette date sur une tâche</div>';
}

function handlerDropItemOnList( event, ui ) {
  console.log("DROP");
  var draggable = ui.draggable;

//si reorder 
  if(draggable.attr("class").indexOf("task")==0)
		return;

//si date
  var realDate = draggable.children().eq(0).children().eq(0);

  if(realDate.length > 0 && realDate.attr("class").indexOf("fc-day-number")!=-1) {
		var day = realDate.html();
		var month = $('.calendar').fullCalendar('getDate').getMonth()+1;
		var year = $('.calendar').fullCalendar('getDate').getYear()+1900;
		var url = "../ws/addDateToTask.php";
		var task_value = $(this).attr('id');
		console.log("JE METS la date SUR" + task_value);
		$.post(url, { dateD: day, dateM: month, dateY:year, taskId : task_value }, function (data) {
			$('.calendar').fullCalendar( 'refetchEvents' );
			refreshList();
		  });	
		return;
  }

//si tag 
  var url = "../ws/addTagToTask.php";
  var task_value = $(this).attr('id');
  var tag_value = draggable.attr('dragNdrop') ;
  $.post(url, { task: task_value, tag: tag_value }, function (data) {
		;
  });
  //refresh list
  refreshList();
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
        // il faudra ensuite vérifier peut être qu'on a bien recup un uuid, et si non... que faire?
        $.post(url, { tag: tag_value }, function (data) {
		   tag.attr("value", tag_value);
		   tag.attr("dragNdrop", data);
		   tag.next().children().attr("id",data);
		   tag.next().children().attr("fakeId",data.replace(".",""));
        });
		// Rafraichir le panel de tris de droite avec le nouveau tag crée
		refreshRightSortPanel();
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
function sortByCategory(category, lblc) {
	//$('.cat').remove(); 
	manageBlueBox(category, lblc);
	launchMultiCritQuery("category");
}

function launchMultiCritQuery(sender) {
	var selectedFilters = $('#sortOptions .buttonPushed');
	var serializedSt = "";
	var date, priority, importance;
	
	// Parse des catégories
	for ( var i = 0 ; i < selectedFilters.length ; i++) {
		if ( selectedFilters[i].innerHTML != "undefined" && selectedFilters[i].innerHTML != "")
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
	var url = './../ws/sortTasksByParameters.php';
	$.post(url, { date: date, importance: importance, priority: priority, category : serializedSt}, function (data) {
		if ( data == "" ) {
			data = "Pas de tâches correspondant à ces critères. Ajoutez une tâche en utilisant le panel juste au-dessus !";
		} 
		//bindList(); 
		if ( sender == "importance" ) { 
			manageBlueBox("Importance", importance);
		}
		if ( sender == "priority") { 
			manageBlueBox("Priority", priority);
		}
		if ( sender == "date") { 
			manageBlueBox("Date", date);
		}   
		$("#taskListRefresh").html(data);
    });	
}

function manageBlueBox(identifier, value) {   
	var activeFilters = $('#activeSorts'); 
	identifier = identifier.replace('.', '_');
	var divId = "selected" + identifier; 
	var lblCat = getLibelleForBluebox(identifier, value);
	var divClass = getClass(identifier); 
	// On cree l'element s'il n'existe pas
	if ( $('#' + divId).length != 0 ) { 
		$('#' + divId).remove();
		if ( divId.indexOf("_") > 0 )
			return;
	}
	if ( $('#' + divId).length == 0 ) {
		jQuery("<div>", {
	 		id: divId,
			//class: divClass,
	 		html: '<b>' + lblCat + '</b>',
	    	css: {
	        	height: "25px",
				borderRadius: "3px solid white",
				marginLeft : "35px",
				fontSize : "16px",
				paddingLeft: "15px",
				paddingRight : "15px",
				lineHeight: "20px",
	        	width: "70px",
	        	color: "#FFFF00",
	        	backgroundColor: "#466168",
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
						// Categorie  - On clique sur une bluebox, on met a jout le panel de tris à droite
						var array = $('.sortTagButton');
						for ( var i=0; i < array.length ; ++i ) {
							if ( array[i].value.replace('.', '_') == identifier ) { 
								var item = $('#' + array[i].id);
								item.removeClass('buttonPushed');
								break;
							} 
						}
					}
					// On rafraichit la liste avec les filtres selectionnes
					launchMultiCritQuery(sender);
				}
				
	    	}
		}).appendTo(activeFilters);
		$("#" + divId).addClass(divClass);
	}
}


function refreshList() {
	url = './tasksList.php'; 
	$.post(url,
		function (data) {
			$("#taskListRefresh").html(data);
			bindTaskListAsDroppable();
			makeListSortable();
		}
	);

}



function refreshRightSortPanel() {
	var url_sort = "../view/sortView.php";
	// On rafraichit la liste des tris
	$.post(url_sort, function (data) {
	   $("#sortOptions").html(data);
    });
}

function bindList() {
	bindTaskListAsDroppable();
	makeListSortable();
}

function expandAll() {
	if(!isMoreOptionAreDisplayed)
		$("#moreOption").trigger("click");
	var tab = $(".collapse");
	for(var o = 0; o<tab.length; ++o) {
		console.log($(".collapse").eq(o));
		if($(".collapse").eq(o).attr("title") == "expand widget")
			$(".collapse").eq(o).trigger("click");
	}
}

function collapseAll() {
	if(isMoreOptionAreDisplayed)
		$("#moreOption").trigger("click");
	var tab = $(".collapse");
	for(var o = 0; o<tab.length; ++o) {
		console.log($(".collapse").eq(o));
		if($(".collapse").eq(o).parent().parent().attr("id") != "widget_info" && $(".collapse").eq(o).attr("title") == "collapse widget")
			$(".collapse").eq(o).trigger("click");
	}
}
