<?php
if (isset($_POST['testAjaxRequest'])) {

	echo "Hello there and welcome, " . $_POST['first_name'] 
		 . " " . $_POST['last_name'] . 
		 ". AJAX request sent to this file is successful 
		 and yes, legit, this is from the PHP script!"; 
}
?>