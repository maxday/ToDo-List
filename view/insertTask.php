<?php require("../model/tags.php"); ?>
<form id="newTask" method="post" autocomplete="off" class="clearfix"> 
	<section id="taskzone" class="inline">
		<div class="g5" style="margin-top: 45px;">
			<input type="text" id="text_field_task" class="taskUnFocus" name="text_field" style="" />
			<hr class="littleSpace" />
			<button class="i_bended_arrow_down icon small">GO</button></div>
			<div class="g4 fullOption hidden">
				<h5 class="titreTask">Catégories</h5>
				
				<?php 
					echo computeHtmlFromTags(getTagsFromUuid($_SESSION['uuid']), false);
				?>

				
			</div>
			<div class="g3 fullOption hidden">
				<h5 class="titreTask">Options</h5>
				<section>  
					<img src="img/date.png" /> 	      
					<input id="date" name="date" type="text" class="date optionLine">
					<hr />
					<img src="img/stock_mail-priority-high.png" alt="Importance ?"/> &nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkimp" name="checkimp" />
					<hr />
					Priorité <!-- basic exemple -->  <div class="basic" id="insertPriority"></div>  
				
				</section>	
			</div>
		</section>  
	</form>
	
	<div id="moreOption">Afficher PLUS</div>