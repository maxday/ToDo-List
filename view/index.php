<?php

	if(empty($_SESSION)) {
		session_start();
	}

	if (isset ($_SESSION["uuid"])) {
		header('Location: dashboard.php');
	}

?>
<!doctype html>

<html class="no-js">

<head>
<meta charset="utf-8">
<title>MyTodo - Login</title>
<link rel="shortcut icon" href="favicon.png">
<link rel="stylesheet" href="css/style_login.css">
<link rel="alternate stylesheet" type="text/css" media="screen" title="minimal" href="style/minimal.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="dark" href="style/dark.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="image" href="style/wood.css" /> 
 



<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/easyTooltip.js"></script>
<script src="js/modernizr-1.7.min.js"></script> 
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.contentcarousel.js"></script> 

<script src="styleswitch.js" type="text/javascript"></script>




<!-- jquery fancybox-->
<script type="text/javascript">
		
		var prevent = true;
		
		$(document).ready(function() { 
			<?php
				if(isset($_GET['user'])) echo "prevent = false; $('#pwdField').focus(); ";		
			?>
			$("#loginForm").submit(function(event) {

				event.preventDefault();

				var $form = $(this),
				login = $form.find('input[name="login"]').val(),
				url = $form.attr('action');

				if(prevent) {

					if(login.length < 1) {
						$(".errorLogin").html('<div class="alert warning">Login absent !!</div>');
						return false;
					}
					/* Send the data using post */
					$.post(url, { login: login },
						function (data) { 
							if(data == "5") {
								prevent = false;
								$("#pwdHide").show();
								$("#pwdField").focus();
							} else { 
								window.location.href = "dashboard.php";
							}
						}
					);
				} else {
					// la on un mdp
					pass = $form.find('input[name="password"]').val();

					// on revérifie le login et ensuite le pass

					if(login.length < 1) {
						$(".errorLogin").html('<div class="alert warning">Login absent !!</div>');
						return false;
					}

					if(pass.length < 1) { 
						$("#pwdHide").show();
						$("#pwdField").focus();
						$(".errorLogin").html('<div class="alert warning">Mot de passe absent !!</div>');
						return false;
					}

					/* Send the data using post */
					$.post(url, { login: login, pass: pass},
						function (data) {
							if(data == "6") {
							$("#pwdHide").show();
							$("#pwdField").focus();
								$(".errorLogin").html('<div class="alert warning">Mot de passe incorrect !!</div>'); 
								prevent = false;
							} else { 
								window.location.href = "dashboard.php";
							}
						}
					);
				}
			});
			
			$('#loginField').bind("focus", function() {  
				if ( $('#pwdHide').is(':visible')) {
					prevent = true;
					$('.error').remove();
					$('#pwdField').val('');
					$('#pwdHide').hide();
					$('#pwdField').focus();
				} 
			});
	});
</script>
 





</head>
<body>
<div id="gradient">
	
	<div id="main_panel" style="">
	
		<div id="description_panel">
		
			<section class="box" style="width:300px;">
				<div class="title">
					<h1>My ToDoList</h1>
				</div>
			</section>
			
			<div id="wrapper2">

				<div class="conten2">
					
					Gérez votre liste de tâches plus efficacement avec MyToDo !<br/><br/>
					<ul class="description_home">
					<li>N'oubliez plus rien d'important</li>
					<li>Ordonnez vos tâches et retrouvez-les facilement</li>
					<br/>
					<li>Une interface fluide et intuitive</li>
					<li>Les toutes dernières technologies du Web à votre service</li>
					</ul>
					<br /> <br />
					<span style="position:relative; margin-left:50px; margin-top:-10px;">Suivez le guide !<span/>
					<img id="christian" src="img/handArrow.png" width=200> 
				</div>

			</div>
		
		</div>
	
	
	
	
		<div style="float:left;">
	
			<header class="header">
				<div class="logo">
					<a href="#" title=""><img alt="logo" src="img/logo.png"></a>
				</div>
			</header>



			<section class="box">
				<div class="title">
					<h1>Bienvenue</h1>
				</div>
			</section>





			<div id="wrapper">

				<div class="conten">

					<div class="container">
					</div>
					<section id="fondWelcomeTxt" class="subscribe">
						Connectez-vous ou saisissez un login pour créer votre compte !
					</section>
					<section class="subscribe">
						<div class="sub-conten">
							<form id="loginForm" method="post" action="login.php">
								<div class="lineForm">
									<span class="labelForm">Login :</span>
									<span class="fieldForm">
										<input id="loginField" value="<?php if(isset($_GET['user'])) echo $_GET['user']; ?>" name="login" placeholder="">
									</span>
								</div>
								<div id="pwdHide" class="lineForm <?php if(!isset($_GET['user'])) echo "invisible"; ?>">
									<span class="labelForm">Mot de passe :</span>	
									<span class="fieldForm">	
										<input id="pwdField" name="password" type="password" placeholder="">
									</span>
								</div>
								<div class="lineForm">
									<input type="submit" class="submit" id="submit_button" value="Envoyer">
								</div>
								<div class="errorLogin">
					
								</div>
							</form>
						</div>
					</section>
				</div>

			</div>
		
		
		</div>
	</div>
</body>
</html> 
