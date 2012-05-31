<form id="newTask" method="post" autocomplete="off" class="clearfix"> 
	<section id="taskzone" class="inline">
		<div class="g6" style="margin-top: 45px;">
			<input type="text" id="text_field_task" class="taskUnFocus" name="text_field" style="" />
			<hr class="littleSpace" />
			<button class="i_bended_arrow_down icon small" style="float:right;">GO</button></div>
			<div class="g3">
				<h5 class="titreTask">Catégories</h5>
				<button class="tagButton pink" value="UTC">UTC</button>
				<button class="tagButton blue" value="Courses">Courses</button>

				<button target="#new_label_input_1" class="new_label i_plus icon purple">Nouveau</button>
				<input type="text" id="new_label_input_1" class="new_label_input">

				<button target="#new_label_input_2" class="new_label i_plus icon purple">Nouveau</button>
				<input type="text" id="new_label_input_2" class="new_label_input">

				<button target="#new_label_input_3" class="new_label i_plus icon purple">Nouveau</button>
				<input type="text" id="new_label_input_3" class="new_label_input">

				<button target="#new_label_input_4" class="new_label i_plus icon purple">Nouveau</button>
				<input type="text" id="new_label_input_4" class="new_label_input">
			</div>
			<div class="g3">
				<h5 class="titreTask">Options</h5>
				<section>  
					<img src="img/date.png" /> 	      
					<input id="date" name="date" type="text" class="date optionLine"><br />
					<img src="img/stock_mail-priority-high.png" alt="Importance ?"/> &nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkimp" name="checkimp" /><br />
					Priorité <img id="p1" src="img/plusone.png" /> <img id="p2" src="img/plustwo.png" /> <img id="p3" src="img/plusthree.png" /> <br />
				</section>	
			</div>
		</section>  
	</form>