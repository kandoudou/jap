<?php
	
	include('db.php');


	// SQL query
	$strSQL = "SELECT * FROM `table 1` ";

	// Execute the query (the recordset $rs contains the result)
	$rs = mysql_query($strSQL);

	// Loop the recordset $rs
	// Each row will be made into an array ($row) using mysql_fetch_array
	while($row = mysql_fetch_array($rs)) {

	   // Write the value of the column FirstName (which is now in the array $row)
	  echo $row['name'] . "<br />";

	  }

	// Close the database connection
	mysql_close();
?>