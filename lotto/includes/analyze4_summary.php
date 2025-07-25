<?php
	function lot_analyze4_summary ($limit)
	{ 
		global $debug, $game, $game_name, $balls, $balls_drawn, $mega_balls, $draw_table_name, $draw_prefix, $game_includes, $hml, $range_low, $range_high, $eo50_sum, $eo50_even, $eo50_odd, $eo50_d2_1, $eo50_d2_2, $combin, $dateDiff;
	
		require ("includes/mysqli.php");
		#require ('includes/db.class.php');

		require ("$game_includes/config.incl");

		##echo "### 3 ###<br>";

		if (1)
		{
			#require ("includes_ga_f5/display4nav.incl");

			##############################################################################
			# create draw count table
			#
			#echo "draw_count_table_4.incl<br>";
			# all
			#$table_temp_summary = $draw_prefix . "temp2a_4_analyze_summary_" . $limit; 
			$table_temp_summary = $draw_prefix . "temp2a_4_analyze_summary"; 


			$query9 = "DROP TABLE IF EXISTS $table_temp_summary";

			#echo "$query9<br>";

			$mysqli_result = mysqli_query($mysqli_link, $query9) or die (mysqli_error($mysqli_link));

			#$table_temp = $draw_prefix . "temp_" . $limit;
			$query9 = "CREATE TABLE $table_temp_summary ( ";
			$query9 .= "id int(5) unsigned NOT NULL auto_increment, ";
			$query9 .= "num tinyint(3) unsigned NOT NULL, ";
			$query9 .= "even tinyint(3) unsigned NOT NULL, ";
			$query9 .= "odd tinyint(3) unsigned NOT NULL, ";
			$query9 .= "combin tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "day1 tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "week1 tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "week2 tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "month1 tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "month3 tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "month6 tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "year1 tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "year2 tinyint(3) unsigned NOT NULL default '0', ";
			$query9 .= "year3 int(5) unsigned NOT NULL default '0', ";
			$query9 .= "year4 int(5) unsigned NOT NULL default '0', ";
			$query9 .= "year5 int(5) unsigned NOT NULL default '0', ";
			$query9 .= "year6 int(5) unsigned NOT NULL default '0', ";
			$query9 .= "year7 int(5) unsigned NOT NULL default '0', ";
			$query9 .= "year8 int(5) unsigned NOT NULL default '0', ";
			$query9 .= "year9 int(5) unsigned NOT NULL default '0', ";
			$query9 .= "year10 int(5) unsigned NOT NULL default '0', ";
			$query9 .= "count int(5) unsigned NOT NULL, ";
			$query9 .= "percent_m1 float (4,1) unsigned NOT NULL default '0', ";
			$query9 .= "percent_y1 float (4,1) unsigned NOT NULL default '0', ";
			$query9 .= "percent_wa float (4,1) unsigned NOT NULL default '0', ";
			$query9 .= "PRIMARY KEY (id) ";
			$query9 .= ") ";

			#echo "$query9<p>";

			$mysqli_result9 = mysqli_query($mysqli_link, $query9) or die (mysqli_error($mysqli_link));
			#################################################################################################
			
			for ($combin = 1; $combin <= 5; $combin++)
			{
				#$table_temp = $draw_prefix . "sum_count_4_" . $combin . "_" . $limit; 
				$table_temp = $draw_prefix . "sum_count_sum4_" . $combin; 
				
				$query_combin = "SELECT * FROM $table_temp ";
				$query_combin .= "ORDER BY numx ASC ";

				#echo "$query_combin<P>";

				$mysqli_result_combin = mysqli_query($mysqli_link, $query_combin) or die (mysqli_error($mysqli_link));

				// get each row
				while($row_combin = mysqli_fetch_array($mysqli_result_combin))
				{
					$query9 = "INSERT INTO $table_temp_summary ";
					$query9 .= "VALUES ('0', ";
					$query9 .= "'$row_combin[1]', ";
					$query9 .= "'$row_combin[2]', ";
					$query9 .= "'$row_combin[3]', ";
					$query9 .= "'$combin', ";
					for ($d = 4; $d <= 22; $d++)
					{
						$query9 .= "'$row_combin[$d]', ";
					} 
					$query9 .= "'$row_combin[23]') ";

					#echo "$query9<p>";
					
					$mysqli_result9 = mysqli_query($mysqli_link, $query9) or die (mysqli_error($mysqli_link));
				}

			}
			
			print("<h2>Sum Table Sum - Summary - Numbers Sorted By percent_wa</h2>\n");
			print("<P>");
			#echo "table_temp = $table_temp<p>";
			print("<TABLE BORDER=\"1\">\n");

			//create header row
			print("<TR><B>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Sum</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Even</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Odd</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Combin</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Last</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Week1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Week2</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month3</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month6</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year2</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year3</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year4</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year5</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year6</center></TD>\n");
			#print("<TD BGCOLOR=\"#CCCCCC\"><center>1510</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year7</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year8</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year9</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year10</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Total</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>WA</center></TD>\n");
			print("</B></TR>\n");

			$query_combin = "SELECT * FROM $table_temp_summary ";
			$query_combin .= "WHERE percent_wa >= 0.40 ";
			$query_combin .= "ORDER BY percent_wa DESC, month1 DESC, week2 DESC, week1 DESC ";

			#echo "$query_combin<P>";

			$mysqli_result_combin = mysqli_query($mysqli_link, $query_combin) or die (mysqli_error($mysqli_link));

			$k = 0;

			// get each row
			while($row_combin = mysqli_fetch_array($mysqli_result_combin))
			{
				$x = $row_combin[1];	#date
				print("<TR>\n");

				print("<TD align=center>$x</TD>\n");
				print("<TD align=center>$row_combin[2]</TD>\n");	#even
				print("<TD align=center>$row_combin[3]</TD>\n");	#odd
				print("<TD align=center><strong>$row_combin[4]</strong></TD>\n");	#combin
				print("<TD align=center>$row_combin[5]</TD>\n");	#last
				for ($d = 6; $d <= 17; $d++)
				{
					if ($row_combin[$d] > 39)
					{
						print("<TD bgcolor=\"#FF0033\" align=center>{$row_combin[$d]}</TD>\n");
					} elseif ($row_combin[$d] > 29) {
						print("<TD bgcolor=\"#FF9900\" align=center>{$row_combin[$d]}</TD>\n");
					} elseif ($row_combin[$d] > 20) {
						print("<TD bgcolor=\"#FF9900\" align=center>{$row_combin[$d]}</TD>\n");
					} elseif ($row_combin[$d] >= 6) {
						print("<TD bgcolor=\"#66CC00\" align=center>{$row_combin[$d]}</TD>\n");
					} elseif ($row_combin[$d] >= 2) {
						print("<TD bgcolor=\"#87CEFF\" align=center>{$row_combin[$d]}</TD>\n");
					} else {
						print("<TD align=center>{$row_combin[$d]}</TD>\n");
					}
				} 

				print("<TD align=center>&nbsp;</TD>\n");
				print("<TD align=center>&nbsp;</TD>\n");
				print("<TD align=center>&nbsp;</TD>\n");

				#if ($row[count] > 400)
				if ($row_combin[19] > 39)
				{
					print("<TD bgcolor=\"#FF0000\" align=center><font color=\"#ffffff\"><b>$row_combin[19]</b></font></TD>\n");
				} else {
					print("<TD align=center>$row_combin[19]</TD>\n");
				}

				if ($row_combin[24] >= 2.0)
				{
					print("<TD align=center><font size=\"-1\"><b>$row_combin[24]</b></font></TD>\n");
				} else {
					print("<TD align=center><font size=\"-1\">$row_combin[24]</font></TD>\n");
				}

				print("</TR>\n");

				$k++;

				if ($k > 15)
				{
					print("<TR><B>\n");
					print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Sum</TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Even</TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Odd</TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Combin</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Last</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Week1</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Week2</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Month1</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Month3</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Month6</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year1</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year2</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year3</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year4</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year5</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year6</center></TD>\n");
					#print("<TD BGCOLOR=\"#CCCCCC\"><center>1510</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year7</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year8</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year9</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year10</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Total</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>WA</center></TD>\n");
					print("</B></TR>\n");

					$k = 0;
				}
			}

			//create header row
			print("<TR><B>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Sum</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Even</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Odd</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Combin</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Last</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Week1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Week2</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month3</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month6</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year2</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year3</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year4</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year5</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year6</center></TD>\n");
			#print("<TD BGCOLOR=\"#CCCCCC\"><center>1510</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year7</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year8</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year9</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year10</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Total</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>WA</center></TD>\n");
			print("</B></TR>\n");
			print "</table>";

			print("<P>");

			print("<h2>Sum Table Sum - Summary - Numbers Sorted By month6</h2>\n");
			print("<P>");
			#echo "table_temp = $table_temp<p>";
			print("<TABLE BORDER=\"1\">\n");

			//create header row
			print("<TR><B>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Sum</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Even</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Odd</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Combin</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Last</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Week1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Week2</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month3</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month6</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year2</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year3</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year4</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year5</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year6</center></TD>\n");
			#print("<TD BGCOLOR=\"#CCCCCC\"><center>1510</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year7</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year8</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year9</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year10</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Total</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>WA</center></TD>\n");
			print("</B></TR>\n");

			$query_combin = "SELECT * FROM $table_temp_summary ";
			$query_combin .= "WHERE percent_wa >= 0.40 ";
			$query_combin .= "ORDER BY month6 DESC, month3 DESC, month1 DESC ";

			#echo "$query_combin<P>";

			$mysqli_result_combin = mysqli_query($mysqli_link, $query_combin) or die (mysqli_error($mysqli_link));

			$k = 0;

			// get each row
			while($row_combin = mysqli_fetch_array($mysqli_result_combin))
			{
				$x = $row_combin[1];	#date
				print("<TR>\n");

				print("<TD align=center>$x</TD>\n");
				print("<TD align=center>$row_combin[2]</TD>\n");	#even
				print("<TD align=center>$row_combin[3]</TD>\n");	#odd
				print("<TD align=center><strong>$row_combin[4]</strong></TD>\n");	#combin
				print("<TD align=center>$row_combin[5]</TD>\n");	#last
				for ($d = 6; $d <= 17; $d++)
				{
					if ($row_combin[$d] > 39)
					{
						print("<TD bgcolor=\"#FF0033\" align=center>{$row_combin[$d]}</TD>\n");
					} elseif ($row_combin[$d] > 29) {
						print("<TD bgcolor=\"#FF9900\" align=center>{$row_combin[$d]}</TD>\n");
					} elseif ($row_combin[$d] > 20) {
						print("<TD bgcolor=\"#FF9900\" align=center>{$row_combin[$d]}</TD>\n");
					} elseif ($row_combin[$d] >= 6) {
						print("<TD bgcolor=\"#66CC00\" align=center>{$row_combin[$d]}</TD>\n");
					} elseif ($row_combin[$d] >= 2) {
						print("<TD bgcolor=\"#87CEFF\" align=center>{$row_combin[$d]}</TD>\n");
					} else {
						print("<TD align=center>{$row_combin[$d]}</TD>\n");
					}
				} 

				print("<TD align=center>&nbsp;</TD>\n");
				print("<TD align=center>&nbsp;</TD>\n");
				print("<TD align=center>&nbsp;</TD>\n");

				#if ($row[count] > 400)
				if ($row_combin[19] > 39)
				{
					print("<TD bgcolor=\"#FF0000\" align=center><font color=\"#ffffff\"><b>$row_combin[19]</b></font></TD>\n");
				} else {
					print("<TD align=center>$row_combin[19]</TD>\n");
				}

				if ($row_combin[24] >= 2.0)
				{
					print("<TD align=center><font size=\"-1\"><b>$row_combin[24]</b></font></TD>\n");
				} else {
					print("<TD align=center><font size=\"-1\">$row_combin[24]</font></TD>\n");
				}

				print("</TR>\n");

				$k++;

				if ($k > 15)
				{
					print("<TR><B>\n");
					print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Sum</TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Even</TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Odd</TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Combin</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Last</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Week1</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Week2</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Month1</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Month3</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Month6</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year1</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year2</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year3</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year4</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year5</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year6</center></TD>\n");
					#print("<TD BGCOLOR=\"#CCCCCC\"><center>1510</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year7</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year8</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year9</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Year10</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>Total</center></TD>\n");
					print("<TD BGCOLOR=\"#CCCCCC\"><center>WA</center></TD>\n");
					print("</B></TR>\n");

					$k = 0;
				}
			}

			//create header row
			print("<TR><B>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Sum</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Even</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\" align=\"center\">Odd</TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Combin</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Last</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Week1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Week2</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month3</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Month6</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year1</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year2</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year3</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year4</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year5</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year6</center></TD>\n");
			#print("<TD BGCOLOR=\"#CCCCCC\"><center>1510</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year7</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year8</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year9</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Year10</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>Total</center></TD>\n");
			print("<TD BGCOLOR=\"#CCCCCC\"><center>WA</center></TD>\n");
			print("</B></TR>\n");
			print "</table>";

			require ("includes_ga_f5/display4nav.incl");
		}
	
	}
?>