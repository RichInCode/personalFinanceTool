<?php

	// connect to the database
	//$con=mysqli_connect("localhost:3306",$auser,$apswd);
	$con=mysqli_connect("localhost:3306","root","","householdfinance");

	if(! $con)
	{
		die('Could not connect: ' . mysql_error());
	}


	// want to put a date filter, but for now use all
	$query = "SELECT type, SUM(amount) as total FROM current_money where type!='Gotpaid' GROUP BY type";


	//mysqli_select_db($con,"householdfinance");
	$retval = mysqli_query($con,$query);
	if(! $retval )
	{
		die('Could not retrieve data: ' . mysql_error());
		exit;
	}
	$numrows = mysqli_num_rows($retval);	
	if($numrows == 0) 
	{
		echo "No rows found, nothing to print so am exiting";
   		exit;
	}
	
	$json = array();

	for($i=0; $i<$numrows; $i++)
	{
		$row = mysqli_fetch_assoc($retval);
		//echo $row["rich_checking"];
		$json[] = $row;
	}

	echo json_encode($json);

	mysqli_close($con);

?>