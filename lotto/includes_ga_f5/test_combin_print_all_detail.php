<?php
	
	// ----------------------------------------------------------------------------------
	function test_combin_print_all($limit) #200123
	{
		require ("includes/mysqli.php"); 

		global $debug,$draw_prefix, $hml, $range_low, $range_high;

		print("<h3>Combin Report Detail - All - Limit $limit</h3>\n");

		$query = "SELECT * FROM ga_f5_draws ";
		if ($hml)
		{
			$query .= "WHERE sum >= $range_low  ";
			$query .= "AND   sum <= $range_high  ";
		}
		$query .= "ORDER BY date DESC ";
		$query .= "LIMIT $limit ";

		#echo "$query</br>";

		$mysqli_result = mysqli_query($mysqli_link, $query) or die (mysqli_error($mysqli_link));

		print("<TABLE BORDER=\"1\">\n");

		//create header row
		print("<TR><B>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>Date</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\"><center>2</center></TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">&nbsp;3&nbsp;</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">&nbsp;4&nbsp;</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">&nbsp;5&nbsp;</TD>\n");
		print("</B></TR>\n");

		$total2_failed = 0;
		$total3_failed = 0;
		$total4_failed = 0;
		$total5_failed = 0;

		$last_date = '1962-08-17';

		while($row_draw = mysqli_fetch_array($mysqli_result))
		{
			print("<TR>\n");  
			print("<TD>$row_draw[date]</TD>\n");

			# update combo table
			$query3 = "SELECT * FROM $draw_prefix";
			$query3 .= "combo_table_all ";
			$query3 .= "WHERE date = '$row_draw[date]' ";

			#echo "$query3<br>";

			$mysqli_result3 = mysqli_query($mysqli_link, $query3) or die (mysqli_error($mysqli_link));

			$num_rows_combo = mysqli_num_rows($mysqli_result3); 

			#echo "num_rows_combo = $num_rows_combo<br>";

			if ($num_rows_combo)
			{
				$row_combo = mysqli_fetch_array($mysqli_result3); 
				$total2 = $row_combo[comb2];
				$total3 = $row_combo[comb3];
				$total4 = $row_combo[comb4];
				$total5 = $row_combo[comb5];
			} else {
				$total2 = 0;
				$total3 = 0;
				$total4 = 0;
				$total5 = 0;

				// count 2
				for ($c = 1; $c <= 10; $c++)
				{
					switch ($c) { 
					   case 1: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[2];
						   break; 
					   case 2: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[3];
						   break; 
					   case 3: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[4];
						   break; 
					   case 4: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[5];
						   break;
					   case 5: 
						   $d1 = $row_draw[2];
						   $d2 = $row_draw[3];
						   break;
					   case 6: 
						   $d1 = $row_draw[2];
						   $d2 = $row_draw[4];
						   break; 
					   case 7: 
						   $d1 = $row_draw[2];
						   $d2 = $row_draw[5];
						   break; 
					   case 8: 
						   $d1 = $row_draw[3];
						   $d2 = $row_draw[4];
						   break;
					   case 9: 
						   $d1 = $row_draw[3];
						   $d2 = $row_draw[5];
						   break;
					   case 10: 
						   $d1 = $row_draw[4];
						   $d2 = $row_draw[5];
						   break;
					} 

					$query2 = "SELECT DISTINCT * FROM ga_f5_2_42 ";
					$query2 .= "WHERE d1 = $d1 ";
					$query2 .= "  AND d2 = $d2 ";
					$query2 .= "  AND combo = $c "; #200103 ???
					$query2 .= "  AND hml = 0 ";
					$query2 .= "  AND date < '$row_draw[date]' ";

					#echo "$query2<br>";

					$mysqli_result2 = mysqli_query($mysqli_link, $query2) or die (mysqli_error($mysqli_link));
					
					if ($num_rows = mysqli_num_rows($mysqli_result2))
					{
						//$total2 += $num_rows;
						$total2++;
					}

					#echo "num_rows = $num_rows<br>";
				}

				// count 3
				for ($c = 1; $c <= 10; $c++)
				{
					switch ($c) { 
					   case 1: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[2];
						   $d3 = $row_draw[3];
						   break; 
					   case 2: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[2];
						   $d3 = $row_draw[4];
						   break; 
					   case 3: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[2];
						   $d3 = $row_draw[5];
						   break; 
					   case 4: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[3];
						   $d3 = $row_draw[4];
						   break;
					   case 5: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[3];
						   $d3 = $row_draw[5];
						   break;
					   case 6: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[4];
						   $d3 = $row_draw[5];
						   break; 
					   case 7: 
						   $d1 = $row_draw[2];
						   $d2 = $row_draw[3];
						   $d3 = $row_draw[4];
						   break;
					   case 8: 
						   $d1 = $row_draw[2];
						   $d2 = $row_draw[3];
						   $d3 = $row_draw[5];
						   break;
					   case 9: 
						   $d1 = $row_draw[2];
						   $d2 = $row_draw[4];
						   $d3 = $row_draw[5];
						   break;
					   case 10: 
						   $d1 = $row_draw[3];
						   $d2 = $row_draw[4];
						   $d3 = $row_draw[5];
						   break;
					} 

					$query3 = "SELECT DISTINCT * FROM ga_f5_3_42 ";
					$query3 .= "WHERE d1 = $d1 ";
					$query3 .= "  AND d2 = $d2 ";
					$query3 .= "  AND d3 = $d3 ";
					$query3 .= "  AND combo = $c "; #200103 ???
					$query3 .= "  AND hml = 0 ";
					$query3 .= "  AND date < '$row_draw[date]' ";

					#echo "$query3<br>";

					$mysqli_result3 = mysqli_query($mysqli_link, $query3) or die (mysqli_error($mysqli_link));
					
					if ($num_rows = mysqli_num_rows($mysqli_result3))
					{
						//$total3 += $num_rows;
						$total3++;
					}
				}

				// count 4
				for ($c = 1; $c <= 5; $c++)
				{
					switch ($c) { 
					   case 1: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[2];
						   $d3 = $row_draw[3];
						   $d4 = $row_draw[4];
						   break; 
					   case 2: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[2];
						   $d3 = $row_draw[3];
						   $d4 = $row_draw[5];
						   break; 
					   case 3: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[2];
						   $d3 = $row_draw[4];
						   $d4 = $row_draw[5];
						   break;
					   case 4: 
						   $d1 = $row_draw[1];
						   $d2 = $row_draw[3];
						   $d3 = $row_draw[4];
						   $d4 = $row_draw[5];
						   break; 
					   case 5: 
						   $d1 = $row_draw[2];
						   $d2 = $row_draw[3];
						   $d3 = $row_draw[4];
						   $d4 = $row_draw[5];
						   break;
					} 

					$query4 = "SELECT DISTINCT date, d1, d2, d3, d4 FROM ga_f5_4_42 ";
					$query4 .= "WHERE d1 = $d1 ";
					$query4 .= "  AND d2 = $d2 ";
					$query4 .= "  AND d3 = $d3 ";
					$query4 .= "  AND d4 = $d4 ";
					$query4 .= "  AND combo = $c "; #200103 ???
					$query4 .= "  AND hml = 0 ";
					$query4 .= "  AND date < '$row_draw[date]' ";

					#echo "$query4<br>";

					$mysqli_result4 = mysqli_query($mysqli_link, $query4) or die (mysqli_error($mysqli_link));
					
					if ($num_rows = mysqli_num_rows($mysqli_result4))
					{
						//$total4 += $num_rows;
						$total4++;
					}
				}

				// count 5
				$query6 = "SELECT DISTINCT * FROM ga_f5_draws ";
				$query6 .= "WHERE b1 = $row_draw[b1] ";
				$query6 .= "  AND b2 = $row_draw[b2] ";
				$query6 .= "  AND b3 = $row_draw[b3] ";
				$query6 .= "  AND b4 = $row_draw[b4] ";
				$query6 .= "  AND b5 = $row_draw[b5] ";
				$query6 .= "  AND date < '$row_draw[date]' ";

				#echo "$query6<br>";

				$mysqli_result6 = mysqli_query($mysqli_link, $query6) or die (mysqli_error($mysqli_link));
				
				if ($num_rows = mysqli_num_rows($mysqli_result6))
				{
					//$total5 += $num_rows;
					$total5++;
				}

				# update combo table	
				$query3 = "SELECT * FROM $draw_prefix";
				$query3 .= "combo_table_all ";
				$query3 .= "WHERE date = '$row_draw[date]' ";

				#echo "$query3<br>";

				$mysqli_result3 = mysqli_query($mysqli_link, $query3) or die (mysqli_error($mysqli_link));

				$num_rows_combo = mysqli_num_rows($mysqli_result3); 

				#combo_table_update_all($row_draw[date],$total2,$total3,$total4,$total5);

				$query_combo = "INSERT INTO $draw_prefix";
				$query_combo .= "combo_table_all ";
				$query_combo .= "VALUES ('$row_draw[date]', ";
				$query_combo .= "'$total2', ";
				$query_combo .= "'$total3', ";
				$query_combo .= "'$total4', ";
				$query_combo .= "'$total5')";

				#echo "$query_combo<br>";

				$mysqli_result_combo = mysqli_query($mysqli_link, $query_combo) or die (mysqli_error($mysqli_link));
			}

			if ($total2 == 10)
			{
				print("<TD align=center>$total2</TD>\n");
			} else {
				print("<TD align=center><font color=\"#ff0000\"><b>$total2</b></font></TD>\n");
				$total2_failed++;
			}

			if ($total3 == 10)
			{
				print("<TD align=center>$total3</TD>\n");
			} else {
				print("<TD align=center><font color=\"#ff0000\"><b>$total3</b></font></TD>\n");
				$total3_failed++;
			}

			if ($total4 <= 2)
			{
				print("<TD align=center>$total4</TD>\n");
			} else {
				print("<TD align=center><font color=\"#ff0000\"><b>$total4</b></font></TD>\n");
				$total4_failed++;
			}

			if ($total5 == 0)
			{
				print("<TD align=center>$total5</TD>\n");
			} else {
				print("<TD align=center><font color=\"#ff0000\"><b>$total5</b></font></TD>\n");
				$total5_failed++;
			}

			print("</TR>\n");

			$last_date = $row_draw[date];
		}

		print("<TR><B>\n");
		print("<TD align=center align=center>&nbsp;</TD>\n");
		print("<TD align=center><font color=\"#ff0000\">$total2_failed</font></TD>\n");
		print("<TD align=center><font color=\"#ff0000\">$total3_failed</font></TD>\n");
		print("<TD align=center><font color=\"#ff0000\">$total4_failed</font></TD>\n");
		print("<TD align=center><font color=\"#ff0000\">$total5_failed</font></TD>\n");
		print("</B></TR>\n");

		print("</TABLE>\n");

		return ($last_date);
	}

?>