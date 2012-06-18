<?php require("../model/tags.php"); ?>
<form id="newTask" method="post" autocomplete="off" class="clearfix"> 
	<section id="taskzone" class="inline">
		<div class="g5" style="margin-top: 45px;">
			<input type="text" id="text_field_task" class="taskUnFocus" name="text_field" style="" />
			<div id="moreOption" class="moreoptions"><span id="txtOptions">Plus d'options</span></div>
			<hr class="littleSpace" />
			<button class="i_bended_arrow_down icon small">Ajouter ma tâche</button></div>
			<div class="g4 fullOption hidden">
				<h5 id="guidedCat" class="titreTask">Catégories</h5>
				<div id="categoriesList">
				<?php 
					echo computeHtmlFromTags(getTagsFromUuid($_SESSION['uuid']), false);
				?>
				</div>

				
			</div>
			<div class="g3 fullOption hidden">
				<h5 id="guidedOpt" class="titreTask">Options</h5>
				<section>  
					Echéance ?<br />
					<img src="img/date.png" /> 	      
					<input id="date" name="date" type="text" class="date optionLine">
					<hr />
					Est-ce important ?<br />
					<img src="./img/stock_mail-priority-high.png" alt="Importance ?"/> &nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkimp" name="checkimp" />
					<hr />
					Quelle priorité ?<!-- basic exemple -->  <div class="basic" id="insertPriority"></div>  
				
				</section>	
			</div>
			<span id="reinit_crit" class="fullOption hidden">
				<img src="./img/resetcrit.png" width="12px" height="12px"/> Réinitialiser les critères ?
			</span>
		</section>  
	</form>
	