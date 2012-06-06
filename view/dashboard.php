<?php
	if(empty($_SESSION)) {
		session_start();
	}
	if ( !isset($_SESSION['login'])) {
		echo print_r($_SESSION);
		echo ":()";
	}
	else { 
?>
<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf-8">

	<title><?php echo $_SESSION['login']."'s ToDo"; ?></title>

	<meta name="description" content="">
	<meta name="author" content="revaxarts.com">


	<!-- Google Font and style definitions --> 
	<link rel="stylesheet" href="css/style.css">

	<!-- include the skins (change to dark if you like) -->
	<link rel="stylesheet" href="css/light/theme.css" id="themestyle">
	<!-- <link rel="stylesheet" href="css/dark/theme.css" id="themestyle"> -->
	<link rel="stylesheet" href="css/styleTasksList.css">

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
	<!-- jQuery files --> 
	<script type="text/javascript" src="./js/jRating.jquery.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	
	
	<script type="text/javascript" src="js/todo-functions.js"></script>
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
		<div id="top">
			<div class="g10 nodrop"> 
				<h3 class="handle" id="leila">Ajouter tache</h3>
				<?php
					include('insertTask.php');
				?> 
			</div>	

		<div class="g2 widgets" style="float:right;">
			<div class="widget" id="widget">
				<h3 class="handle">Tris</b></h3>
				<?php
					include('sortView.php');
				?>
			</div> 
		</div>
		

		<div class="g2 widgets" style="float:right;">
			<div class="widget" id="widget">
				<h3 class="handle">Calendar!</b></h3>
			</div> 
		</div>

	</div>
	<!-- <div style="clear: both; "></div> --> 
	<div class="g10 widgets">
 

		<div class="widget" id="widget_info">
			<h3 class="handle">Liste des tâches</h3>
			<div id="taskListRefresh">
				<?php
					include('tasksList.php')
				?>
			</div>
		</div>

	</div>
</section>
<footer style="visibility : hidden;">(c) MyTodo.fr 2012</footer>

<div id="hidden">
	
	<div class="fancy_content" id="protect_form">
		<section class="box">
			<div class="title">
				<h1>Protège moi</h1>
			</div>
			
			<div>
				<p>
					Veuillez enter un mot de passe pour protéger votre liste
				</p>
				
				<form method="post" autocomplete="off" class="clearfix" id="form_protect">
					<input id="form_protect_input" type="text">  
					<input type="submit" value="Go">
				</form>
				
			</div>
			
		</section>
	</div>
	
</div>


</body>
</html>
<?php } ?>