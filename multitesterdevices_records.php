<?php
//modified from Benjamin Falk's framework at http://www.killersites.com/community/index.php?/topic/3064-basic-php-system-view-edit-add-delete-records-with-mysqli/

/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($description = '', $error = '', $device_id = '')
{ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/view.css" />
<title>
<?php if ($device_id != '') { echo "Edit Record"; } else { echo "New Record"; } ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php include 'header.php';?>
<h1 class="recordTitle"><?php if ($device_id != '') { echo "Edit Record"; } else { echo "New Record"; } ?></h1>
<?php if ($error != '') {
echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
. "</div>";
} ?>

<form class="recordForm" action="" method="post">
<div>
<?php if ($device_id != '') { ?>
<input type="hidden" name="device_id" value="<?php echo $device_id; ?>" />
<p>device_id: <?php echo $device_id; ?></p>
<?php } ?>

<strong>description: *</strong> <input type="text" name="description"
value="<?php echo $description; ?>"/><br/>
<p>* required</p>
<input type="submit" name="submit" value="Submit" />
</div>
</form>
</body>
</html>

<?php }



/*

EDIT RECORD

*/
// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['device_id']))
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// make sure the 'id' in the URL is valid
if (is_numeric($_POST['device_id']))
{
// get variables from the URL/form
$device_id = $_POST['device_id'];
$description = htmlentities($_POST['description'], ENT_QUOTES);


// check that firstname and lastname are both not empty
if ($description == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($description, $error, $device_id);
}
else
{
// if everything is fine, update the record in the database
if ($stmt = $mysqli->prepare("UPDATE multitester_devices SET description = '$description' WHERE device_id=$device_id"))
{
//$stmt->bind_param("si", $description, $device_id);
$stmt->execute();
$stmt->close();
}
// show an error message if the query has an error
else
{
echo "ERROR: could not prepare update SQL statement.";
}

// redirect the user once the form is updated
header("Location: multitesterdevices_view.php");
}
}
// if the 'id' variable is not valid, show an error message
else
{
echo "Error!";
}
}
// if the form hasn't been submitted yet, get the info from the database and show the form
else
{
// make sure the 'id' value is valid
if (is_numeric($_GET['device_id']) && $_GET['device_id'] > 0)
{
// get 'id' from URL
$device_id = $_GET['device_id'];

// get the recod from the database
if($stmt = $mysqli->prepare("SELECT device_id,description FROM multitester_devices WHERE device_id=?"))
{
$stmt->bind_param("i", $device_id);
$stmt->execute();

$stmt->bind_result($device_id, $description);
$stmt->fetch();

// show the form
renderForm($description, NULL, $device_id);

$stmt->close();
}
// show an error if the query has an error
else
{
echo "Error: could not prepare SQL statement";
}
}
// if the 'id' value is not valid, redirect the user back to the view.php page
else
{
header("Location: multitesterdevices_view.php");
}
}
}



/*

NEW RECORD

*/
// if the 'id' variable is not set in the URL, we must be creating a new record
else
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// get the form data
$description = htmlentities($_POST['description'], ENT_QUOTES);


// check that firstname and lastname are both not empty
if ($description == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($description, $error);
}
else
{
// insert the new record into the database
if ($stmt = $mysqli->prepare("INSERT multitester_devices (description) VALUES (?)"))
{
$stmt->bind_param("s", $description);
$stmt->execute();
$stmt->close();
}
// show an error if the query has an error
else
{
echo "ERROR: Could not prepare SQL statement.";
}

// redirec the user
header("Location: multitesterdevices_view.php");
}

}
// if the form hasn't been submitted yet, show the form
else
{
renderForm();
}
}

// close the mysqli connection
$mysqli->close();
?>
