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
			addBluebox(this.value, this.textContent);
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
   		'onClose': function() {
			console.log("tot");
		}
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

		$.post(url, { pass: passChosen },
			function (data) {
			  $.fancybox.close();
			  // montrer que c'est protégé,  changer l'icone? empecher de changer le pass?
			}
		);
   });
   
	$('#form_change_password').live("submit",function(e) {
      e.preventDefault();
      //console.log($('#form_protect_input').val());
	  var oldPass = $('#form_change_password_old').val();
      var passChosen = $('#form_change_password_input').val();
      
      if (passChosen.length < 1 || oldPass.length < 1) {
         $("#errorLogin").html('<div class="alert warning">Remplissez tous les champs !</div>');
		 parent.$("#fancybox-content").width($(document).width());
         return;
      }
      
		var url = '../ws/changePassword.php';
		$.post(url, { pass: passChosen, old: oldPass},
			function (data) {
			  console.log(data);
				if(data == "2"){
					$("#errorLogin").html('<div class="alert warning">Mot de passe incorrect !!</div>');
					parent.$("#fancybox-content").width(500);

				}
				else
					$.fancybox.close();
			}
		);
		$("#form_change_password_old").val("");
		$("#form_change_password_input").val("");
   });


   $('.tagButton').draggable({
	cancel:false,
	//containment:"#newTask",
	helper:maxDhelper
	});

  	$('.tagButton').live("mouseenter",function(e) {
		var id = $(this).attr("dragNdrop");
		
		var tab = $("span.tagButton").children();
		for(j=0;j<tab.length;j++)
			if(id && $(tab[j]).attr("fakeId") && $(tab[j]).attr("fakeId") == id.replace(".","")) {
				if($(tab[j]).parent().attr("class").indexOf("dontDisplayX") == -1)
					$(tab[j]).parent().show();
			}
	});

	

	
	$('.tagButton').live("mouseleave",function(e) {
	    $(".deleteTag").hide();
	});
	
	$('.tagButton a').live("click",function(e) {
	    
		var uuidTagToDelete = $(this).attr("id");
		console.log(uuidTagToDelete);
		var url = '../ws/deleteTag.php';
		$.post(url, { tag: uuidTagToDelete},
			function (data) {
				console.log(data);
            }
		);
	
	    var rank=Math.floor(Math.random()*1001);
		var rank2=Math.floor(Math.random()*1001);

	    $(this).parent().parent().replaceWith("<span class='forDelete'><button target='#new_label_input_"+rank+"' class='new_label i_plus icon tagButton"+rank2+"'>Nouveau</button><input type='text' id='new_label_input_"+rank+"' class='new_label_input'><span class='tagButton deleteTag'><a href=#>[X]</a></span></span>");
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
  if(draggable.attr("class").indexOf("task")==0)
		return;

  console.log("Tu mets le tag uuid = " + draggable.attr('value') +  "sur la tache" + $(this).attr('id'));
  var url = "../ws/addTagToTask.php";
  var task_value = $(this).attr('id');
  var tag_value = draggable.attr('dragNdrop') ;
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

function addBluebox(identifier, lblCat) { 
	var activeFilters = $('#activeSorts'); 
	identifier = identifier.replace('.', '_');
	var divId = "selected" + identifier; 
	lblCat = getLibelleForBluebox(identifier, lblCat);
	if ( $('#' + divId).length == 0 ) {
		jQuery("<div>", {
	 		id: divId,
			class: 'cat',
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
	    	click: function() {
	       		$(this).remove();
				// On rafraichit la liste avec les filtres selectionnes
				var selectedFilters = $('#activeSorts .cat');
				var serializedSt = "";
				var date, priority, importance;
				for ( var i = 0 ; i < selectedFilters.length ; i++) {
					serializedSt += '&&' + selectedFilters[i].id;
				}
				if ( $('#selectedDate').length != 0 ) {
					date = $('#selectedDate').text();
				}
				if ( $('#selectedImportance').length != 0 ) {
					importance = $('#selectedImportance').text();
				}
				if ( $('#selectedPriority').length != 0 ) {
					priority = $('#selectedPriority').text();
				}
				console.log(date + " categories " + serializedSt + " pr " + priority + " importance " + importance);
	    	}
		}).appendTo(activeFilters);
	}
}
