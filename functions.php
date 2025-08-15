<?php

// Include config file
require_once "config.php";

function read_contacts() {
	// Prepare a select statement
	$sql = "SELECT * FROM contacts ORDER BY id";

	$contacts = $link->execute_query($sql);
}

?>