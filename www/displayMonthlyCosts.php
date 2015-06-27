<?php

require_once 'C:\wamp\apps\jpgraph-3.5.0b1\src\jpgraph.php';
require_once 'C:\wamp\apps\jpgraph-3.5.0b1\src\jpgraph_line.php';
require_once 'C:\wamp\apps\jpgraph-3.5.0b1\src\jpgraph_date.php';
require_once 'C:\wamp\apps\jpgraph-3.5.0b1\src\jpgraph_mgraph.php';

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


if($amonth == 'all' && $ayear == '0')
{
	$sqlCurrent = "SELECT * FROM bankbalance ORDER BY id;";
	$sqlCosts = "SELECT * FROM current_money ORDER BY id;";
}
else
{
	if($amonth == 'all')
	{
		$atime1 = "$ayear-01-14 00:00:00";
        	$atime2 = "$ayear-12-31 23:59:59";

	}
	else
	{
		$atime1 = "$ayear-$amonth-01 00:00:00";
        	$atime2 = "$ayear-$amonth-31 23:59:59";
	}


	$sqlCurrent = "SELECT * FROM bankbalance WHERE (time BETWEEN TIMESTAMP('$atime1','YYYY-MM-DD HH:MI:SS') AND TIMESTAMP('$atime2','YYYY-MM-DD HH:MI:SS'));";
	$sqlCosts = "SELECT * FROM current_money WHERE (time BETWEEN TIMESTAMP('$atime1','YYYY-MM-DD HH:MI:SS') AND TIMESTAMP('$atime2','YYYY-MM-DD HH:MI:SS'));";
}

mysqli_select_db($con,'householdfinance');

//// get the bankbalance info
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



for($i=0; $i<$numrows; $i++)
{
	$row = mysqli_fetch_array($retval);
	$stack[] = $row['total'];
	$stackrich[] = $row['rich_checking'];
	$stackmel[] = $row['melissa_checking'];
	$stacktime[] = strtotime($row['time']);	
}


//// get the cost info
$retval = mysqli_query($con,$sqlCosts);
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


$pay = array
(
	array( array( array(), array(), array() ),   // paybill_debit/credit/cash
	       array( array(), array(), array() ),   // gas_debit
	       array( array(), array(), array() ),   // food_debit
	       array( array(), array(), array() ),   // fun_debit
	       array( array(), array(), array() ),   // other_debit
	       array( array(), array(), array() ),   // childcare
	       array( array(), array(), array() ),    // gotpaid
	       array( array(), array(), array() )    // atm
	       ),
	array( array( array(), array(), array() ),   // paybill_debit/credit/cash
	       array( array(), array(), array() ),   // gas_debit
	       array( array(), array(), array() ),   // food_debit
	       array( array(), array(), array() ),   // fun_debit
	       array( array(), array(), array() ),   // other_debit
	       array( array(), array(), array() ),    // childcare
	       array( array(), array(), array() ),    // gotpaid
	       array( array(), array(), array() )    // atm
	       )
);

$pay_t = array
(
	array( array( array(), array(), array() ),   // paybill_debit/credit/cash
	       array( array(), array(), array() ),   // gas_debit
	       array( array(), array(), array() ),   // food_debit
	       array( array(), array(), array() ),   // fun_debit
	       array( array(), array(), array() ),   // other_debit
	       array( array(), array(), array() ),    // childcare
	       array( array(), array(), array() ),    // gotpaid
	       array( array(), array(), array() )    // atm
	       ),
	array( array( array(), array(), array() ),   // paybill_debit/credit/cash
	       array( array(), array(), array() ),   // gas_debit
	       array( array(), array(), array() ),   // food_debit
	       array( array(), array(), array() ),   // fun_debit
	       array( array(), array(), array() ),   // other_debit
	       array( array(), array(), array() ),    // childcare
	       array( array(), array(), array() ),    // gotpaid
	       array( array(), array(), array() )    // atm
	       )
);


$billtypes = array
(
	'Paybill'  => 0,
	'Gas'      => 1,
	'Food'     => 2,
	'Forfun'   => 3,
	'Other'    => 4,
	'Childcare'=> 5,
	'Gotpaid'  => 6,
	'ATM'      => 7
);

$paytypes = array
(
	'debit'    => 0,
	'credit'   => 1,
        'cash'     => 2,
	'savings'  => 3
);

$persontype = array
(	    
	    'R'     => 0,
	    'M'     => 1,
);


$billtypes_rev = array
(
	0   =>  'Paybill',
	1   =>  'Gas',
	2   =>  'Food',
	3   =>  'Forfun',
	4   =>  'Other',
	5   =>  'Childcare',
	6   =>  'Gotpaid',
	7   =>  'ATM'
);

$paytypes_rev = array
(
	0    =>  'debit',
	1    =>  'credit',
        2    =>  'cash',
	3    =>  'savings'
);

