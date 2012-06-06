<?php require("../model/tags.php"); ?>
<form id="newTask" method="post" autocomplete="off" class="clearfix"> 
	<section id="taskzone" class="inline">
		<div class="g6" style="margin-top: 45px;">
			<input type="text" id="text_field_task" class="taskUnFocus" name="text_field" style="" />
			<hr class="littleSpace" />
			<button class="i_bended_arrow_down icon small" style="float:right;">GO</button></div>
			<div class="g3">
				<h5 class="titreTask">Catégories</h5>
				
				<?php 
					echo computeHtmlFromTags(getTagsFromUuid($_SESSION['uuid']));
				?>

				
			</div>
			<div class="g3">
				<h5 class="titreTask">Options</h5>
				<section>  
					<img src="img/date.png" /> 	      
					<input id="date" name="date" type="text" class="date optionLine"><br />
					<img src="img/stock_mail-priority-high.png" alt="Importance ?"/> &nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkimp" name="checkimp" /><br />
					Priorité <!-- basic exemple -->  <div class="basic" id="insertPriority"></div>  
				
				</section>	
			</div>
		</section>  
	</form>