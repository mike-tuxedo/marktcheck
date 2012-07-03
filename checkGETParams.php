<?php

foreach($_GET as $key=>$value)
	if(!is_numeric($value))
		header("location: index.php");

?>
