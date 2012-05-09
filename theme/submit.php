This ist just for demonstration purpose!

Here are all variables sent to the server:
<?php 
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		//AJAX Request
		echo print_r($_POST, true);		
	}else{
		//Native Form Submit
		echo '<br><textarea style="width:100%;height:90%">'.print_r($_POST, true).'</textarea>';
	}

?>
