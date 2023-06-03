<?php
	$db = mysqli_connect("localhost","database_user_name","database_user_password","database_name");
	if (!$db) {
		echo "Database Connect Error ".mysqli_error($db);
	}
?>