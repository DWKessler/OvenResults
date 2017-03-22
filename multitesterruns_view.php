<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/view.css" />
	<title>View Multitester Runs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<?php include 'header.php';?>
	<h1 class="viewTitle">View Multitester Runs</h1>

	<p class='viewOptions'><b>View All</b> | <a href="multitesterruns_view-paginated.php">View Paginated</a></p>

	<?php
	//modified from Benjamin Falk's framework at http://www.killersites.com/community/index.php?/topic/3064-basic-php-system-view-edit-add-delete-records-with-mysqli/
	
	// connect to the database
	include('connect-db.php');

	// get the records from the database
	if ($result = $mysqli->query("SELECT * FROM multitester_runs ORDER BY runid"))
	{
		// display records if there are records to display
		if ($result->num_rows > 0)
		{
			// display records in a table
			echo "<table border='1' cellpadding='10' class='viewTable'>";

			// set table headers
			echo "<tr>
					<th>runid</th>
					<th>device</th>
					<th>product</th>
					<th>lot</th>
					<th>description</th>
					<th></th>
					<th></th>
				 </tr>";

			while ($row = $result->fetch_object())
			{
				// set up a row for each record
				echo "<tr>";
				echo "<td>" . $row->runid . "</td>";
				echo "<td>" . $row->device . "</td>";
				echo "<td>" . $row->product . "</td>";
				echo "<td>" . $row->lot . "</td>";
				echo "<td>" . $row->description . "</td>";
				echo "<td><a href='multitesterruns_view-targets.php?runid=" . $row->runid . "'>View Targets/Progress</a></td>";
				echo "<td><a href='multitesterruns_records.php?runid=" . $row->runid . "'>Edit</a></td>";
				//echo "<td><a href='multitesterruns_delete.php?runid=" . $row->runid . "'>Delete</a></td>";
				echo "</tr>";
			}

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

	<a class="addNew" href="multitesterruns_records.php">Add New Record</a>
</body>


 <footer>
  <p>Document#: </p>
 </footer>

</html>
