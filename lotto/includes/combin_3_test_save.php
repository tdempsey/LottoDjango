<?php
function combin3saveFL($draw) 
{	
	global $game;

	require ("includes/mysqli.php");

	$num_rows_total = 0;

	array_unshift ($draw, 0);

	// count 3
	for ($c = 1; $c <= 20; $c++)
	{
		switch ($c) { 
		   case 1: 
			   $d1 = $draw[1];
			   $d2 = $draw[2];
			   $d3 = $draw[3];
			   break; 
		   case 2: 
			   $d1 = $draw[1];
			   $d2 = $draw[2];
			   $d3 = $draw[4];
			   break; 
		   case 3: 
			   $d1 = $draw[1];
			   $d2 = $draw[2];
			   $d3 = $draw[5];
			   break; 
		   case 4: 
			   $d1 = $draw[1];
			   $d2 = $draw[2];
			   $d3 = $draw[6];
			   break;
		   case 5: 
			   $d1 = $draw[1];
			   $d2 = $draw[3];
			   $d3 = $draw[5];
			   break;
		   case 6: 
			   $d1 = $draw[1];
			   $d2 = $draw[3];
			   $d3 = $draw[6];
			   break;
		   case 7: 
			   $d1 = $draw[1];
			   $d2 = $draw[4];
			   $d3 = $draw[5];
			   break; 
		   case 8: 
			   $d1 = $draw[1];
			   $d2 = $draw[4];
			   $d3 = $draw[6];
			   break; 
		   case 9: 
			   $d1 = $draw[1];
			   $d2 = $draw[5];
			   $d3 = $draw[6];
			   break; 
		   case 10: 
			   $d1 = $draw[2];
			   $d2 = $draw[3];
			   $d3 = $draw[4];
			   break;
		   case 11: 
			   $d1 = $draw[2];
			   $d2 = $draw[3];
			   $d3 = $draw[5];
			   break;
		   case 12: 
			   $d1 = $draw[2];
			   $d2 = $draw[3];
			   $d3 = $draw[6];
			   break;
		   case 13: 
			   $d1 = $draw[2];
			   $d2 = $draw[4];
			   $d3 = $draw[5];
			   break;
		   case 14: 
			   $d1 = $draw[2];
			   $d2 = $draw[4];
			   $d3 = $draw[6];
			   break;
		   case 15: 
			   $d1 = $draw[2];
			   $d2 = $draw[5];
			   $d3 = $draw[6];
			   break;
		   case 16: 
			   $d1 = $draw[3];
			   $d2 = $draw[4];
			   $d3 = $draw[5];
			   break;
		   case 17: 
			   $d1 = $draw[3];
			   $d2 = $draw[4];
			   $d3 = $draw[6];
			   break;
		   case 18: 
			   $d1 = $draw[3];
			   $d2 = $draw[5];
			   $d3 = $draw[6];
			   break;
		   case 19: 
			   $d1 = $draw[4];
			   $d2 = $draw[5];
			   $d3 = $draw[6];
			   break;
		   case 20: 
			   $d1 = $draw[1];
			   $d2 = $draw[3];
			   $d3 = $draw[4];
			   break;
		} 

		$query3 = "SELECT  * FROM fl_3_53_save ";
		$query3 .= "WHERE d1 = $d1 ";
		$query3 .= "  AND d2 = $d2 ";
		$query3 .= "  AND d3 = $d3 ";

		//print "$query3<br>";

		$mysqli_result3 = mysqli_query($mysqli_link, $query3) or die (mysqli_error($mysqli_link));

		//$draw3 = mysqli_fetch_array($mysqli_result3);

		if ($num_rows = mysqli_num_rows($mysqli_result3))
		{
			$num_rows_total++;
		} else {
			//return 0;
		}
	}

	//print "combo save 3 = $num_rows_total<br>";

	return $num_rows_total;
}
?>