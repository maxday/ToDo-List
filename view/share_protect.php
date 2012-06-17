<?php
	if(empty($_SESSION)) {
		session_start();
	}
?>
<div id="searchbox">
	<ul id="headernav">
		<li>
			<ul class="inline">
				<li id="howdy_button"><h3 id="lg_text">Bonjour <?php echo $_SESSION['login'] ?> ! <img src="./img/smile.png" /></h3></li>
			</ul>
			<ul class="inline">
				<li class="headerButton"><a id="trigger_share" href="#share_list">Partager ! <img src="img/fileshare.png" /></a></li>
			</ul>
			<ul class="inline">
				<li class="headerButton"><a id="trigger_protect" href="#protect_form">
					<?php 
						if(!isProtected($_SESSION['uuid']))
							echo '<div id="wordingProtect">Protéger !</div> <img width="32" src="img/unlocked.png" /></a></li>';
						else
							echo '<div id="wordingProtect">Protégé</div> <img width="32" src="img/locked.png" /></a></li>';
					?>
			</ul>
			<ul class="inline">
				<li class="headerButton">
				    <a href="./deco.php">Quitter ! <img src="img/logout.png" style="width:32px;height:32px;"> </a>
				</li>
			</ul>
		 </li>
		</ul>
	</div>