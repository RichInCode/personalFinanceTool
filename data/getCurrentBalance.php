<?php
	
	// connect to the database
	//$con=mysqli_connect("localhost:3306",$auser,$apswd);
	$con=mysqli_connect("localhost:3306","root","","householdfinance");

	if(! $con)
	{
		die('Could not connect: ' . mysql_error());
	}


	$query = "SELECT rich_checking,rich_savings,melissa_checking,luna_savings,miles_savings FROM bankbalance ORDER BY id DESC LIMIT 1";


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

	//for($i=0; $i<$numrows; $i++)
	//{
	//	$row = mysqli_fetch_assoc($retval);
	//	//echo $row["rich_checking"];
	//	$json[] = $row;
	//}
	
	$names = array('rich_checking','melissa_checking','rich_savings','luna_savings','miles_savings');
	$row = mysqli_fetch_assoc($retval);
	//echo $row['rich_checking'];
	foreach ($names as $name)
		$json[] = array($name, $row[$name]);

	echo json_encode($json);

	mysqli_close($con);
?>