$persontype_rev = array
(	    
	0    =>  'R',
	1    =>  'M'
);



// fill data arrays
for($i=0; $i<$numrows; $i++)
{

	$row = mysqli_fetch_array($retval);

	$pay[$persontype[$row['person']]][$billtypes[$row['type']]][$paytypes[$row['account']]][] = $row['amount'];
	$pay_t[$persontype[$row['person']]][$billtypes[$row['type']]][$paytypes[$row['account']]][] =  strtotime($row['time']);


}


$graph = new Graph(1000,600);
$graph->SetScale("datlin");

$theme_class = new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set("Money in Account $ayear-$amonth");
$graph->img->SetAntiAliasing();

//$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
//$graph->xaxis->SetTickLabels($stacktime);
$graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->scale->SetTimeAlign(MONTHADJ_1);
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

//$graph->Stroke();



$graphCosts = new Graph(1000,800);
$graphCosts->SetScale("datlin");

$theme_class = new UniversalTheme;

$graphCosts->SetTheme($theme_class);
//$graphCosts->img->SetAntiAliasing(false);
$graphCosts->title->Set("Outgoing Costs $ayear-$amonth");
//$graphCosts->img->SetAntiAliasing();

//$graphCosts->yaxis->HideZeroLabel();
$graphCosts->yaxis->HideLine(false);
$graphCosts->yaxis->HideTicks(false,false);

$graphCosts->xgrid->Show();
$graphCosts->xgrid->SetLineStyle("dashed");
//$graphCosts->xaxis->SetTickLabels($stacktime);
$graphCosts->xaxis->SetLabelAngle(90);
$graphCosts->xgrid->SetColor('#E3E3E3');
 

$payline = array
(
	array( array( array(), array(), array() ),   // paybill_debit/credit/cash
	       array( array(), array(), array() ),   // gas_debit
	       array( array(), array(), array() ),   // food_debit
	       array( array(), array(), array() ),   // fun_debit
	       array( array(), array(), array() ),   // other_debit
	       array( array(), array(), array() ),    // childcare
	       array( array(), array(), array() ),    // gotpaid
	       array( array(), array(), array() )    // atm
	       ),
	array( array( array(), array(), array() ),   // paybill_debit/credit/cash
	       array( array(), array(), array() ),   // gas_debit
	       array( array(), array(), array() ),   // food_debit
	       array( array(), array(), array() ),   // fun_debit
	       array( array(), array(), array() ),   // other_debit
	       array( array(), array(), array() ),    // childcare
	       array( array(), array(), array() ),    // gotpaid
	       array( array(), array(), array() )    // atm
	       )
);





for($i=0; $i<2; $i++)
{
	for($j=0; $j<8; $j++)
	{
		for($k=0; $k<3; $k++)
		{
			if( !empty($pay[$i][$j][$k]) )
			{

				$payline[$i][$j][$k][] = new LinePlot($pay[$i][$j][$k], $pay_t[$i][$j][$k]);
			}
		}
	}
}



$colors = array
(
	0   =>  "red",
        1   =>  "blue",
	2   =>  "green",
        3   =>  "black",
	4   =>  "yellow",
	5   =>  "pink",
	6   =>  "violet",
	7   =>  "orange"
);

$markers = array
(
	0   => MARK_DIAMOND,
	1   => MARK_SQUARE,
	2   => MARK_FILLEDCIRCLE
);

for($i=0; $i<2; $i++)
{
	for($j=0; $j<8; $j++)
	{
		for($k=0; $k<3; $k++)
		{
			foreach( $payline[$i][$j][$k] as &$index )
			{
				if($i==1)
				{	
					$index->SetStyle("dashed");
				}
				else
				{
					$index->SetStyle("solid");
				}

				$index->mark->SetType($markers[$k]);
				$index->mark->SetColor('black');
				$index->mark->SetFillColor($colors[$j]);
				$index->mark->SetSize(10);
				$index->value->SetAlign('center');
				
				$graphCosts->Add($index);

				$legendName = "$billtypes_rev[$j] $paytypes_rev[$k] ($persontype_rev[$i])";
				$index->SetLegend($legendName);
				$index->mark->SetColor('black');
				$index->SetColor($colors[$j]);
			}
		}
	}
}



//$graphCosts->xaxis->scale->SetTimeAlign(MONTHADJ_1);
//$graphCosts->legend->Pos(0.1,0.7);
$graphCosts->legend->SetColumns(8);

//$graphCosts->Stroke();

$graphCosts->legend->SetLineWeight(6);


$mgraph = new MGraph(1000,1500);
$mgraph->SetMargin(2,2,2,2);
$mgraph->SetFrame(true,'darkgray',2);
$mgraph->Add($graph);
$mgraph->Add($graphCosts,0,600);
$mgraph->Stroke();



?>
