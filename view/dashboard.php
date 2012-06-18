<?php
	if(empty($_SESSION)) {
		session_start();
	}
	if ( !isset($_SESSION['login'])) {
		header('location:index.php');
	}
	else { 

	include_once("../model/users.php");
?>

<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript"> var displayFullOptions = <?php echo isFullOptions($_SESSION['uuid']); ?>; 
	//console.log(displayFullOptions);
	</script>
	<title><?php echo $_SESSION['login']."'s ToDo"; ?></title>

	<meta name="description" content="">
	<meta name="author" content="revaxarts.com">


	<!-- Google Font and style definitions --> 
	<link rel="stylesheet" href="css/style.css">

	<!-- include the skins (change to dark if you like) -->
	<link rel="stylesheet" href="css/light/theme.css" id="themestyle">
	<!-- <link rel="stylesheet" href="css/dark/theme.css" id="themestyle"> -->
	<link rel="stylesheet" href="css/styleTasksList.css">
	<link rel="stylesheet" href="css/custom.css">	


	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<link rel="stylesheet" href="css/ie.css">
	<![endif]-->

	<!-- Apple iOS and Android stuff -->
	<meta name="apple-mobile-web-app-capable" content="no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">

	<!-- Apple iOS and Android stuff - don't remove! -->
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1">

	<!-- Use Google CDN for jQuery and jQuery UI -->
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>

	<!-- Loading JS Files this way is not recommended! Merge them but keep their order -->

	<!-- some basic functions -->
	<script src="js/functions.js"></script>

	<!-- all Third Party Plugins and Whitelabel Plugins -->
	<script src="js/plugins.js"></script>
	<script src="js/editor.js"></script>
	<script src="js/calendar.js"></script>
	<script src="js/flot.js"></script>
	<script src="js/elfinder.js"></script>
	<script src="js/datatables.js"></script>
	<script src="js/wl_Alert.js"></script>
	<script src="js/wl_Autocomplete.js"></script>
	<script src="js/wl_Breadcrumb.js"></script>
	<script src="js/wl_Calendar.js"></script>
	<script src="js/wl_Chart.js"></script>
	<script src="js/wl_Color.js"></script>
	<script src="js/wl_Date.js"></script>
	<script src="js/wl_Editor.js"></script>
	<script src="js/wl_File.js"></script>
	<script src="js/wl_Dialog.js"></script>
	<script src="js/wl_Fileexplorer.js"></script>
	<script src="js/wl_Form.js"></script>
	<script src="js/wl_Gallery.js"></script>
	<script src="js/wl_Multiselect.js"></script>
	<script src="js/wl_Number.js"></script>
	<script src="js/wl_Password.js"></script>
	<script src="js/wl_Slider.js"></script>
	<script src="js/wl_Store.js"></script>
	<script src="js/wl_Time.js"></script>
	<script src="js/wl_Valid.js"></script>
	<script src="js/wl_Widget.js"></script>

	<!-- configuration to overwrite settings -->
	<script src="js/config.js"></script>

	<!-- the script which handles all the access to plugins etc... -->
	<script src="js/script.js"></script>

	

	<!-- Priorités -->
	<link rel="stylesheet" type="text/css" href="./css/light/jRating.jquery.css" media="screen" /> 
	<link rel="stylesheet" type="text/css" href="./css/dashboard.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./css/style_inserttask.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./css/guidely.css" media="screen" />
	<!-- jQuery files --> 
	<script type="text/javascript" src="./js/jRating.jquery.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript" src="./js/ZeroClipboard.js"></script>

	<script type="text/javascript" src="./js/todo-functions.js"></script>
	<script type="text/javascript" src="./js/todo-dragDropDate.js"></script>
	
	<script type="text/javascript" src="./js/todoBinder.js"></script>
	<script type="text/javascript" src="./js/todoTaskList.js"></script>

	<script type="text/javascript" src="./js/guidely.js"></script>

</head>
<body>
	<!--<div id="pageoptions" style="">
	<ul>
	<li><a href="login.html">Logout</a></li>
	<li><a href="#" id="wl_config">Configuration</a></li>
	<li><a href="#">Settings</a></li>
	</ul>
	<div>-->
		<header>
			<div id="logo">
				<a href="dashboard.html">Logo Here</a>
			</div>
			<div id="header">

				<?php
			include('share_protect.php');
			?>

		</div>
	</header>

	<section id="content">
		
		
		<!-- PARTIE GAUCHE-->
		<div id="left_part" class="tour_1 g9" style="float:left;">
			<div class="nodrop widget"> 
				<h3 class="handle">Ajout d'une tâche</h3>
				<?php
					include('insertTask.php');
				?> 
			</div>
			
			<div id="guidedList" class="widgets tour_2">
				<div class="widget" id="widget_info">
					<h3 class="handle">
						Liste des tâches
						<span id="activeSorts"></span>
					</h3>
					<div id="taskListRefresh">
						<?php
							include('tasksList.php')
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- FIN PARTIE GAUCHE-->
		

		
		<!-- PARTIE DROITE-->
		<div id="right_part" class="g3" style="float:left;">
			<div id="guidedCal" class="widgets">
				<div resource="filter" class="widget" <?php if(isDisplayFilters($_SESSION['uuid'])) echo "data-collapsed='false'"; else echo "data-collapsed='true'"; ?>>
					<h3 class="handle">Filtres</b></h3>
					<?php
						include('sortView.php');
					?>
				</div> 
			</div>

			<div id="guidedSort" class="widgets">
				<div resource="calendar" class="widget" <?php if(isDisplayCalendar($_SESSION['uuid'])) echo "data-collapsed='false'"; else echo "data-collapsed='true'"; ?>>
					<h3 class="handle">Calendrier</b></h3>
					<div class="calendar"></div>
				</div> 
			</div>
		</div>
		<!-- FIN PARTIE DROITE-->
		
		<!-- un clear both pour nettoyer les float-->
		<div style="clear:both"> </div>
	</section>
	
<footer style="visibility : hidden;">(c) MyTodo.fr 2012</footer>

<div class="hidden">
	<!-- Div associées aux Fancyboxes -->
	<div class="fancy_content" id="share_list">
		<section class="box">
			<div class="title">
				<h1>Partager ma liste</h1>
			</div>
			<div id="contentOfShareFancyBox" style="">
				<p id="responseBoxShare"> 
					Envoyez directement ce lien aux personnes avec qui vous souhaitez partager la liste
					<input id="urlToShare" size="10" style="width: 50%;" readonly="readonly" value="http://www.mytodo.fr/<?php echo $_SESSION['login'] ?>">
					<div id="d_clip_container" style="position:relative">
					   <button id="d_clip_button" style="width: 150px !important;">Copier dans le presse-papier</button>
					</div>
				</p>
			</div>
		</section>
	</div>
	
	
	<div class="fancy_content" id="protect_form">
		<section class="box">			
			<?php if(isProtected($_SESSION['uuid'])){ ?>
			
			<div class="title">
				<h1>Gérer mot de passe</h1>
			</div>
			
			<div>
				<p>
					Vous avez déjà protégé votre liste ! <br />
					Mais vous pouvez changer votre mot de passe:
				</p>
				<span id="errorLogin"></span>
				<form method="post" autocomplete="off" class="clearfix" id="form_change_password">
					Ancien mot de passe:&nbsp;&nbsp;&nbsp;
					<input class="passwordInput" id="form_change_password_old" type="password"> <br />
					Nouveau mot de passe:
					<input class="passwordInput" id="form_change_password_input" type="password"> 
					<div class="littleSpace"> <br />
						<div class="textAlignRight" > <input id="submit_button" type="submit" class="submit" value="Changer le mot de passe"> </div>
					</div>
				</form>
			</div>
			<?php } else { ?>
			
			<div class="title">
				<h1>Protéger la liste</h1>
			</div>
			
			<div>
				<div class="littleSpace"> </div> <br />
				<p>
					Veuillez enter un mot de passe pour protéger votre liste
				</p>
				<span id="errorLogin"></span>
				<form method="post" autocomplete="off" class="clearfix" id="form_protect">
					Nouveau mot de passe :
					<div class="littleSpace"> </div> <br />
					<input class="passwordInput" id="form_protect_input" type="password"> </div>
					<div class="littleSpace"> <br />
						<div class="textAlignCenter" > <input id="submit_button" type="submit" class="submit" value="Protéger mon compte"> </div>
					</div>
				</form>
			</div>
			<?php } ?>
		</section>
	</div>
<<script type="text/javascript" charset="utf-8">
	$(function () {

		guidely.add ({
			attachTo: '#text_field_task'
			, anchor: 'bottom-left'
			, title: 'Ajoutez une tache'
			, text: "<strong>Saisissez</strong> simplement l'intitulé de la tâche dans la zone de texte."
		});	
		guidely.add ({
			attachTo: '#guidedCat'
			, anchor: 'top-middle'
			, title: 'Ajoutez une catégorie'
			, text: '<strong>Associez</strong> une catégorie à une tâche. <br />Vous pouvez <strong>créer des catégories</strong> et les <strong>supprimer</strong> selon vos besoins.<br /><br /><strong>Glissez-déposez</strong> une catégorie sur une tâche afin de les associer'
		});
		guidely.add ({
			attachTo: '#guidedOpt'
			, anchor: 'top-middle'
			, title: 'Ajoutez des options'
			, text: '<strong>Définissez</strong> une date butoir, <strong>signalez</strong> si une tâche est importante, <strong>fixez</strong> une priorité.'
		});


		
		guidely.add ({
			attachTo: '#guidedSort'
			, anchor: 'top-left'
			, title: 'Triez vos tâches'
			, text: '<strong>Filtrez</strong> vos tâches selon leur catégorie, leur importance ou leur date butoir.'
		});

		guidely.add ({
			attachTo: '#guidedCal'
			, anchor: 'top-left'
			, title: 'Visualisez votre agenda'
			, text: '<strong>Consultez</strong> rapidement vos tâches.<br /><br /><strong>Glissez-déposez</strong> une date sur une tâche afin de les associer'
		});

			
	
		
		guidely.add ({
			attachTo: '#guidedShared'
			, anchor: 'top-right'
			, title: 'Partagez votre ToDo-List'
			, text: '<strong>Récupérez</strong> l\'adresse de votre liste des tâches afin de la partager avec votre entourage.'
		});
			
		guidely.add ({
			attachTo: '#guidedProtected'
			, anchor: 'top-right'
			, title: 'Protégez votre ToDo-List'
			, text: '<strong>Sécurisez</strong> l\'accès à votre ToDo-List en ajoutant un mot de passe'
		});
		
		guidely.add ({
			attachTo: '#guidedList'
			, anchor: 'bottom-left'
			, title: 'Visualisez vos tâches'
			, text: '<strong>Consultez</strong> les tâches et leurs options, <strong>cliquez</strong> sur la corbeille pour terminer vos tâches, <strong>ordonnez</strong> vos tâches en les glissant-déposant.'
		});

		guidely.init ({ welcome: true, showOnStart : <?php if(hasAtLeastOneTask($_SESSION['uuid'])) echo "false"; else echo "true"; ?> });

	});
</script>
</div>
</body>
</html>
<?php } ?>