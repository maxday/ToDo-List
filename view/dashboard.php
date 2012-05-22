<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf-8">

	<title>Bobby's ToDo</title>

	<meta name="description" content="">
	<meta name="author" content="revaxarts.com">


	<!-- Google Font and style definitions --> 
	<link rel="stylesheet" href="css/style.css">

	<!-- include the skins (change to dark if you like) -->
	<link rel="stylesheet" href="css/light/theme.css" id="themestyle">
	<!-- <link rel="stylesheet" href="css/dark/theme.css" id="themestyle"> -->

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
		<div id="top" style="">
			<div class="g10 nodrop">
				<?php
			include('insertTask.php');
			?>
		</div>	


		<div class="g2 widgets" style="float:right;">
			<div class="widget" id="widget_collapsed" data-collapsed="false">
				<h3 class="handle">Tris</h3>
				<div>
					<h3>Tris </h3>
					<p>Img</p>
				</div>
			</div> 
		</div>
	</div>
	<div style="clear: both; "></div> 
	<div class="g10 widgets">
 

		<div class="widget" id="widget_info">
			<h3 class="handle">Liste des tâches</h3>
			<div>
				tache priority (...)
			</div>
		</div>

	</div>
</section>
<footer style="visibility : hidden;">(c) MyTodo.fr 2012</footer>
</body>
</html>