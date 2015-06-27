<form action="homepage.html">
<input name="Go back home" type="submit" value="Go back home" />
</form>

<form action="viewTables.php" method="post">

<input name="submitbutton" type="submit" value="back" />


<?php

echo "<br>";
echo "<br>";

$selectedoption = $_POST['listOption'];

echo 'Selected Table ';
echo $selectedoption;
echo "<br>";


$apswd = $_POST['pswd'];
$auser = $_POST['user'];


$con = mysqli_connect("localhost:3306",$auser,$apswd);

if($con)
{

	echo "connected to householdfinance database" . "<br>";
	
	$statement = "SELECT * from $selectedoption;";
	echo $statement . "<br>";

	mysqli_select_db($con,'householdfinance');
	$result = mysqli_query($con,$statement);
	if(!$result)
	{
		echo "you are fucked";
		echo exit;
	}

	echo "Number of rows in result: " . mysqli_num_rows($result) . "<br>";

	$i = 0;
	$j = 0;
	$numfields = mysqli_num_fields($result);

	echo "number of fields = " . $numfields . "<br>";

	echo "<table width='600' cellpadding='5' cellspacing='5' border='l'>";
	echo"<tr>";
	while($i < $numfields)
	{
		$afield = mysqli_fetch_field($result)->name;
		echo "<td>".$afield."</td>";
		$i++;
	}
	echo "</tr>";

	$i = 0;

	while($j < mysqli_num_rows($result))
	{
		$row = mysqli_fetch_array($result);

		echo"<tr>";

		while($i < mysqli_num_fields($result))
		{
			echo "<td>".$row[$i]."</td>";
			$i++;
		}
		echo "</tr>";

		$i=0;

		$j++;
	}

	echo "</table>";

	mysqli_close($con);
}
else
{
	echo "failed to connect to database";
}

echo "<br>";

?>
 
<input name="submitbutton" type="submit" value="back" />

</form>

<form action="homepage.html">
<input name="Go back home" type="submit" value="Go back home" />
</form>