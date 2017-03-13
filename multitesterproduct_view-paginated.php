<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="css/normalize.css" />
<title>View Multitester Products</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php include 'header.php';?>
<h1>View Multitester Products</h1>

<?php
// connect to the database
include('connect-db.php');

// number of results to show per page
$per_page = 20;

// figure out the total pages in the database
if ($result = $mysqli->query("SELECT * FROM multitester_products ORDER BY product"))
{
if ($result->num_rows != 0)
{
$total_results = $result->num_rows;
// ceil() returns the next highest integer value by rounding up value if necessary
$total_pages = ceil($total_results / $per_page);

// check if the 'page' variable is set in the URL (ex: view-paginated.php?page=1)
if (isset($_GET['page']) && is_numeric($_GET['page']))
{
$show_page = $_GET['page'];

// make sure the $show_page value is valid
if ($show_page > 0 && $show_page <= $total_pages)
{
$start = ($show_page -1) * $per_page;
$end = $start + $per_page;
}
else
{
// error - show first set of results
$start = 0;
$end = $per_page;
}
}
else
{
// if page isn't set, show first set of results
$start = 0;
$end = $per_page;
}

// display pagination
echo "<p><a href='multitesterproduct_view.php'>View All</a> | <b>View Page:</b> ";
for ($i = 1; $i <= $total_pages; $i++)
{
if (isset($_GET['page']) && $_GET['page'] == $i)
{
echo $i . " ";
}
else
{
echo "<a href='multitesterproduct_view-paginated.php?page=$i'>$i</a> ";
}
}
echo "</p>";

// display data in table
echo "<table border='1' cellpadding='10'>";
echo "<tr>
		<th>id</th>
		<th>product</th>
		<th>FL</th>
		<th>FH</th>
		<th>NH</th>
		<th>NL</th>
		<th>safetyLimit</th>
		<th>offOffset</th>
		<th>onOffset</th>
		<th>onMaxOffset</th>
		<th>currentLimit</th>
		<th>safetyFactor</th>
		<th>startState</th>
		<th></th>
		<th></th>
	 </tr>";

// loop through results of database query, displaying them in the table
for ($i = $start; $i < $end; $i++)
{
// make sure that PHP doesn't try to show results that don't exist
if ($i == $total_results) { break; }

// find specific row
$result->data_seek($i);
$row = $result->fetch_row();

// echo out the contents of each row into a table
echo "<tr>";
echo '<td>' . $row[0] . '</td>';
echo '<td>' . $row[1] . '</td>';
echo '<td>' . $row[2] . '</td>';
echo '<td>' . $row[3] . '</td>';
echo '<td>' . $row[4] . '</td>';
echo '<td>' . $row[5] . '</td>';
echo '<td>' . $row[6] . '</td>';
echo '<td>' . $row[7] . '</td>';
echo '<td>' . $row[8] . '</td>';
echo '<td>' . $row[9] . '</td>';
echo '<td>' . $row[10] . '</td>';
echo '<td>' . $row[11] . '</td>';
echo '<td>' . $row[12] . '</td>';
echo '<td><a href="multitesterproduct_records.php?id=' . $row[0] . '">Edit</a></td>';
echo '<td><a href="multitesterproduct_delete.php?id=' . $row[0] . '">Delete</a></td>';
echo "</tr>";
}

// close table>
echo "</table>";
}
else
{
echo "No results to display!";
}
}
// error with the query
else
{
echo "Error: " . $mysqli->error;
}

// close database connection
$mysqli->close();

?>

<a href="multitesterproduct_records.php">Add New Record</a>
</body>
</html>
</html>
