<?php

	// connect to the database
	//$con=mysqli_connect("localhost:3306",$auser,$apswd);
	$con=mysqli_connect("localhost:3306","root","","householdfinance");

	if(! $con)
	{
		die('Could not connect: ' . mysql_error());
	}

	$query = "SELECT SUM(amount) as totalOut FROM current_money where type!='Gotpaid'";   


	//mysqli_select_db($con,"householdfinance");
	$retval = mysqli_query($con,$query);
	if(! $retval )
	{
		die('Could not retrieve data: ' . mysql_error());
		exit;
	}

	$query = "SELECT SUM(amount) as totalIn FROM current_money where type='Gotpaid'";
	$retval2 = mysqli_query($con,$query);
	if(! $retval2 )
	{
		die('Could not retrieve data 2: ' . mysql_error());
		exit;
	}

	

	$numrows = mysqli_num_rows($retval);	
	if($numrows == 0) 
	{
		echo "No rows found, nothing to print so am exiting";
   		exit;
	}
	
	$json = array();



	$names = array('totalIn','totalOut');
	$row = mysqli_fetch_assoc($retval);
	$row2 = mysqli_fetch_assoc($retval2);
	$json[] = array('Total In', $row2['totalIn']);
	$json[] = array('Total Out', $row['totalOut']);
	$json[] = array('Net',$row2['totalIn'] - $row['totalOut']);

	echo json_encode($json);

	mysqli_close($con);

?>