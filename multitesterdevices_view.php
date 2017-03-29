<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<link rel="stylesheet" href="css/normalize.css" />
		<link rel="stylesheet" href="css/view.css" />
		<title>View Multitester Devices</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		<?php include 'header.php';?>
		<h1 class="viewTitle">View Multitester Devices</h1>

		<p class='viewOptions'><b>View All</b> | <a href="multitesterdevices_view-paginated.php">View Paginated</a></p>

		<?php
			//modified from Benjamin Falk's framework at http://www.killersites.com/community/index.php?/topic/3064-basic-php-system-view-edit-add-delete-records-with-mysqli/

			// connect to the database
			include('connect-db.php');

			// get the records from the database
			if ($result = $mysqli->query("SELECT * FROM multitester_devices ORDER BY device_id"))
			{
				// display records if there are records to display
				if ($result->num_rows > 0)
				{
					// display records in a table
					echo "<table border='1' cellpadding='10' class='viewTable'>";

					// set table headers
					echo "<tr>
							<th>device_id</th>
							<th>description</th>
							<th></th>
							<th></th>
						 </tr>";

					while ($row = $result->fetch_object())
					{
						// set up a row for each record
						echo "<tr>";
						echo "<td>" . $row->device_id . "</td>";
						echo "<td>" . $row->description . "</td>";
						echo "<td><a href='multitesterdevices_records.php?device_id=" . $row->device_id . "'>Edit</a></td>";
						echo "<td><a href='multitesterdevices_delete.php?device_id=" . $row->device_id . "'>Delete</a></td>";
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

		<a class="addNew" href="multitesterdevices_records.php">Add New Record</a>
	</body>
	<footer>
		<p>Document#:</p>
	</footer>
</html>
