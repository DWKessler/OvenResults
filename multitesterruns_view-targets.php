<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="css/normalize.css" />
	<title>View Multitester Targets</title>
	<?php if (isset($_GET['runid'])) {
						$runid = $_GET['runid'];
					} ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<?php include 'header.php';?>
	<h1 class="viewTitle">View Multitester Targets</h1>

	<?php
	// connect to the database
	include('connect-db.php');

	// get the records from the database
	if ($result = $mysqli->query("SELECT targetcycles FROM multitester_targetCycles WHERE runid = '$runid'
	UNION ALL
	SELECT reachedcycles FROM multitester_reachedCycles WHERE runid = '$runid'"))
	{
		// display records if there are records to display
		if ($result->num_rows > 0)
		{
			// display records in a table
			echo "<table border='1' cellpadding='10' class="viewTable">";

			// set table headers
			echo "<tr>
					<th>runid</th>
					<th>T1</th>
					<th>T2</th>
					<th>T3</th>
					<th>T4</th>
					<th>T5</th>
					<th>T6</th>
					<th>T7</th>
					<th></th>
				 </tr>";
			$array = array(9);
			$i=1;
			while ($row = $result->fetch_row())
			{
				$array[$i]=$row;
				$i++;

			}

						// set up a row for each record
			echo "<tr>";
			echo "<td>" . $runid . " Target Cycles</td>";
			echo "<td>" . $array[1][0] . "</td>";
			echo "<td>" . $array[2][0] . "</td>";
			echo "<td>" . $array[3][0] . "</td>";
			echo "<td>" . $array[4][0] . "</td>";
			echo "<td>" . $array[5][0] . "</td>";
			echo "<td>" . $array[6][0] . "</td>";
			echo "<td>" . $array[7][0] . "</td>";
			echo "<td><a href='multitesterruns_records-targets.php?runid=" . $runid . "'>Edit Targets</a></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>" . $runid . " Reached Cycles</td>";
			echo "<td>" . $array[8][0] . "</td>";
			echo "<td>" . $array[9][0] . "</td>";
			echo "<td>" . $array[10][0] . "</td>";
			echo "<td>" . $array[11][0] . "</td>";
			echo "<td>" . $array[12][0] . "</td>";
			echo "<td>" . $array[13][0] . "</td>";
			echo "<td>" . $array[14][0] . "</td>";
			echo "<td>-</td>";
			echo "</tr>";
			echo "</table>";
		}
		// if there are no records in the database, display an alert message
		else
		{
			echo "No results to display!";
		}
	}
	// show an error if there is an issue with the database query
	else
	{
		echo "Error: " . $mysqli->error;
	}

	// close database connection
	$mysqli->close();

	?>

	<a class="addNew" href="multitesterruns_view.php">Back to Runs</a>
</body>


 <footer>
  <p>Document#: </p>
 </footer>

</html>
