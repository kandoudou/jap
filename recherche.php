
<?php
	include('db.php');

	
	if($_POST["envoi"] && $_POST["address_postal_code"] !== 0 && $_POST["address_city"] !== 0 )
	{
		$question 	= $_POST["address_postal_code"];
		$questions 	= $_POST["address_city"];
		$result = mysql_query(" SELECT * FROM `table 1` WHERE `address_postal_code`='$question' OR `address_city`='$questions'");


	// Execute the query (the recordset $rs contains the result)

	// Loop the recordset $rs
	// Each row will be made into an array ($row) using mysql_fetch_array
	while($row = mysql_fetch_array($result)) {
	   // Write the value of the column FirstName (which is now in the array $row)
	   echo $row['name'] . "<br />";

	  }
		
		
	}
	
	    
?>