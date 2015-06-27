<?php

require_once 'C:\wamp\apps\jpgraph-3.5.0b1\src\jpgraph.php';
require_once 'C:\wamp\apps\jpgraph-3.5.0b1\src\jpgraph_line.php';
require_once 'C:\wamp\apps\jpgraph-3.5.0b1\src\jpgraph_date.php';

// require_once ('jpgraph.php');
// require_once ('jpgraph_line.php');

$apswd = $_POST['pswd'];
$auser = $_POST['user'];
$ayear = $_POST['year'];
$amonth = $_POST['month'];

$con=mysqli_connect("localhost:3306",$auser,$apswd);

if(! $con)
{
	die('Could not connect: ' . mysql_error());
}

if($amonth == 'all')
{
	$sqlCurrent = "SELECT * FROM bankbalance ORDER BY id;";
}
else
{
//	$sqlCurrent = "SELECT * FROM bankbalance WHERE time < AND time > ORDER BY id;";
}

mysqli_select_db($con,'householdfinance');
$retval = mysqli_query($con,$sqlCurrent);
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

//echo "numrows ".$numrows."\n";

$row = mysqli_fetch_array($retval);

$stack = array($row['total']);
$stackrich = array($row['rich_checking']);
$stackmel = array($row['melissa_checking']);
$stacktime = array($row['id']);

//echo $row['total']."<br>";

for($i=1; $i<$numrows; $i++)
{
	$row = mysqli_fetch_array($retval);
	array_push($stack, $row['total']);
	array_push($stackrich, $row['rich_checking']);
	array_push($stackmel, $row['melissa_checking']);
	//echo $row['total']. "<br>";
	array_push($stacktime, $row['id']);

//	echo $row['id']." ".$row['total']."\n";
}

$graph = new Graph(1000,600);
$graph->SetScale("linlin");

$theme_class = new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Money in Account');
$graph->img->SetAntiAliasing();

//$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($stacktime);
$graph->xgrid->SetColor('#E3E3E3');

$p1 = new LinePlot($stack,$stacktime);
$graph->Add($p1);
$p1->SetLegend('total checking');
$p1->SetWeight(3);

$prich = new LinePlot($stackrich,$stacktime);
$graph->Add($prich);
$prich->SetColor("#B22222");
$prich->SetLegend('rich checking');
$prich->SetWeight(3);

$pmel = new LinePlot($stackmel,$stacktime);
$graph->Add($pmel);
$pmel->SetColor("#FF1493");
$pmel->SetLegend('mel checking');
$pmel->SetWeight(3);

$graph->Stroke();

?>




