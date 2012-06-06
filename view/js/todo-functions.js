// Home-made functions - MyToDo

/*----------------------------------------------------------------------*/
/* Methodes relatives a l'ajout de taches
/*----------------------------------------------------------------------*/

var lastTagClicked = null; 
var isImportant = false;
var lastBlured = null;
// Attention: Priorite memorisee par le plugin jRating > Variable SelectedPriority initialisee dans le fichier jRating.jquery.js ... :/

$(document).ready(function () {



        $("#text_field_task").focus();
	
	$("#taskSortList").sortable({ 
		update: function(event, ui) {
			
			var url = "./../ws/reOrder.php";
			var orderTask = $(this).sortable('toArray').toString();
			
			
		    $.post(url, { order: orderTask},
				function (data) {
					console.log(data);
				}
			);
		}
		
		
	});
	$("#taskSortList").disableSelection();
			
	$("#newTask").bind("submit", function(event){  

		var title = $('#text_field_task').val();
		if(title=="")
			return;
        if($("#checkimp").attr('checked')) {
			isImportant = true;
		}
		else
			isImportant = false;

		var lastDateChosen = $("#date").val();
		var url = './../ws/addComplexTask.php';
		if ( typeof(SelectedPriority) == "undefined") {
			SelectedPriority = 1; // Valeur par défaut ?
		}
		var complexeTask = computeTask(title, lastTagClicked, SelectedPriority, isImportant, lastDateChosen);
		
		//alert(complexTask);

		$.post(url, { complexeTask: complexeTask},
			function (data) {
			                $('#text_field_task').val("");
					$("#taskListRefresh").html(data);
			}
		); 
	});
	
	/* SAVE TAG */
	$(".tagButton").live("click", function(event){
	    lastTagClicked = $(this).attr("value");
	    $(".tagButton").removeClass("buttonPushed");
	    $(this).addClass("buttonPushed");
		if ( this.id != '') {
			// Provient des tris >> Tri par categorie
			sortByCategory(this.value);
		}
		event.preventDefault();
	});

	$("#text_field_task").bind("keyup", function(event){
		if($(this).val()=="")
			$(this).removeClass("buttonPushed");
		else
			$(this).attr("class", "buttonPushed");
	});
	
	$("#date").bind("change", function(event){
		if($(this).val() == "")
			$(this).removeClass("buttonPushed");
		else
			$(this).addClass("buttonPushed");
	});
	
        $(".new_label").live("click", function(event){

                event.preventDefault();
                $(this).addClass('inactive');

                var id = $(this).attr("target");
                $(id).show();
                $(id).addClass("active");
                $(id).focus();
        });



        $(".new_label_input").live("blur",function(){

           var label = $('.new_label.inactive');
           var new_tag_name = $(this).val();

           if (new_tag_name == "") {
              label.removeClass("inactive");
           } else {
              if ( lastBlured == null ) {
                 launchAjaxNewTag($(this),label,new_tag_name);
              } else {
                 if ( lastBlured.attr("id") != $(this).attr("id") ) {
                    launchAjaxNewTag($(this),label,new_tag_name);
                 }

              }
           }

           $(this).hide();
        });


        // TODO cette version est peut être pas assez cross browser
	$('.new_label_input.active').live('keypress', function(e) {
	        if (e.keyCode==13) {
	                $(this).blur();
	        }
	})

	// Etoiles pour les priorités
	// more complex jRating call 

	$(".basic").jRating(
		{ step:true, 
			length : 3 // nb of stars  
		}); 



   // tâche completée
	$('span.deleteTask').live("click",function(e) {

		var url = './../ws/completeTask.php';
		var _this = $(this);
		var mother_node = $(this).parent();
		var bdd_id = mother_node.attr("id");

		$.post(url, { task: bdd_id},
			function (data) {
			        if (data != "Alerte") {
			           _this.hide();
                    mother_node.hide("slow");
                 }
			}
		);
	});
	
	
	$("a#trigger_protect").fancybox({
   		//'hideOnContentClick': true
   });
   	
   $('#form_protect').live("submit",function(e) {
      e.preventDefault();
      //console.log($('#form_protect_input').val());
      var passChosen = $('#form_protect_input').val();
      
      if (passChosen.length < 1) {
         // faire un affichage 
         return;
      }
      
		var url = '../ws/setProtection.php';

		$.post(url, { pass: passChosen},
			function (data) {
		      $.fancybox.close();
		      // montrer que c'est protégé,  changer l'icone? empecher de changer le pass?
			}
		);
      
      
      
   });


   $('.tagButton').draggable({
	cancel:false,
	//containment:"#newTask",
	helper:maxDhelper
	});

	$('.task').droppable( {
	    drop: maxDhandler
	});
  


});
 
function maxDhelper( event ) {
  return '<div id="draggableHelper">Déplacer ce tag sur une tâche</div>';
}

function maxDhandler( event, ui ) {
  var draggable = ui.draggable;
  console.log("Tu mets le tag uuid = " + draggable.attr('value') +  "sur la tache" + $(this).attr('id'));
  var url = "../ws/addTagToTask.php";
  var task_value = $(this).attr('id');
  var tag_value = draggable.attr('value') ;
  $.post(url, { task: task_value, tag: tag_value }, function (data) {
		console.log(data);
  });

  url = './tasksList.php'; 
  $.post(url,
		function (data) {
			$("#taskListRefresh").html(data);
		}
	);
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
			helper:maxDhelper
		});
		
        // appel ajax pour créer le tag :)
        var url = "../ws/addTag.php";
		var url_sort = "../view/sortView.php";
        // il faudra ensuite vérifier peut être qu'on a bien recup un uuid, et si non... que faire?
        $.post(url, { tag: tag_value }, function (data) {
		   tag.attr("value", data);
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
