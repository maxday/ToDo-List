function isCorrectMail(inm) {
	var reg = new RegExp (/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/); // Typique e-mail 
	return(reg.test(inm));
} 

function addMail() { 
	var mail = $('#mail').val(); 
	if ( isCorrectMail(mail) ) {
			$.ajax({
			   type: "GET",
			   url: "reg.php",
			   data: "mail=" + escape(mail),
			   success: function(){
			     alert( "Email enregistré ! Merci :)"); 
			   }
			 });
		}
		else {
			alert("Email est incorrect !")
		}
}

function toto(){
	return null;
}


$(document).ready(function(){	
	$('#submitbutton').click(addMail);
});
