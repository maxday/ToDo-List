function bindAddTask() {
	
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
			SelectedPriority = 0;
		}
		var complexeTask = computeTask(title, lastTagClicked, SelectedPriority, isImportant, lastDateChosen);

		if ( isCreatingNewTag == true ) { 
			isCreatingNewTag = false; 
			event.preventDefault();
		}
		else {
			$.post(url, { complexeTask: complexeTask},
			function (data) {
				$('#text_field_task').val("");
				$("#taskListRefresh").html(data);
				$('.calendar').fullCalendar( 'refetchEvents' );
				refreshList();
			}
		);
		}
		
		
	});
	
}

function bindCreateNewLabel() {
	
	$(".new_label").live("click", function(event){
            event.preventDefault();
            $(this).addClass('inactive');

            var id = $(this).attr("target");
            $(id).show();
            $(id).addClass("active");
            $(id).focus();
    });

    $(".new_label_input").live("blur",function(e){
       var label = $('.new_label.inactive');
       var new_tag_name = $(this).val();

       if (new_tag_name == "") {
          label.removeClass("inactive");
       } else {
          if ( lastBlured == null ) {
			 isCreatingNewTag = true;
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
	});
}


function bindDragTag() {
	$('.tagButton').draggable({	
		cancel:false,
		helper:handlerDragTask
	});
}


function bindDisplayXOnTagButton() {
	$('.tagButton').live("mouseenter",function(e) {
		var id = $(this).attr("dragNdrop");
	
		var tab = $("span.tagButton").children();
		for(j=0;j<tab.length;j++)
			if(id && $(tab[j]).attr("fakeId") && $(tab[j]).attr("fakeId") == id.replace(".","")) {
				if($(tab[j]).parent().attr("class").indexOf("dontDisplayX") == -1)
					$(tab[j]).parent().show();
			}
	});
}

function bindHideXOnTagButton() {
	$('.tagButton').live("mouseleave",function(e) {
	    $(".deleteTag").hide();
	});
}
function bindCreateProtectForm() {
	// fancyBox pour securize account
   $("a#trigger_protect").fancybox();

   // soumission du form pour proteger le passwword
   $('#form_protect').live("submit",function(e) {
		e.preventDefault();
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

	// soumission du form pour changer le password
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
}



function bindDeleteTag() {
	$('.tagButton a').live("click",function(e) {
	    
		var uuidTagToDelete = $(this).attr("id");
		console.log(uuidTagToDelete);
		var url = '../ws/deleteTag.php';
		$.post(url, { tag: uuidTagToDelete},
			function (data) {
				console.log(data);
				// Rafraichir le panel de tris de droite avec le nouveau tag crée
				refreshRightSortPanel();
            }
		);
	
	    var rank=Math.floor(Math.random()*1001);
		var rank2=Math.floor(Math.random()*1001);

	    $(this).parent().parent().replaceWith("<span class='forDelete'><button target='#new_label_input_"+rank+"' class='new_label i_plus icon tagButton"+rank2+"'>Nouveau</button><input type='text' id='new_label_input_"+rank+"' class='new_label_input'><span class='tagButton deleteTag'><a href=#>[X]</a></span></span>");
	});
	
}



function bindTaskListAsDroppable() {
	console.log("je dropable");
	console.log("TOP");
	console.log($('.task'));
	$('.task').droppable( {
        drop: handlerDropItemOnList
	});
}



function bindDraggableCalendar() {
	console.log($('.ui-widget-content'));
	$('.ui-widget-content').draggable({
		helper:handlerDragDate,
		stop:function(){
			$(".singleDueDate").css("border","0px");
			var tab = $(".singleDueDate");
			for(var i=0; i<tab.length; ++i)
				if(tab[i].innerHTML == "Drop moi !")
					tab[i].innerHTML = "";
			
		}
	});
}




function bindSort() {
	
	/* Tri par date */
	$('#sortByDate').bind('click', function() {
		console.log("alalalal");
		$('#sortByDate').addClass("buttonPushed selectedDate");
		launchMultiCritQuery("date");
	});

	/* Tri par importance */
	$('#sortByImportance').bind('click', function() {
		$('#sortByImportance').addClass("buttonPushed selectedImportance");
		launchMultiCritQuery("importance");  
	});
	
	/* Desactiver les tris actifs */
	$('#reset').bind('click', function() {
		var url = './tasksList.php'; 
		$('#sortByImportance').removeClass("buttonPushed selectedImportance");
		$('#sortByDate').removeClass("buttonPushed selectedDate");
		$('#sortByPriority').removeAttr('selectedPriority');
	    $.post(url,
			function (data) {
				// Désactiver les tris actifs
				$('.sortTagButton').removeClass('buttonPushed');
				$('#activeSorts').empty();
				refreshList();
			}
		);	
	});
}


function bindDeleteTask() {
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
					$('.calendar').fullCalendar( 'refetchEvents' );
                 }
			}
		);
	});
}
