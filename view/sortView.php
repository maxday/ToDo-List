<?php
	if ( ! isset($_SESSION) ) {
		session_start();
	}
	require_once('../model/tags.php');
	require_once('../model/tasks.php');
?>
<div id="sortOptions" style="text-align: center;">
	<img src="./img/alarm.png" id="sortByDate"/> <br />
	<img src="./img/stock_mail-priority-high.png" id="sortByImportance"> <br />
	<div class="basic" style="margin: 0 auto;" id="sortByPriority"></div> 
	<hr />
	<!-- Tris pas categorie -->
	
	<?php 
		echo computeHtmlFromTags(getTagsFromUuid($_SESSION['uuid']), true);
	?>
	<hr />
	<img src="./img/reset.png" id="reset" />
</div>