<?php
	$game = 6; // Florida Lotto

	$num = 1;
	
	require ("includes/games_switch.incl");

	// include to connect to database
	require ("includes/mysqli.php");
	require ("includes/count_2_seq.php");
	require ("includes/count_3_seq.php");
	require ("includes_fl/look_up_rank_fl.php");
	require ("$game_includes/combin.incl");

	//start HTML page
	print("<HTML>\n");
	print("<HEAD>\n");
	print("<TITLE>Update fl_draw_pair_sum_$num</TITLE>\n");
	print("</HEAD>\n");
	
	print("<BODY bgcolor=\"#FFFFFF\" text=\"#000000\">\n");

	print "<center><h1>Update fl_draw_pair_sum</h1></center>";

	$query3 = "DROP TABLE IF EXISTS fl_draw_pair_sum_";
	$query3 .= "$num ";
	
	$mysqli_result3 = mysqli_query($mysqli_link, $query3) or die (mysqli_error($mysqli_link));

	$query4 = "CREATE TABLE fl_draw_pair_sum_";
	$query4 .= "$num ( ";
	$query4 .= "id int(10) unsigned NOT NULL auto_increment, ";
	$query4 .= "sum tinyint(3) unsigned NOT NULL default '0', ";
	$query4 .= "wa float(4,2) unsigned NOT NULL default '0', ";
	$query4 .= "PRIMARY KEY  (id) ";
	$query4 .= ") ENGINE = InnoDB ";

	$mysqli_result4 = mysqli_query($mysqli_link, $query4) or die (mysqli_error($mysqli_link));
	
	$query = "SELECT * FROM $draw_table_name ";
	$query .= "WHERE b1 = $num ";
	$query .= "ORDER BY date DESC ";

	print("$query<p>");

	$mysqli_result = mysqli_query($mysqli_link, $query) or die (mysqli_error($mysqli_link));

	while($row = mysqli_fetch_array($mysqli_result))
	{
		$pair_sum = pair_sum_count_6 ($row);

		$query9 = "UPDATE fl_draws ";
		$query9 .= "SET pair_sum = $pair_sum ";
		$query9 .= "WHERE date = '$row[date]'  ";

		#print "<br>query9 = $query9<p>";

		$mysqli_result9 = mysqli_query($mysqli_link, $query9) or die (mysqli_error($mysqli_link));

		for ($c = 1; $c <= 6; $c++)
		{
			switch ($c) { 
			   case 1: 
				   $d1 = $row[b1];
				   $d2 = $row[b2];
				   $d3 = $row[b3];
				   $d4 = $row[b4];
				   $d5 = $row[b5];
				   break; 
			   case 2: 
				   $d1 = $row[b1];
				   $d2 = $row[b2];
				   $d3 = $row[b3];
				   $d4 = $row[b4];
				   $d5 = $row[b6];
				   break; 
			   case 3: 
				   $d1 = $row[b1];
				   $d2 = $row[b2];
				   $d3 = $row[b3];
				   $d4 = $row[b5];
				   $d5 = $row[b6];
				   break;
			   case 4: 
				   $d1 = $row[b1];
				   $d2 = $row[b2];
				   $d3 = $row[b4];
				   $d4 = $row[b5];
				   $d5 = $row[b6];
				   break; 
			   case 5: 
				   $d1 = $row[b1];
				   $d2 = $row[b3];
				   $d3 = $row[b4];
				   $d4 = $row[b5];
				   $d5 = $row[b6];
				   break;
			   case 6: 
				   $d1 = $row[b2];
				   $d2 = $row[b3];
				   $d3 = $row[b4];
				   $d4 = $row[b5];
				   $d5 = $row[b6];
				   break; 
			} 

			$temp_5 = array (0,$d1,$d2,$d3,$d4,$d5);

			$pair_sum = pair_sum_count_5 ($temp_5,$row[date]);

			$query5 = "UPDATE fl_draws ";
			$query5 .= "SET combin_5_";
			$query5 .= "$c";
			$query5 .= " = $pair_sum ";
			$query5 .= "WHERE date = '$row[date]'  ";	

			#print "query5 = $query5<br>";

			$mysqli_result5 = mysqli_query($mysqli_link, $query5) or die (mysqli_error($mysqli_link));
		}
	}

	/*print_pair_sum_grid_6(8);
	print_pair_sum_table_6(8);

	print_pair_sum_grid_6(52);
	print_pair_sum_table_6(52);*/
	
	print_pair_sum_grid_6(104,$num);
	print_pair_sum_table_6(104,$num);

	#print_pair_sum_grid_5(8);

	#print_pair_sum_table_5_single(8,26);
	#print_pair_sum_table_5_single(8,27);
	#print_pair_sum_table_5_single(8,28);
	#print_pair_sum_table_5_single(8,29);
	#print_pair_sum_table_5_single(8,30);
	#print_pair_sum_table_5_single(8,31);

	#print_pair_sum_grid_5(52);

	#print_pair_sum_table_5_single(52,26);
	#print_pair_sum_table_5_single(52,27);
	#print_pair_sum_table_5_single(52,28);
	#print_pair_sum_table_5_single(52,29);
	#print_pair_sum_table_5_single(52,30);
	#print_pair_sum_table_5_single(52,31);

	#print_pair_sum_grid_5(104);

	#print_pair_sum_table_5_single(104,26);
	#print_pair_sum_table_5_single(104,27);
	#print_pair_sum_table_5_single(104,28);
	#print_pair_sum_table_5_single(104,29);
	#print_pair_sum_table_5_single(104,30);
	#print_pair_sum_table_5_single(104,31);

	function pair_sum_count_5 ($draw_num,$date)
	{ 
		global $debug;
	
		require ("includes/mysqli.php");

		$pair_sum = 0;
					
		// pair count 
		for ($c = 1; $c <= 10; $c++)
		{
			switch ($c) { 
				case 1: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[2];
				   break; 
				case 2: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[3];
				   break; 
				case 3: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[4];
				   break; 
				case 4: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[5];
				   break;
				case 5: 
				   $d1 = $draw_num[2];
				   $d2 = $draw_num[3];
				   break; 
				case 6: 
				   $d1 = $draw_num[2];
				   $d2 = $draw_num[4];
				   break; 
				case 7: 
				   $d1 = $draw_num[2];
				   $d2 = $draw_num[5];
				   break;
				case 8: 
				   $d1 = $draw_num[3];
				   $d2 = $draw_num[4];
				   break;
				case 9: 
				   $d1 = $draw_num[3];
				   $d2 = $draw_num[5];
				   break;
				case 10: 
				   $d1 = $draw_num[3];
				   $d2 = $draw_num[5];
				   break;
			} 

			$query8 = "SELECT num1, num2, count FROM fl_temp_2_5000 ";
			$query8 .= "WHERE num1 = $d1 ";
			$query8 .= "  AND num2 = $d2 ";
			$query8 .= "  AND last_date < '$date' ";

			$mysqli_result8 = mysqli_query($mysqli_link, $query8) or die (mysqli_error($mysqli_link));

			$row8 = mysqli_fetch_array($mysqli_result8);

			$num_rows = mysqli_num_rows($mysqli_result8);
			
			$pair_sum+= $num_rows;
		} 

		return $pair_sum;
	}

	function pair_sum_count_6 ($draw_num)
	{ 
		global $debug;
	
		require ("includes/mysqli.php");

		$pair_sum = 0;
					
		// pair count 
		for ($c = 1; $c <= 15; $c++)
		{
			switch ($c) { 
				case 1: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[2];
				   break; 
				case 2: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[3];
				   break; 
				case 3: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[4];
				   break; 
				case 4: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[5];
				   break;
				case 5: 
				   $d1 = $draw_num[1];
				   $d2 = $draw_num[6];
				   break;
				case 6: 
				   $d1 = $draw_num[2];
				   $d2 = $draw_num[3];
				   break; 
				case 7: 
				   $d1 = $draw_num[2];
				   $d2 = $draw_num[4];
				   break; 
				case 8: 
				   $d1 = $draw_num[2];
				   $d2 = $draw_num[5];
				   break;
				case 9: 
				   $d1 = $draw_num[2];
				   $d2 = $draw_num[6];
				   break;
				case 10: 
				   $d1 = $draw_num[3];
				   $d2 = $draw_num[4];
				   break;
				case 11: 
				   $d1 = $draw_num[3];
				   $d2 = $draw_num[5];
				   break;
				case 12: 
				   $d1 = $draw_num[3];
				   $d2 = $draw_num[6];
				   break;
				case 13: 
				   $d1 = $draw_num[4];
				   $d2 = $draw_num[5];
				   break;
				case 14: 
				   $d1 = $draw_num[4];
				   $d2 = $draw_num[6];
				   break;
				case 15: 
				   $d1 = $draw_num[5];
				   $d2 = $draw_num[6];
				   break;
			} 

			$query8 = "SELECT num1, num2, count FROM fl_temp_2_5000 ";
			$query8 .= "WHERE num1 = $d1 ";
			$query8 .= "  AND num2 = $d2 ";
			$query8 .= "  AND last_date < '$draw_num[0]' ";

			$mysqli_result8 = mysqli_query($mysqli_link, $query8) or die (mysqli_error($mysqli_link));

			$row8 = mysqli_fetch_array($mysqli_result8);

			$num_rows = mysqli_num_rows($mysqli_result8);
			
			$pair_sum+= $num_rows;
		} 

		return $pair_sum;
	}

	// ----------------------------------------------------------------------------------
	function print_pair_sum_grid_5($limit)
	{
		global $draw_table_name, $balls, $balls_drawn, $draw_prefix; 

		require ("includes/mysqli.php");

		$sum_tot_1 =	array_fill (0, 29, 0);
		$sum_tot_2 =	array_fill (0, 29, 0);
		$sum_tot_4 =	array_fill (0, 29, 0);
		$sum_tot_8 =	array_fill (0, 29, 0);
		$sum_tot_24 =	array_fill (0, 29, 0);
		$sum_tot_48 =	array_fill (0, 29, 0);
		$sum_tot_52 =	array_fill (0, 29, 0);
		$sum_tot_104 =	array_fill (0, 29, 0);
		$sum_tot_208 =	array_fill (0, 29, 0);
		$sum_tot_312 =	array_fill (0, 29, 0);
		$sum_tot_1000 =	array_fill (0, 29, 0);
		$sum_tot_5000 =	array_fill (0, 29, 0);
	
		$query = "SELECT * FROM $draw_table_name ";
		$query .= "ORDER BY date DESC ";
		$query .= "LIMIT $limit ";
	
		$mysqli_result = mysqli_query($mysqli_link, $query) or die (mysqli_error($mysqli_link));

		$num_rows_all = mysqli_num_rows($mysqli_result);

		//start table
		print("<h3>Sum Rank</h3>\n");
		print "<h4>limit = $limit - Combo 5</h4>";

		print("<TABLE BORDER=\"1\">\n");
	
		//create header row
		print("<TR>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">SumX</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
		print("</TR>\n");

		$draw = 1;
	
		while($row = mysqli_fetch_array($mysqli_result))
		{
			for ($z = 26; $z <= 31; $z++)
			{
				$x = intval($row[$z]/10);

				if ($draw <= 1)
				{
					$sum_tot_1[$x]++;
					$sum_tot_2[$x]++;
					$sum_tot_4[$x]++;
					$sum_tot_8[$x]++;
					$sum_tot_24[$x]++;
					$sum_tot_52[$x]++;
					$sum_tot_104[$x]++;
					$sum_tot_208[$x]++;
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				}
				elseif ($draw <= 2)
				{
					$sum_tot_2[$x]++;
					$sum_tot_4[$x]++;
					$sum_tot_8[$x]++;
					$sum_tot_24[$x]++;
					$sum_tot_52[$x]++;
					$sum_tot_104[$x]++;
					$sum_tot_208[$x]++;
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				} elseif ($draw <= 4) {
					$sum_tot_4[$x]++;
					$sum_tot_8[$x]++;
					$sum_tot_24[$x]++;
					$sum_tot_52[$x]++;
					$sum_tot_104[$x]++;
					$sum_tot_208[$x]++;
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				} elseif ($draw <= 8) {
					$sum_tot_8[$x]++;
					$sum_tot_24[$x]++;
					$sum_tot_52[$x]++;
					$sum_tot_104[$x]++;
					$sum_tot_208[$x]++;
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				} elseif ($draw <= 24) {
					$sum_tot_24[$x]++;
					$sum_tot_52[$x]++;
					$sum_tot_104[$x]++;
					$sum_tot_208[$x]++;
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				} elseif ($draw <= 52) {
					$sum_tot_52[$x]++;
					$sum_tot_104[$x]++;
					$sum_tot_208[$x]++;
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				} elseif ($draw <= 104) {
					$sum_tot_104[$x]++;
					$sum_tot_208[$x]++;
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				} elseif ($draw <= 208) {
					$sum_tot_208[$x]++;
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				} elseif ($draw <= 312) {
					$sum_tot_312[$x]++;
					$sum_tot_5000[$x]++;
				} elseif ($draw <= 5000) {
					$sum_tot_5000[$x]++;
				}
			}

			$draw++;
		}

		for ($x = 1; $x <= 20; $x++)
		{
			print("<TR>\n");
			print("<TD><CENTER><b>$x</b></CENTER></TD>\n");
			if ($sum_tot_1[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><b>$sum_tot_1[$x]</b></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_1[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_2[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_2[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_2[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_4[$x] > 2) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_4[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_4[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_8[$x] > 3) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_8[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_8[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_24[$x] > 3) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_24[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_24[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_52[$x] > 3) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_52[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_52[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_104[$x] > 3) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_104[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_104[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_208[$x] > 4) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_208[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_208[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_312[$x] > 5) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_312[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_312[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_5000[$x] > 10) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_5000[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_5000[$x]</CENTER></TD>\n");
			}

			$sum_temp_4 = number_format(($sum_tot_4[$x]/30)*100,1);
			if ($sum_temp_4 >= 10.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_30 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_30 %</font></TD>\n");
			}

			$sum_temp_104 = number_format(($sum_tot_104[$x]/365)*100,1);
			if ($sum_temp_104 >= 10.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_104 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_104 %</font></TD>\n");
			}

			$sum_temp_5000 = number_format(($sum_tot_5000[$x]/$num_rows_all)*100,1);
			if ($sum_temp_5000 >= 10.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_5000 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_5000 %</font></TD>\n");
			}

			$weighted_average = (
				($sum_tot_2[$x]/10*100*0.05) +
				($sum_tot_4[$x]/30*100*0.20) +
				($sum_tot_24[$x]/100*100*0.25) +
				($sum_tot_104[$x]/365*100*0.20) +
				($sum_tot_208[$x]/500*100*0.10) +
				($sum_tot_312[$x]/1000*100*0.20) +
				($sum_tot_5000[$x]/$num_rows_all*100*0.20));

			$sum_temp_wa = number_format($weighted_average,1);
			if ($sum_temp_wa >= 10.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_wa %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_wa %</font></TD>\n");
			}

			print("</TR>\n");
		}

		//create header row
		print("<TR>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">SumX</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
		print("</TR>\n");

		print("</TABLE>\n");

		print "<h3>Table <font color=\"#ff0000\">{$draw_prefix}sum</font> Updated!</h3>";

	}

	// ----------------------------------------------------------------------------------
	function print_pair_sum_grid_6($limit,$num)
	{
		global $draw_table_name, $balls, $balls_drawn, $draw_prefix; 

		require ("includes/mysqli.php");

		$sum_tot_1 =	array_fill (0, 29, 0);
		$sum_tot_2 =	array_fill (0, 29, 0);
		$sum_tot_4 =	array_fill (0, 29, 0);
		$sum_tot_8 =	array_fill (0, 29, 0);
		$sum_tot_24 =	array_fill (0, 29, 0);
		$sum_tot_52 =	array_fill (0, 29, 0);
		$sum_tot_104 =	array_fill (0, 29, 0);
		$sum_tot_208 =	array_fill (0, 29, 0);
		$sum_tot_312 =	array_fill (0, 29, 0);
		$sum_tot_5000 =	array_fill (0, 29, 0);
	
		$query = "SELECT pair_sum FROM $draw_table_name ";
		$query .= "WHERE b1 = $num ";
		$query .= "ORDER BY date DESC ";
		$query .= "LIMIT $limit ";
	
		print "$query<p>";

		$mysqli_result = mysqli_query($mysqli_link, $query) or die (mysqli_error($mysqli_link));

		$num_rows_all = mysqli_num_rows($mysqli_result);

		//start table
		print("<h3>Sum Rank</h3>\n");
		print "<h4>limit = $limit - Combo 6</h4>";

		print("<TABLE BORDER=\"1\">\n");
	
		//create header row
		print("<TR>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">SumX</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
		print("</TR>\n");

		$draw = 1;
	
		while($row = mysqli_fetch_array($mysqli_result))
		{
			$x = intval($row[0]/10);
			if ($draw <= 1)
			{
				$sum_tot_1[$x]++;
				$sum_tot_2[$x]++;
				$sum_tot_4[$x]++;
				$sum_tot_8[$x]++;
				$sum_tot_24[$x]++;
				$sum_tot_52[$x]++;
				$sum_tot_104[$x]++;
				$sum_tot_208[$x]++;
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 2) {
				$sum_tot_2[$x]++;
				$sum_tot_4[$x]++;
				$sum_tot_8[$x]++;
				$sum_tot_24[$x]++;
				$sum_tot_52[$x]++;
				$sum_tot_104[$x]++;
				$sum_tot_208[$x]++;
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 4) {
				$sum_tot_4[$x]++;
				$sum_tot_8[$x]++;
				$sum_tot_24[$x]++;
				$sum_tot_52[$x]++;
				$sum_tot_104[$x]++;
				$sum_tot_208[$x]++;
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 8) {
				$sum_tot_8[$x]++;
				$sum_tot_24[$x]++;
				$sum_tot_52[$x]++;
				$sum_tot_104[$x]++;
				$sum_tot_208[$x]++;
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 24) {
				$sum_tot_24[$x]++;
				$sum_tot_52[$x]++;
				$sum_tot_104[$x]++;
				$sum_tot_208[$x]++;
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 52) {
				$sum_tot_52[$x]++;
				$sum_tot_104[$x]++;
				$sum_tot_208[$x]++;
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 104) {
				$sum_tot_104[$x]++;
				$sum_tot_208[$x]++;
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 208) {
				$sum_tot_208[$x]++;
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 312) {
				$sum_tot_312[$x]++;
				$sum_tot_5000[$x]++;
			} elseif ($draw <= 5000) {
				$sum_tot_5000[$x]++;
			}
			$draw++;
		}

		for ($x = 1; $x <= 20; $x++)
		{
			print("<TR>\n");
			print("<TD><CENTER><b>$x</b></CENTER></TD>\n");
			if ($sum_tot_1[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><b>$sum_tot_1[$x]</b></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_1[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_2[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_2[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_2[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_4[$x] > 2) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_4[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_4[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_8[$x] > 3) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_8[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_8[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_24[$x] > 3) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_24[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_24[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_52[$x] > 3) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_52[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_52[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_104[$x] > 3) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_104[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_104[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_208[$x] > 4) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_208[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_208[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_312[$x] > 5) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_312[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_312[$x]</CENTER></TD>\n");
			}
			if ($sum_tot_5000[$x] > 10) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_tot_5000[$x]</b></CENTER></TD>\n");
			} else {
				print("<TD><CENTER>$sum_tot_5000[$x]</CENTER></TD>\n");
			}

			$sum_temp_4 = number_format(($sum_tot_4[$x]/30)*100,1);
			if ($sum_temp_4 >= 10.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_4 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_4 %</font></TD>\n");
			}

			$sum_temp_104 = number_format(($sum_tot_104[$x]/365)*100,1);
			if ($sum_temp_104 >= 10.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_104 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_104 %</font></TD>\n");
			}

			$sum_temp_5000 = number_format(($sum_tot_5000[$x]/$num_rows_all)*100,1);
			if ($sum_temp_5000 >= 10.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_5000 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_5000 %</font></TD>\n");
			}

			$weighted_average = (
				($sum_tot_2[$x]/10*100*0.05) +
				($sum_tot_4[$x]/30*100*0.20) +
				($sum_tot_24[$x]/100*100*0.25) +
				($sum_tot_104[$x]/365*100*0.20) +
				($sum_tot_208[$x]/500*100*0.10) +
				($sum_tot_312[$x]/1000*100*0.20) +
				($sum_tot_5000[$x]/$num_rows_all*100*0.20));

			$sum_temp_wa = number_format($weighted_average,1);
			if ($sum_temp_wa >= 10.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_wa %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_wa %</font></TD>\n");
			}

			print("</TR>\n");
		}

		//create header row
		print("<TR>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">SumX</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
		print("</TR>\n");

		print("</TABLE>\n");

		print "<h3>Table <font color=\"#ff0000\">{$draw_prefix}sum</font> Updated!</h3>";

	}

	// ----------------------------------------------------------------------------------
	function print_pair_sum_table_5($limit)
	{
		global $debug, $draw_table_name, $draw_prefix, $balls, $balls_drawn, $game; 

		require ("includes/mysqli.php");

		for ($x = 0; $x < 264; $x++)
		{
			$sum_table[$x] = 0;
			$sum_table_date[$x] = "1962-08-17";
			$sum_table_date_prev[$x] = "1962-08-17";
			$sum_table_1[$x] = 0;
			$sum_table_2[$x] = 0;
			$sum_table_4[$x] = 0;
			$sum_table_8[$x] = 0;
			$sum_table_24[$x] = 0;
			$sum_table_52[$x] = 0;
			$sum_table_104[$x] = 0;
			$sum_table_208[$x] = 0;
			$sum_table_312[$x] = 0;
			$sum_table_5000[$x] = 0;
		}
	
		$query = "SELECT * FROM $draw_table_name ";
		$query .= "ORDER BY date DESC ";
		$query .= "LIMIT $limit ";

		print "$query<p>";
	
		$mysqli_result = mysqli_query($mysqli_link, $query) or die (mysqli_error($mysqli_link));

		$num_rows_all = mysqli_num_rows($mysqli_result); 

		//start table
		print("<h3>Sum Table - $limit - Combo 5</h3>\n");
		print "<h4>limit = $limit</h4>";

		print("<TABLE BORDER=\"1\">\n");
	
		//create header row
		print("<TR>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Sum</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Count</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>Prev</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>1000</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa_prev</TD>\n");
		print("</TR>\n");

		$z = 0;
	
		while($row = mysqli_fetch_array($mysqli_result))
		{
			for ($z = 26; $z <= 31; $z++)
			{
				$sum_table[$row[$z]]++;
	
				if ($row[date] > $sum_table_date[$z]) {
					$sum_table_date_prev[$z] = $sum_table_date[$z];
					$sum_table_date[$z] = $row[date];
				} else if ($sum_table_date_prev[$row[$z]] == '1962-08-17') {
					$sum_table_date_prev[$row[$z]] = $row[date];
				}
			}

			for ($z = 26; $z <= 31; $z++)
			{
				if ($z < 1) {
					$sum_table_1[$row[$z]]++;
					$sum_table_2[$row[$z]]++;
					$sum_table_4[$row[$z]]++;
					$sum_table_8[$row[$z]]++;
					$sum_table_24[$row[$z]]++;
					$sum_table_52[$row[$z]]++;
					$sum_table_104[$row[$z]]++;
					$sum_table_208[$row[$z]]++;
					$sum_table_5000[$row[$z]]++;
				} elseif ($z < 2) {
					$sum_table_2[$row[$z]]++;
					$sum_table_4[$row[$z]]++;
					$sum_table_8[$row[$z]]++;
					$sum_table_24[$row[$z]]++;
					$sum_table_52[$row[$z]]++;
					$sum_table_104[$row[$z]]++;
					$sum_table_208[$row[$z]]++;
					$sum_table_5000[$row[$z]]++;
				} elseif ($z < 4) {
					$sum_table_4[$row[$z]]++;
					$sum_table_8[$row[$z]]++;
					$sum_table_24[$row[$z]]++;
					$sum_table_52[$row[$z]]++;
					$sum_table_104[$row[$z]]++;
					$sum_table_208[$row[$z]]++;
					$sum_table_5000[$row[$z]]++;
				} elseif ($z < 8) {
					$sum_table_8[$row[$z]]++;
					$sum_table_24[$row[$z]]++;
					$sum_table_52[$row[$z]]++;
					$sum_table_104[$row[$z]]++;
					$sum_table_208[$row[$z]]++;
					$sum_table_5000[$row[$z]]++;
				} elseif ($z < 24) {
					$sum_table_24[$row[$z]]++;
					$sum_table_52[$row[$z]]++;
					$sum_table_104[$row[$z]]++;
					$sum_table_208[$row[$z]]++;
					$sum_table_5000[$row[$z]]++;
				} elseif ($z < 52) {
					$sum_table_52[$row[$z]]++;
					$sum_table_104[$row[$z]]++;
					$sum_table_208[$row[$z]]++;
					$sum_table_5000[$row[$z]]++;
				} elseif ($z < 104) {
					$sum_table_104[$row[$z]]++;
					$sum_table_208[$row[$z]]++;
					$sum_table_5000[$row[$z]]++;
				} elseif ($z < 208) {
					$sum_table_208[$row[$z]]++;
					$sum_table_5000[$row[$z]]++;
				} elseif ($z < 5000) {
					$sum_table_5000[$row[$z]]++;
				}
			}

			$z++;
		}

		$sub_sum = array_fill (0, 6, 0);
		$sub_sum_tot = 0;
		$weighted_average_prev = 0;

		for ($x = 50; $x < 160; $x++)
		{
			print("<TR>\n");
			print("<TD>$x</TD>\n");
			if ($sum_table[$x] > 14) {
				print("<TD align=center><B><font color=\"#009900\">-$sum_table[$x]-</font></B></TD>\n");
			} else {
				print("<TD><CENTER><B>$sum_table[$x]</B></CENTER></TD>\n");
			}
			$sub_sum_tot += $sum_table[$x];

			if ($sum_table_1[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_1[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_1[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[0] += $sum_table_1[$x];

			if ($sum_table_2[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_2[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_2[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[1] += $sum_table_2[$x];

			if ($sum_table_4[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_4[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_4[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[2] += $sum_table_4[$x];

			if ($sum_table_8[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_8[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_8[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[3] += $sum_table_8[$x];

			if ($sum_table_24[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_24[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_24[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[4] += $sum_table_24[$x];

			
			if ($sum_table_52[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_52[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_52[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[5] += $sum_table_52[$x];

			if ($sum_table_104[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_104[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_104[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[6] += $sum_table_104[$x];

			if ($sum_table_208[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_208[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_208[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[7] += $sum_table_208[$x];

			if ($sum_table_5000[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_5000[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_5000[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[8] += $sum_table_5000[$x];

			if ($sum_table_date_prev[$x] == "1962-08-17") {
				print("<TD align=center><center>-</center></TD>\n");
			} elseif ($sum_table_date_prev[$x] < "2006-01-01") {
				print("<TD align=center><FONT COLOR=\"#ff0000\">$sum_table_date_prev[$x]</FONT></TD>\n");
			} elseif ($sum_table_date_prev[$x] < "2007-01-01") {
				print("<TD align=center><FONT COLOR=\"#ff6600\">$sum_table_date_prev[$x]</FONT></TD>\n");
			} else {
				print("<TD align=center><FONT COLOR=\"#000000\">$sum_table_date_prev[$x]</FONT></TD>\n");
			}

			if ($sum_table_date[$x] == "1962-08-17") {
				print("<TD align=center><center>-</center></TD>\n");
			} elseif ($sum_table_date[$x] < "2006-01-01") {
				print("<TD><FONT COLOR=\"#ff0000\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			} elseif ($sum_table_date[$x] < "2007-01-01") {
				print("<TD><FONT COLOR=\"#ff6600\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			} else {
				print("<TD><FONT COLOR=\"#000000\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			}

			$sum_temp_30 = number_format(($sum_table_2[$x]/30)*100,1);

			if ($sum_temp_30 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_30 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_30 %</font></TD>\n");
			}

			$sum_temp_104 = number_format(($sum_table_52[$x]/365)*100,1);

			if ($sum_temp_104 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_104 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_104 %</font></TD>\n");
			}

			$sum_temp_1000 = number_format(($sum_table_208[$x]/1000)*100,1);

			if ($sum_temp_1000 >= 1.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_1000 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_1000 %</font></TD>\n");
			}

			$sum_temp_5000 = number_format(($sum_table_5000[$x]/$num_rows_all)*100,1);

			if ($sum_temp_5000 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_5000 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_5000 %</font></TD>\n");
			}

			if ($game == 6)
			{
				$weighted_average = (
					#($sum_table_1[$x]/1*100*0.05) +
					($sum_table_2[$x]/2*100*0.15) +
					#($sum_table_4[$x]/50*100*0.10) +
					($sum_table_8[$x]/8*100*0.20) +
					#($sum_table_24[$x]/100*100*0.05) +
					($sum_table_52[$x]/52*100*0.25) +
					($sum_table_104[$x]/104*100*0.20) +
					#($sum_table_208[$x]/1000*100*0.05) +
					($sum_table_208[$x]/$num_rows_all*100*0.20));
			} else {
				$weighted_average = (
				($sum_table_1[$x]/10*100*0.05) +
				($sum_table_2[$x]/30*100*0.10) +
				#($sum_table_4[$x]/50*100*0.06) +
				($sum_table_8[$x]/100*100*0.15) +
				#($sum_table_24[$x]/200*100*0.15) + // extra
				($sum_table_52[$x]/365*100*0.20) +
				($sum_table_104[$x]/500*100*0.10) +
				($sum_table_208[$x]/1000*100*0.20) +
				($sum_table_5000[$x]/$num_rows_all*100*0.20));

				if ($sum_table_1[$x] > 0)
				{
					$temp10 = $sum_table_1[$x] - 1;
				} else {
					$temp10 = 0;
				}

				if ($sum_table_2[$x] > 0)
				{
					$temp30 = $sum_table_2[$x] - 1;
				} else {
					$temp30 = 0;
				}

				if ($sum_table_4[$x] > 0)
				{
					$temp50 = $sum_table_4[$x] - 1;
				} else {
					$temp50 = 0;
				}

				if ($sum_table_8[$x] > 0)
				{
					$temp100 = $sum_table_8[$x] - 1;
				} else {
					$temp100 = 0;
				}

				if ($sum_table_24[$x] > 0)
				{
					$temp200 = $sum_table_24[$x] - 1;
				} else {
					$temp200 = 0;
				}

				if ($sum_table_52[$x] > 0)
				{
					$temp365 = $sum_table_52[$x] - 1;
				} else {
					$temp365 = 0;
				}

				if ($sum_table_104[$x] > 0)
				{
					$temp500 = $sum_table_104[$x] - 1;
				} else {
					$temp500 = 0;
				}

				if ($sum_table_208[$x] > 0)
				{
					$temp1000 = $sum_table_208[$x] - 1;
				} else {
					$temp1000 = 0;
				}

				if ($sum_table_5000[$x] > 0)
				{
					$temp5000 = $sum_table_5000[$x] - 1;
				} else {
					$temp5000 = 0;
				}

				#print "sum_table_400[$x] = $sum_table_5000[$x]<br>";
				#print "temp5000 = $temp5000<br>";

				$weighted_average_prev = (
				($temp10/10*100*0.05) +
				($temp30/30*100*0.10) +
				#($temp50/50*100*0.06) +
				($temp100/100*100*0.15) +
				#($temp200/200*100*0.15) + // extra
				($temp365/365*100*0.20) +
				($temp500/500*100*0.10) +
				($temp1000/1000*100*0.20) +
				($temp5000/($num_rows_all-1)*100*0.20));

				#print "weighted_average_prev = $weighted_average_prev<br>";
			}

			$sum_temp_wa = number_format($weighted_average,1);

			$sum_temp_wa_prev = number_format($weighted_average_prev,1);

			if ($sum_temp_wa >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\" align=center><b>$sum_temp_wa %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\" align=center>$sum_temp_wa %</font></TD>\n");
			}

			if ($sum_temp_wa_prev >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><center><b>$sum_temp_wa_prev %</b></center></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\"><center>$sum_temp_wa_prev %</center></font></TD>\n");
			}

			print("</TR>\n");

			if ($x == 49 || $x == 59 || $x == 69 || $x == 79 || $x == 89 ||
				$x == 99 || $x == 109 || $x == 119 || $x == 129 || $x == 139 ||
				$x == 149 || $x == 159 || $x == 169 || $x == 179 || $x == 189 ||
				$x == 199 || $x == 209 || $x == 219 || $x == 229)
			{
				print("<TR>\n");
				print("<TD>&nbsp;</TD>\n");
				print("<TD><center>$sub_sum_tot</center></TD>\n");
				print("<TD><center>$sub_sum[0]</center></TD>\n");
				print("<TD><center>$sub_sum[1]</center></TD>\n");
				print("<TD><center>$sub_sum[2]</center></TD>\n");
				print("<TD><center>$sub_sum[3]</center></TD>\n");
				print("<TD><center>$sub_sum[4]</center></TD>\n");
				print("<TD><center>$sub_sum[5]</center></TD>\n");
				print("<TD><center>$sub_sum[6]</center></TD>\n");
				print("<TD><center>$sub_sum[7]</center></TD>\n");
				print("<TD><center>$sub_sum[8]</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");

				$sub_temp_30 = number_format(($sub_sum[1]/30)*100,1);

				if ($sub_temp_30 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_30 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_30 %</font></TD>\n");
				}

				$sub_temp_365 = number_format(($sub_sum[5]/365)*100,1);

				if ($sub_temp_365 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_365 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_365 %</font></TD>\n");
				}

				$sub_temp_1000 = number_format(($sub_sum[7]/1000)*100,1);

				if ($sub_temp_1000 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_1000 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_1000 %</font></TD>\n");
				}

				$sub_temp_5000 = number_format(($sub_sum[8]/$num_rows_all)*100,1);

				if ($sub_temp_5000 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_5000 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_5000 %</font></TD>\n");
				}

				$weighted_average_sub = (
				($sum_table_1[$x]/10*100*0.05) +
				($sum_table_2[$x]/30*100*0.10) +
				#($sum_table_4[$x]/50*100*0.06) +
				($sum_table_8[$x]/100*100*0.15) +
				#($sum_table_24[$x]/200*100*0.15) + // extra
				($sum_table_52[$x]/365*100*0.20) +
				($sum_table_104[$x]/500*100*0.10) +
				($sum_table_208[$x]/1000*100*0.20) +
				($sum_table_5000[$x]/$num_rows_all*100*0.20));

				#print("<TD><center>&nbsp;</center></TD>\n");
				#print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("</TR>\n");
				
				print("<TR>\n");
				print("<TD BGCOLOR=\"#eeeeee\">Sum</TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\">Count</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\"><center>Prev</center></TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\"><center>Last</center></TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>1000</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa_prev</TD>\n");
				print("</TR>\n");

				$sub_sum = array_fill (0,9, 0);
				$sub_sum_tot = 0;
			}
		}

		print("</TABLE>\n");
	}

	// ----------------------------------------------------------------------------------
	function print_pair_sum_table_6($limit,$num)
	{
		global $debug, $draw_table_name, $draw_prefix, $balls, $balls_drawn, $game; 

		require ("includes/mysqli.php");

		for ($x = 0; $x < 264; $x++)
		{
			$sum_table[$x] = 0;
			$sum_table_date[$x] = "1962-08-17";
			$sum_table_date_prev[$x] = "1962-08-17";
			$sum_table_1[$x] = 0;
			$sum_table_2[$x] = 0;
			$sum_table_4[$x] = 0;
			$sum_table_8[$x] = 0;
			$sum_table_24[$x] = 0;
			$sum_table_52[$x] = 0;
			$sum_table_104[$x] = 0;
			$sum_table_208[$x] = 0;
			$sum_table_312[$x] = 0;
			$sum_table_5000[$x] = 0;
		}
	
		$query = "SELECT pair_sum,date FROM $draw_table_name ";
		$query .= "WHERE b1 = $num ";
		$query .= "ORDER BY date DESC ";
		$query .= "LIMIT $limit ";

		print "$query<p>";
	
		$mysqli_result = mysqli_query($mysqli_link, $query) or die (mysqli_error($mysqli_link));

		$num_rows_all = mysqli_num_rows($mysqli_result); 

		//start table
		print("<h3>Sum Table - $limit - Combo 6</h3>\n");
		print "<h4>limit = $limit</h4>";

		print("<TABLE BORDER=\"1\">\n");
	
		//create header row
		print("<TR>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Sum</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Count</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>Prev</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>1000</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa_prev</TD>\n");
		print("</TR>\n");

		$z = 0;
	
		while($row = mysqli_fetch_array($mysqli_result))
		{
			$sum_table[$row[0]]++;
			if ($row[1] > $sum_table_date[$row[0]]) {
				$sum_table_date_prev[$row[0]] = $sum_table_date[$row[0]];
				$sum_table_date[$row[0]] = $row[1];
			} else if ($sum_table_date_prev[$row[0]] == '1962-08-17') {
				$sum_table_date_prev[$row[0]] = $row[1];
			}

			if ($z < 1) {
				$sum_table_1[$row[0]]++;
				$sum_table_2[$row[0]]++;
				$sum_table_4[$row[0]]++;
				$sum_table_8[$row[0]]++;
				$sum_table_24[$row[0]]++;
				$sum_table_52[$row[0]]++;
				$sum_table_104[$row[0]]++;
				$sum_table_208[$row[0]]++;
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 2) {
				$sum_table_2[$row[0]]++;
				$sum_table_4[$row[0]]++;
				$sum_table_8[$row[0]]++;
				$sum_table_24[$row[0]]++;
				$sum_table_52[$row[0]]++;
				$sum_table_104[$row[0]]++;
				$sum_table_208[$row[0]]++;
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 4) {
				$sum_table_4[$row[0]]++;
				$sum_table_8[$row[0]]++;
				$sum_table_24[$row[0]]++;
				$sum_table_52[$row[0]]++;
				$sum_table_104[$row[0]]++;
				$sum_table_208[$row[0]]++;
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 8) {
				$sum_table_8[$row[0]]++;
				$sum_table_24[$row[0]]++;
				$sum_table_52[$row[0]]++;
				$sum_table_104[$row[0]]++;
				$sum_table_208[$row[0]]++;
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 24) {
				$sum_table_24[$row[0]]++;
				$sum_table_52[$row[0]]++;
				$sum_table_104[$row[0]]++;
				$sum_table_208[$row[0]]++;
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 52) {
				$sum_table_52[$row[0]]++;
				$sum_table_104[$row[0]]++;
				$sum_table_208[$row[0]]++;
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 104) {
				$sum_table_104[$row[0]]++;
				$sum_table_208[$row[0]]++;
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 208) {
				$sum_table_208[$row[0]]++;
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 312) {
				$sum_table_312[$row[0]]++;
				$sum_table_5000[$x][$row[0]]++;
			} elseif ($z < 5000) {
				$sum_table_5000[$x][$row[0]]++;
			}

			$z++;
		}

		$sub_sum = array_fill (0, 6, 0);
		$sub_sum_tot = 0;
		$weighted_average_prev = 0;

		for ($x = 90; $x < 210; $x++)
		{
			print("<TR>\n");
			print("<TD>$x</TD>\n");
			if ($sum_table[$x] > 14) {
				print("<TD align=center><B><font color=\"#009900\">-$sum_table[$x]-</font></B></TD>\n");
			} else {
				print("<TD><CENTER><B>$sum_table[$x]</B></CENTER></TD>\n");
			}
			$sub_sum_tot += $sum_table[$x];

			if ($sum_table_1[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_1[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_1[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[0] += $sum_table_1[$x];

			if ($sum_table_2[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_2[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_2[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[1] += $sum_table_2[$x];

			if ($sum_table_4[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_4[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_4[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[2] += $sum_table_4[$x];

			if ($sum_table_8[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_8[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_8[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[3] += $sum_table_8[$x];

			if ($sum_table_24[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_24[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_24[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[4] += $sum_table_24[$x];

			
			if ($sum_table_52[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_52[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_52[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[5] += $sum_table_52[$x];

			if ($sum_table_104[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_104[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_104[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[6] += $sum_table_104[$x];

			if ($sum_table_208[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_208[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_208[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[7] += $sum_table_208[$x];

			if ($sum_table_312[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_312[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_312[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[7] += $sum_table_312[$x];

			if ($sum_table_5000[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_5000[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_5000[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[9] += $sum_table_5000[$x];

			if ($sum_table_date_prev[$x] == "1962-08-17") {
				print("<TD align=center><center>-</center></TD>\n");
			} elseif ($sum_table_date_prev[$x] < "2006-01-01") {
				print("<TD align=center><FONT COLOR=\"#ff0000\">$sum_table_date_prev[$x]</FONT></TD>\n");
			} elseif ($sum_table_date_prev[$x] < "2007-01-01") {
				print("<TD align=center><FONT COLOR=\"#ff6600\">$sum_table_date_prev[$x]</FONT></TD>\n");
			} else {
				print("<TD align=center><FONT COLOR=\"#000000\">$sum_table_date_prev[$x]</FONT></TD>\n");
			}

			if ($sum_table_date[$x] == "1962-08-17") {
				print("<TD align=center><center>-</center></TD>\n");
			} elseif ($sum_table_date[$x] < "2006-01-01") {
				print("<TD><FONT COLOR=\"#ff0000\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			} elseif ($sum_table_date[$x] < "2007-01-01") {
				print("<TD><FONT COLOR=\"#ff6600\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			} else {
				print("<TD><FONT COLOR=\"#000000\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			}

			$sum_temp_30 = number_format(($sum_table_2[$x]/30)*100,1);

			if ($sum_temp_30 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_30 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_30 %</font></TD>\n");
			}

			$sum_temp_104 = number_format(($sum_table_52[$x]/365)*100,1);

			if ($sum_temp_104 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_104 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_104 %</font></TD>\n");
			}

			$sum_temp_1000 = number_format(($sum_table_208[$x]/1000)*100,1);

			if ($sum_temp_1000 >= 1.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_1000 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_1000 %</font></TD>\n");
			}

			$sum_temp_5000 = number_format(($sum_table_5000[$x]/$num_rows_all)*100,1);

			if ($sum_temp_5000 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_5000 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_5000 %</font></TD>\n");
			}

			if ($game == 6)
			{
				$weighted_average = (
					($sum_table_2[$x]/2*100*0.05) +
					($sum_table_8[$x]/8*100*0.20) +
					($sum_table_24[$x]/24*100*0.25) +
					($sum_table_52[$x]/52*100*0.25) +
					($sum_table_104[$x]/104*100*0.25));
					#($sum_table_208[$x]/208*100*0.40));
					#($sum_table_208[$x]/$num_rows_all*100*0.45));
			} else {
				$weighted_average = (
				($sum_table_1[$x]/10*100*0.05) +
				($sum_table_2[$x]/30*100*0.10) +
				#($sum_table_4[$x]/50*100*0.06) +
				($sum_table_8[$x]/100*100*0.15) +
				#($sum_table_24[$x]/200*100*0.15) + // extra
				($sum_table_52[$x]/365*100*0.20) +
				($sum_table_104[$x]/500*100*0.10) +
				($sum_table_208[$x]/1000*100*0.20) +
				($sum_table_5000[$x]/$num_rows_all*100*0.20));

				if ($sum_table_1[$x] > 0)
				{
					$temp1 = $sum_table_1[$x] - 1;
				} else {
					$temp1 = 0;
				}

				if ($sum_table_2[$x] > 0)
				{
					$temp2 = $sum_table_2[$x] - 1;
				} else {
					$temp2 = 0;
				}

				if ($sum_table_4[$x] > 0)
				{
					$temp4 = $sum_table_4[$x] - 1;
				} else {
					$temp8 = 0;
				}

				if ($sum_table_8[$x] > 0)
				{
					$temp8 = $sum_table_8[$x] - 1;
				} else {
					$temp8 = 0;
				}

				if ($sum_table_24[$x] > 0)
				{
					$temp24 = $sum_table_24[$x] - 1;
				} else {
					$temp24 = 0;
				}

				if ($sum_table_52[$x] > 0)
				{
					$temp52 = $sum_table_52[$x] - 1;
				} else {
					$temp52 = 0;
				}

				if ($sum_table_104[$x] > 0)
				{
					$temp104 = $sum_table_104[$x] - 1;
				} else {
					$temp104 = 0;
				}

				if ($sum_table_208[$x] > 0)
				{
					$temp208 = $sum_table_208[$x] - 1;
				} else {
					$temp208 = 0;
				}

				if ($sum_table_312[$x] > 0)
				{
					$temp312 = $sum_table_208[$x] - 1;
				} else {
					$temp312 = 0;
				}

				if ($sum_table_5000[$x] > 0)
				{
					$temp5000 = $sum_table_5000[$x] - 1;
				} else {
					$temp5000 = 0;
				}

				#print "sum_table_400[$x] = $sum_table_5000[$x]<br>";
				#print "temp5000 = $temp5000<br>";

				$weighted_average_prev = (
				($temp1/10*100*0.05) +
				($temp2/30*100*0.10) +
				($temp4/50*100*0.06) +
				($temp8/100*100*0.15) +
				($temp24/200*100*0.15) + // extra
				($temp52/365*100*0.20) +
				($temp500/104*100*0.10) +
				($temp1000/208*100*0.20) +
				($temp1000/312*100*0.20) +
				($temp5000/($num_rows_all-1)*100*0.20));

				#print "weighted_average_prev = $weighted_average_prev<br>";
			}

			$sum_temp_wa = number_format($weighted_average,1);

			$sum_temp_wa_prev = number_format($weighted_average_prev,1);

			if ($sum_temp_wa >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\" align=center><b>$sum_temp_wa %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\" align=center>$sum_temp_wa %</font></TD>\n");
			}

			if ($sum_temp_wa_prev >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><center><b>$sum_temp_wa_prev %</b></center></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\"><center>$sum_temp_wa_prev %</center></font></TD>\n");
			}

			$query_test = "INSERT INTO fl_draw_pair_sum ";
			$query_test .= "VALUES ('0', ";
			$query_test .= "'$x', ";
			$query_test .= "'$sum_temp_wa') ";

			#print "$query_test<br>";

			$mysqli_result_test = mysqli_query($query_test, $mysqli_link) or die (mysqli_error($mysqli_link));

			print("</TR>\n");

			if ($x == 49 || $x == 59 || $x == 69 || $x == 79 || $x == 89 ||
				$x == 99 || $x == 109 || $x == 119 || $x == 129 || $x == 139 ||
				$x == 149 || $x == 159 || $x == 169 || $x == 179 || $x == 189 ||
				$x == 199 || $x == 209 || $x == 219 || $x == 229)
			{
				print("<TR>\n");
				print("<TD>&nbsp;</TD>\n");
				print("<TD><center>$sub_sum_tot</center></TD>\n");
				print("<TD><center>$sub_sum[0]</center></TD>\n");
				print("<TD><center>$sub_sum[1]</center></TD>\n");
				print("<TD><center>$sub_sum[2]</center></TD>\n");
				print("<TD><center>$sub_sum[3]</center></TD>\n");
				print("<TD><center>$sub_sum[4]</center></TD>\n");
				print("<TD><center>$sub_sum[5]</center></TD>\n");
				print("<TD><center>$sub_sum[6]</center></TD>\n");
				print("<TD><center>$sub_sum[7]</center></TD>\n");
				print("<TD><center>$sub_sum[8]</center></TD>\n");
				print("<TD><center>$sub_sum[9]</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");

				$sub_temp_30 = number_format(($sub_sum[1]/30)*100,1);

				if ($sub_temp_30 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_30 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_30 %</font></TD>\n");
				}

				$sub_temp_365 = number_format(($sub_sum[5]/365)*100,1);

				if ($sub_temp_365 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_365 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_365 %</font></TD>\n");
				}

				$sub_temp_1000 = number_format(($sub_sum[7]/1000)*100,1);

				if ($sub_temp_1000 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_1000 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_1000 %</font></TD>\n");
				}

				$sub_temp_5000 = number_format(($sub_sum[8]/$num_rows_all)*100,1);

				if ($sub_temp_5000 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_5000 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_5000 %</font></TD>\n");
				}

				$weighted_average_sub = (
				($sum_table_1[$x]/10*100*0.05) +
				($sum_table_2[$x]/30*100*0.10) +
				#($sum_table_4[$x]/50*100*0.06) +
				($sum_table_8[$x]/100*100*0.15) +
				#($sum_table_24[$x]/200*100*0.15) + // extra
				($sum_table_52[$x]/365*100*0.20) +
				($sum_table_104[$x]/500*100*0.10) +
				($sum_table_208[$x]/1000*100*0.20) +
				($sum_table_5000[$x]/$num_rows_all*100*0.20));

				#print("<TD><center>&nbsp;</center></TD>\n");
				#print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("</TR>\n");
				
				print("<TR>\n");
				print("<TD BGCOLOR=\"#eeeeee\">Sum</TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\">Count</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\"><center>Prev</center></TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\"><center>Last</center></TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>1000</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa_prev</TD>\n");
				print("</TR>\n");

				$sub_sum = array_fill (0,9, 0);
				$sub_sum_tot = 0;
			}
		}

		print("</TABLE>\n");
	}

	// ----------------------------------------------------------------------------------
	function print_pair_sum_table_5_single($limit,$combin_set)
	{
		global $debug, $draw_table_name, $draw_prefix, $balls, $balls_drawn, $game; 

		require ("includes/mysqli.php");

		for ($x = 0; $x < 264; $x++)
		{
			$sum_table[$x] = 0;
			$sum_table_date[$x] = "1962-08-17";
			$sum_table_date_prev[$x] = "1962-08-17";
			$sum_table_1[$x] = 0;
			$sum_table_2[$x] = 0;
			$sum_table_4[$x] = 0;
			$sum_table_8[$x] = 0;
			$sum_table_24[$x] = 0;
			$sum_table_52[$x] = 0;
			$sum_table_104[$x] = 0;
			$sum_table_208[$x] = 0;
			$sum_table_312[$x] = 0;
			$sum_table_5000[$x] = 0;
		}
	
		$query = "SELECT * FROM $draw_table_name ";
		$query .= "ORDER BY date DESC ";
		$query .= "LIMIT $limit ";

		print "$query<p>";
	
		$mysqli_result = mysqli_query($mysqli_link, $query) or die (mysqli_error($mysqli_link));

		$num_rows_all = mysqli_num_rows($mysqli_result); 

		$k = $combin_set - 25;

		//start table
		print("<h3>Sum Table - $limit - Combo 5 / Set $k</h3>\n");
		print "<h4>limit = $limit</h4>";

		print("<TABLE BORDER=\"1\">\n");
	
		//create header row
		print("<TR>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Sum</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Count</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>Prev</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>Last</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>1000</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
		print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa_prev</TD>\n");
		print("</TR>\n");

		$z = $combin_set;
		$x = 0;
	
		while($row = mysqli_fetch_array($mysqli_result))
		{
		
			$sum_table[$row[$combin_set]]++;

			if ($row[date] > $sum_table_date[$z]) {
				$sum_table_date_prev[$z] = $sum_table_date[$z];
				$sum_table_date[$z] = $row[date];
			} else if ($sum_table_date_prev[$row[$z]] == '1962-08-17') {
				$sum_table_date_prev[$row[$z]] = $row[date];
			}

			if ($x < 1) {
				$sum_table_1[$row[$z]]++;
				$sum_table_2[$row[$z]]++;
				$sum_table_4[$row[$z]]++;
				$sum_table_8[$row[$z]]++;
				$sum_table_24[$row[$z]]++;
				$sum_table_52[$row[$z]]++;
				$sum_table_104[$row[$z]]++;
				$sum_table_208[$row[$z]]++;
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} elseif ($x < 2) {
				$sum_table_2[$row[$z]]++;
				$sum_table_4[$row[$z]]++;
				$sum_table_8[$row[$z]]++;
				$sum_table_24[$row[$z]]++;
				$sum_table_52[$row[$z]]++;
				$sum_table_104[$row[$z]]++;
				$sum_table_208[$row[$z]]++;
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} elseif ($x < 4) {
				$sum_table_4[$row[$z]]++;
				$sum_table_8[$row[$z]]++;
				$sum_table_24[$row[$z]]++;
				$sum_table_52[$row[$z]]++;
				$sum_table_104[$row[$z]]++;
				$sum_table_208[$row[$z]]++;
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} elseif ($x < 8) {
				$sum_table_8[$row[$z]]++;
				$sum_table_24[$row[$z]]++;
				$sum_table_52[$row[$z]]++;
				$sum_table_104[$row[$z]]++;
				$sum_table_208[$row[$z]]++;
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} elseif ($x < 24) {
				$sum_table_24[$row[$z]]++;
				$sum_table_52[$row[$z]]++;
				$sum_table_104[$row[$z]]++;
				$sum_table_208[$row[$z]]++;
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} elseif ($x < 52) {
				$sum_table_52[$row[$z]]++;
				$sum_table_104[$row[$z]]++;
				$sum_table_208[$row[$z]]++;
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} elseif ($x < 104) {
				$sum_table_104[$row[$z]]++;
				$sum_table_208[$row[$z]]++;
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} elseif ($x < 208) {
				$sum_table_208[$row[$z]]++;
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} elseif ($x < 312) {
				$sum_table_312[$row[$z]]++;
				$sum_table_5000[$row[$z]]++;
			} else {
				$sum_table_5000[$row[$z]]++;
			}

			$x++;
		}

		$sub_sum = array_fill (0, 6, 0);
		$sub_sum_tot = 0;
		$weighted_average_prev = 0;

		for ($x = 50; $x < 160; $x++)
		{
			print("<TR>\n");
			print("<TD>$x</TD>\n");
			if ($sum_table[$x] > 14) {
				print("<TD align=center><B><font color=\"#009900\">-$sum_table[$x]-</font></B></TD>\n");
			} else {
				print("<TD><CENTER><B>$sum_table[$x]</B></CENTER></TD>\n");
			}
			$sub_sum_tot += $sum_table[$x];

			if ($sum_table_1[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_1[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_1[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[0] += $sum_table_1[$x];

			if ($sum_table_2[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_2[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_2[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[1] += $sum_table_2[$x];

			if ($sum_table_4[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_4[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_4[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[2] += $sum_table_4[$x];

			if ($sum_table_8[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_8[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_8[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[3] += $sum_table_8[$x];

			if ($sum_table_24[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\"><CENTER><b>$sum_table_24[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_24[$x] == 1) {
				print("<TD><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[4] += $sum_table_24[$x];
			
			if ($sum_table_52[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_52[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_52[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[5] += $sum_table_52[$x];

			if ($sum_table_104[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_104[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_104[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[6] += $sum_table_104[$x];

			if ($sum_table_208[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_208[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_208[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[7] += $sum_table_208[$x];

			if ($sum_table_312[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_312[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_312[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[8] += $sum_table_312[$x];

			if ($sum_table_5000[$x] > 1) {
				print("<TD BGCOLOR=\"#CCFFFF\" align=center><CENTER><b>$sum_table_5000[$x]</b></CENTER></TD>\n");
			} elseif ($sum_table_5000[$x] == 1) {
				print("<TD align=center><CENTER>1</CENTER></TD>\n");
			} else {
				print("<TD align=center><CENTER>-</CENTER></TD>\n");
			}
			$sub_sum[9] += $sum_table_5000[$x];

			if ($sum_table_date_prev[$x] == "1962-08-17") {
				print("<TD align=center><center>-</center></TD>\n");
			} elseif ($sum_table_date_prev[$x] < "2006-01-01") {
				print("<TD align=center><FONT COLOR=\"#ff0000\">$sum_table_date_prev[$x]</FONT></TD>\n");
			} elseif ($sum_table_date_prev[$x] < "2007-01-01") {
				print("<TD align=center><FONT COLOR=\"#ff6600\">$sum_table_date_prev[$x]</FONT></TD>\n");
			} else {
				print("<TD align=center><FONT COLOR=\"#000000\">$sum_table_date_prev[$x]</FONT></TD>\n");
			}

			if ($sum_table_date[$x] == "1962-08-17") {
				print("<TD align=center><center>-</center></TD>\n");
			} elseif ($sum_table_date[$x] < "2006-01-01") {
				print("<TD><FONT COLOR=\"#ff0000\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			} elseif ($sum_table_date[$x] < "2007-01-01") {
				print("<TD><FONT COLOR=\"#ff6600\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			} else {
				print("<TD><FONT COLOR=\"#000000\" align=center>$sum_table_date[$x]</FONT></TD>\n");
			}

			$sum_temp_30 = number_format(($sum_table_2[$x]/30)*100,1);

			if ($sum_temp_30 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_30 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_30 %</font></TD>\n");
			}

			$sum_temp_104 = number_format(($sum_table_52[$x]/365)*100,1);

			if ($sum_temp_104 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_104 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_104 %</font></TD>\n");
			}

			$sum_temp_1000 = number_format(($sum_table_208[$x]/1000)*100,1);

			if ($sum_temp_1000 >= 1.0)
			{
				print("<TD align=center><font size=\"-1\"><b>$sum_temp_1000 %</b></font></TD>\n");
			} else {
				print("<TD align=center><font size=\"-1\">$sum_temp_1000 %</font></TD>\n");
			}

			$sum_temp_5000 = number_format(($sum_table_5000[$x]/$num_rows_all)*100,1);

			if ($sum_temp_5000 >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><b>$sum_temp_5000 %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\">$sum_temp_5000 %</font></TD>\n");
			}

			if ($game == 6)
			{
				$weighted_average = (
					($sum_table_1[$x]/1*100*0.05) +
					($sum_table_2[$x]/2*100*0.10) +
					#($sum_table_4[$x]/50*100*0.10) +
					($sum_table_8[$x]/8*100*0.20) +
					#($sum_table_24[$x]/100*100*0.05) +
					($sum_table_52[$x]/52*100*0.25) +
					($sum_table_104[$x]/104*100*0.20) +
					#($sum_table_208[$x]/1000*100*0.05) +
					($sum_table_208[$x]/208*100*0.10));
					#($sum_table_208[$x]/$num_rows_all*100*0.10));
			} else {
				$weighted_average = (
				($sum_table_1[$x]/10*100*0.05) +
				($sum_table_2[$x]/30*100*0.10) +
				#($sum_table_4[$x]/50*100*0.06) +
				($sum_table_8[$x]/100*100*0.15) +
				#($sum_table_24[$x]/200*100*0.15) + // extra
				($sum_table_52[$x]/365*100*0.20) +
				($sum_table_104[$x]/500*100*0.10) +
				($sum_table_208[$x]/1000*100*0.20) +
				($sum_table_5000[$x]/$num_rows_all*100*0.20));

				if ($sum_table_1[$x] > 0)
				{
					$temp1 = $sum_table_1[$x] - 1;
				} else {
					$temp1 = 0;
				}

				if ($sum_table_2[$x] > 0)
				{
					$temp2 = $sum_table_2[$x] - 1;
				} else {
					$temp2 = 0;
				}

				if ($sum_table_4[$x] > 0)
				{
					$temp4 = $sum_table_4[$x] - 1;
				} else {
					$temp4 = 0;
				}

				if ($sum_table_8[$x] > 0)
				{
					$temp8 = $sum_table_8[$x] - 1;
				} else {
					$temp8 = 0;
				}

				if ($sum_table_24[$x] > 0)
				{
					$temp24 = $sum_table_24[$x] - 1;
				} else {
					$temp24 = 0;
				}

				if ($sum_table_52[$x] > 0)
				{
					$temp52 = $sum_table_52[$x] - 1;
				} else {
					$temp52 = 0;
				}

				if ($sum_table_104[$x] > 0)
				{
					$temp104 = $sum_table_104[$x] - 1;
				} else {
					$temp104 = 0;
				}

				if ($sum_table_208[$x] > 0)
				{
					$temp208 = $sum_table_208[$x] - 1;
				} else {
					$temp208 = 0;
				}

				if ($sum_table_312[$x] > 0)
				{
					$temp312 = $sum_table_208[$x] - 1;
				} else {
					$temp312 = 0;
				}

				if ($sum_table_5000[$x] > 0)
				{
					$temp5000 = $sum_table_5000[$x] - 1;
				} else {
					$temp5000 = 0;
				}

				#print "sum_table_400[$x] = $sum_table_5000[$x]<br>";
				#print "temp5000 = $temp5000<br>";

				$weighted_average_prev = (
				($temp1/10*100*0.05) +
				($temp2/30*100*0.10) +
				($temp4/50*100*0.06) +
				($temp8/100*100*0.15) +
				($temp24/200*100*0.15) + // extra
				($temp52/365*100*0.20) +
				($temp104/500*100*0.10) +
				($temp208/1000*100*0.20) +
				($temp312/1000*100*0.20) +
				($temp5000/($num_rows_all-1)*100*0.20));

				#print "weighted_average_prev = $weighted_average_prev<br>";
			}

			$sum_temp_wa = number_format($weighted_average,1);

			$sum_temp_wa_prev = number_format($weighted_average_prev,1);

			if ($sum_temp_wa >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\" align=center><b>$sum_temp_wa %</b></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\" align=center>$sum_temp_wa %</font></TD>\n");
			}

			if ($sum_temp_wa_prev >= 1.0)
			{
				print("<TD align=right align=center><font size=\"-1\"><center><b>$sum_temp_wa_prev %</b></center></font></TD>\n");
			} else {
				print("<TD align=right align=center><font size=\"-1\"><center>$sum_temp_wa_prev %</center></font></TD>\n");
			}

			print("</TR>\n");

			if ($x == 49 || $x == 59 || $x == 69 || $x == 79 || $x == 89 ||
				$x == 99 || $x == 109 || $x == 119 || $x == 129 || $x == 139 ||
				$x == 149 || $x == 159 || $x == 169 || $x == 179 || $x == 189 ||
				$x == 199 || $x == 209 || $x == 219 || $x == 229)
			{
				print("<TR>\n");
				print("<TD>&nbsp;</TD>\n");
				print("<TD><center>$sub_sum_tot</center></TD>\n");
				print("<TD><center>$sub_sum[0]</center></TD>\n");
				print("<TD><center>$sub_sum[1]</center></TD>\n");
				print("<TD><center>$sub_sum[2]</center></TD>\n");
				print("<TD><center>$sub_sum[3]</center></TD>\n");
				print("<TD><center>$sub_sum[4]</center></TD>\n");
				print("<TD><center>$sub_sum[5]</center></TD>\n");
				print("<TD><center>$sub_sum[6]</center></TD>\n");
				print("<TD><center>$sub_sum[7]</center></TD>\n");
				print("<TD><center>$sub_sum[8]</center></TD>\n");
				print("<TD><center>$sub_sum[9]</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");

				$sub_temp_30 = number_format(($sub_sum[1]/30)*100,1);

				if ($sub_temp_30 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_30 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_30 %</font></TD>\n");
				}

				$sub_temp_365 = number_format(($sub_sum[5]/365)*100,1);

				if ($sub_temp_365 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_365 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_365 %</font></TD>\n");
				}

				$sub_temp_1000 = number_format(($sub_sum[7]/1000)*100,1);

				if ($sub_temp_1000 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_1000 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_1000 %</font></TD>\n");
				}

				$sub_temp_5000 = number_format(($sub_sum[8]/$num_rows_all)*100,1);

				if ($sub_temp_5000 >= 10.0)
				{
					print("<TD align=right><font size=\"-1\" align=center><b>$sub_temp_5000 %</b></font></TD>\n");
				} else {
					print("<TD align=right><font size=\"-1\" align=center>$sub_temp_5000 %</font></TD>\n");
				}

				$weighted_average_sub = (
				($sum_table_1[$x]/10*100*0.05) +
				($sum_table_2[$x]/30*100*0.10) +
				#($sum_table_4[$x]/50*100*0.06) +
				($sum_table_8[$x]/100*100*0.15) +
				#($sum_table_24[$x]/200*100*0.15) + // extra
				($sum_table_52[$x]/365*100*0.20) +
				($sum_table_104[$x]/500*100*0.10) +
				($sum_table_208[$x]/1000*100*0.20) +
				($sum_table_5000[$x]/$num_rows_all*100*0.20));

				#print("<TD><center>&nbsp;</center></TD>\n");
				#print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("<TD><center>&nbsp;</center></TD>\n");
				print("</TR>\n");
				
				print("<TR>\n");
				print("<TD BGCOLOR=\"#eeeeee\">Sum</TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\">Count</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">Last</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1wk</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">2wk</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">3mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">6mth</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">1yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">2yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">3yr</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\">$num_rows_all</TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\"><center>Prev</center></TD>\n");
				print("<TD BGCOLOR=\"#eeeeee\"><center>Last</center></TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>30</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>365</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>1000</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>$num_rows_all</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa</TD>\n");
				print("<TD BGCOLOR=\"#CCCCCC\" align=center>wa_prev</TD>\n");
				print("</TR>\n");

				$sub_sum = array_fill (0,9, 0);
				$sub_sum_tot = 0;
			}
		}

		print("</TABLE>\n");
	}

	print("</body>");
	print("</html>");

?>