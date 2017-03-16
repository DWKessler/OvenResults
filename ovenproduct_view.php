<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="css/normalize.css" />
<title>View Records</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php include 'header.php';?>
<h1 class="viewTitle">View Records</h1>

<p class="viewOptions"><b>View All</b> | <a href="ovenproduct_view-paginated.php">View Paginated</a></p>

<?php
// connect to the database
include('connect-db.php');

// get the records from the database
if ($result = $mysqli->query("SELECT * FROM ovenshifter_products ORDER BY product"))
{
// display records if there are records to display
if ($result->num_rows > 0)
{
// display records in a table
echo "<table border='1' cellpadding='10' class="viewTable">";

// set table headers
echo "<tr>
		<th>id</th>
		<th>product</th>
		<th>FL</th>
		<th>FH</th>
		<th>NH</th>
		<th>NL</th>
		<th></th>
		<th></th>
	 </tr>";

while ($row = $result->fetch_object())
{
// set up a row for each record
echo "<tr>";
echo "<td>" . $row->id . "</td>";
echo "<td>" . $row->product . "</td>";
echo "<td>" . $row->FL . "</td>";
echo "<td>" . $row->FH . "</td>";
echo "<td>" . $row->NH . "</td>";
echo "<td>" . $row->NL . "</td>";
echo "<td><a href='ovenproduct_records.php?id=" . $row->id . "'>Edit</a></td>";
echo "<td><a href='ovenproduct_delete.php?id=" . $row->id . "'>Delete</a></td>";
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

<a class="addNew" href="ovenproduct_records.php">Add New Record</a>
</body>


 <footer>
  <p>Document#: QAF0531</p>
 </footer>

</html>
