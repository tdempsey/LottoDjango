<?php

	$game = 1; // Georgia F5

	$k = 1;

	set_time_limit(0);

	// include to connect to database
		
	require ("includes/count_2_seq.php");
	require ("includes/count_3_seq.php");
	#require ("includes_fl/build_rank_table_fl.php");
	#require ("includes_fl/calculate_rank_fl.php");
	require ("includes_ga_f5/last_draws_ga_f5.php");
	require ("includes_ga_f5/combin.incl");
	
	/*
	require ($_SERVER['DOCUMENT_ROOT'].'/lotto/includes/mysqli.php');

	$mysqli_link = mysqli_connect('localhost', 'root', 'wef5esuv', 'ga_f5_lotto');

	if (!$mysqli_link) {
		die('Connect Error (' . mysqli_connect_errno() . ') '
				. mysqli_connect_error());
	}

	echo 'Success... ' . mysqli_get_host_info($mysqli_link) . "\n";

	#mysqli_close($mysqli_link);
	*/

	echo "1<br>";

	require ("includes/mysqli.php");

	echo "2<br>";

	//start HTML page
	print("<HTML>\n");
	print("<HEAD>\n");
	print("<TITLE>Delete Dup - Combo 5/42</TITLE>\n");
	print("</HEAD>\n");
	
	print("<BODY bgcolor=\"#FFFFFF\" text=\"#000000\">\n");

	$curr_date = date('Y-m-d');

		$combo_table = "combo_5_42";

		### check for existing table row and skip
		$query6 = "SELECT `b1`,count(b1),`b2`,count(b2),`b3`,count(b3),`b4`,count(b4),`b5`,count(b5) FROM `combo_5_42` GROUP BY `b1`,`b2`,`b3`,`b4`,`b5` HAVING (count(b1) > 1) AND (count(b2) > 1) AND (count(b3) > 1) AND (count(b4) > 1) AND (count(b5) > 1)  ";
		
		echo "$query6<br>";

		$mysqli_result6 = mysqli_query($mysqli_link, $query6) or die (mysqli_error($mysqli_link));

		$num_rows = mysqli_num_rows($mysqli_result6);

		echo "<b>2 num_rows = $num_rows</b><br>";

		while ($row6 = mysqli_fetch_array($mysqli_result6))
		{		
			echo "dup found $row6[b1] - $row6[b2] - $row6[b3] - $row6[b4] - $row6[b5]<br>";

			$query7 = "SELECT * FROM combo_5_42 ";
			$query7 .= "WHERE b1 = '$row6[b1]' ";
			$query7 .= "AND   b2 = '$row6[b2]' ";
			$query7 .= "AND   b3 = '$row6[b3]' ";
			$query7 .= "AND   b4 = '$row6[b4]' ";
			$query7 .= "AND   b5 = '$row6[b5]' ";
			$query7 .= "ORDER BY id DESC ";

			#echo "$query7<br>";

			$mysqli_result7 = mysqli_query($mysqli_link, $query7) or die (mysqli_error($mysqli_link));

			$row7 = mysqli_fetch_array($mysqli_result7);

			$query9 = "DELETE From combo_5_42 ";
			$query9 .= "WHERE id = $row7[id] ";

			#echo "$query9<br>";

			$mysqli_result9 = mysqli_query($mysqli_link, $query9) or die (mysqli_error($mysqli_link));

			echo "id $row7[id] deleted - $row7[1] - $row7[2] - $row7[3] - $row7[4] - $row7[5]<br>";	

			#die();
		}

?>