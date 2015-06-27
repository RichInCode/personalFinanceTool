<?php


	date_default_timezone_set('America/New_York');

	$apswd = $_POST['pswd'];
	$auser = $_POST['user'];

	$con=mysqli_connect("localhost:3306",$auser,$apswd);

	if(! $con)
	{
		die('Could not connect: ' . mysql_error());
	}

	$atype = $_POST['formDoor'];
	$avalue = $_POST['value'];
	$aperson = $_POST['pDoor'];
	$anaccount = $_POST['aDoor'];
	$atime = date('Y-m-d H:i:s');
	$abill = $_POST['bill'];
	


	$sqlCurrent = "SELECT * FROM bankbalance ORDER BY id DESC LIMIT 0,1;";

	mysqli_select_db($con,'householdfinance');
	$retval = mysqli_query($con,$sqlCurrent);
	if(! $retval )
	{
		die('Could not retrieve data: ' . mysql_error());
		exit;
	}
	
	if(mysqli_num_rows($retval) == 0) 
	{
		echo "No rows found, nothing to print so am exiting";
    		exit;
	}

	while($row = mysqli_fetch_assoc($retval))
	{
		extract($row, EXTR_PREFIX_SAME, "wddx");
	}
	
	echo 'Paying bill type: ' . $atype . "<br>";


	if($atype == 'Paybill' || $atype == 'Gas' || $atype == 'Childcare' || $atype == 'Food' || $atype == 'Forfun' || $atype == 'Other')
	{
		if($anaccount == 'cash')
		{
			$cash = $cash - $avalue;		
		}
		if($anaccount == 'debit')
		{
			if($aperson == 'M')
			{
				$melissa_checking = $melissa_checking - $avalue;
			}
			if($aperson == 'R')
			{
				$rich_checking = $rich_checking - $avalue;
			}
		}
		if($anaccount == 'credit')
		{

		}
		if($anaccount == 'savings')
		{
			
		}
	}
	if($atype == 'ATM')
	{
		if($aperson == 'M')
		{
			$melissa_checking = $melissa_checking - $avalue;
		}
		if($aperson == 'R')
		{
			$rich_checking = $rich_checking - $avalue;
		}
		
		$cash = $cash + $avalue;
	}
	if($atype == 'Gotpaid')
	{
		if($aperson == 'M')
		{
			$melissa_checking = $melissa_checking + $avalue;
		}
		if($aperson == 'R')
		{
			if($anaccount == 'debit')
			{
				$rich_checking = $rich_checking + $avalue;
			}
			if($anaccount == 'savings')
			{
				$rich_savings = $rich_savings + $avalue;
			}
		}
		if($anaccount == 'cash')
		{
			$cash = $cash + $avalue;
		}
	}
	
	$newBalance = $rich_checking + $melissa_checking;
	settype($newBalance, "float");
	
	
	$sqlBank = "INSERT INTO bankbalance (rich_checking, rich_savings, melissa_checking, luna_savings, miles_savings, time, total, cash) VALUES (".$rich_checking.",".$rich_savings.",".$melissa_checking.",".$luna_savings.",".$miles_savings.",'$atime',".$newBalance.",".$cash.");";			

	echo $sqlBank . "<br>";

	mysqli_free_result($retval);

	echo $rich_checking . "<br>";
	echo $rich_savings . "<br>";
	echo $melissa_checking . "<br>";
	echo $luna_savings . "<br>";
	echo $miles_savings . "<br>";
	echo $atime . "<br>";
	echo $newBalance . "<br>";	

	$retval = mysqli_query($con,$sqlBank);
	if(!$retval)
	{
		echo "bankbalance database not updated" . mysql_error();
		exit;
	}

	$sql = "INSERT INTO current_money (type, person, amount, current, time, account) VALUES ('$atype','$aperson',".$avalue.",".$newBalance.",'$atime','$anaccount');";


	echo $sql . "<br>";

	$retval = mysqli_query($con,$sql);
	if(!$retval)
	{
		echo "current_money database not updated" . mysql_error();
		exit;
	}


	if($atype == 'Paybill')
	{
		$sqlCurrent = "SELECT * FROM current_money ORDER BY id DESC LIMIT 0,1;";

		$retval = mysqli_query($con,$sqlCurrent);
		if(!$retval)
		{
			echo "query failed" . mysql_error();
			exit;
		}

		//mysqli_free_result($row);

		while($row = mysqli_fetch_assoc($retval))
		{
			extract($row, EXTR_PREFIX_SAME, "wddx");
		}

		$sql = "INSERT INTO billpay (trans_id, name, amount) VALUES (".$id.",'$abill',".$avalue.");";

		$retval = mysqli_query($con,$sql);
		if(!$retval)
		{
			echo "billpay table not updated" . mysql_error();
			exit;
		}

		echo $sql . "<br>";


	}	

	"<br>";

?>


<form action="bankForm.php" method="post">
<input name="submitbutton" type="submit" value="back" />
</form>

<br>

<form action="viewTables.php" method="post">
<input name="submitbutton" type="submit" value="View Table Info" />
</form>

<br>

<form action="homepage.html">
<input name="Go back home" type="submit" value="Go back home" />
</form>