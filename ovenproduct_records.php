<?php
//modified from Benjamin Falk's framework at http://www.killersites.com/community/index.php?/topic/3064-basic-php-system-view-edit-add-delete-records-with-mysqli/

/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($product = '', $FL ='', $FH ='', $NH ='', $NL ='', $error = '', $id = '')
{ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/view.css" />
<title>
<?php if ($id != '') { echo "Edit Record"; } else { echo "New Record"; } ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
  <?php include 'header.php';?>
<h1 class="recordTitle"><?php if ($id != '') { echo "Edit Record"; } else { echo "New Record"; } ?></h1>
<?php if ($error != '') {
echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
. "</div>";
} ?>

<form class="recordForm" action="" method="post">
<div>
<?php if ($id != '') { ?>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<p>ID: <?php echo $id; ?></p>
<?php } ?>

<strong>product: *</strong> <input type="text" name="product"
value="<?php echo $product; ?>"/><br/>
<strong>FL: *</strong> <input type="text" name="FL"
value="<?php echo $FL; ?>"/><br/>
<strong>FH: *</strong> <input type="text" name="FH"
value="<?php echo $FH; ?>"/><br/>
<strong>NH: *</strong> <input type="text" name="NH"
value="<?php echo $NH; ?>"/><br/>
<strong>NL: *</strong> <input type="text" name="NL"
value="<?php echo $NL; ?>"/>
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
if (isset($_GET['id']))
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// make sure the 'id' in the URL is valid
if (is_numeric($_POST['id']))
{
// get variables from the URL/form
$id = $_POST['id'];
$product = htmlentities($_POST['product'], ENT_QUOTES);
$FL = htmlentities($_POST['FL'], ENT_QUOTES);
$FH = htmlentities($_POST['FH'], ENT_QUOTES);
$NH = htmlentities($_POST['NH'], ENT_QUOTES);
$NL = htmlentities($_POST['NL'], ENT_QUOTES);

// check that firstname and lastname are both not empty
if ($product == '' || $FL == '' || $FH == '' || $NH == '' || $NL == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($product, $FL, $FH, $NH, $NL, $error, $id);
}
else
{
// if everything is fine, update the record in the database
if ($stmt = $mysqli->prepare("UPDATE ovenshifter_products SET product = ?, FL = ?, FH = ?, NH = ?, NL = ?
WHERE id=?"))
{
$stmt->bind_param("sssssi", $product, $FL, $FH, $NH, $NL, $id);
$stmt->execute();
$stmt->close();
}
// show an error message if the query has an error
else
{
echo "ERROR: could not prepare SQL statement.";
}

// redirect the user once the form is updated
header("Location: ovenproduct_view.php");
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
if (is_numeric($_GET['id']) && $_GET['id'] > 0)
{
// get 'id' from URL
$id = $_GET['id'];

// get the recod from the database
if($stmt = $mysqli->prepare("SELECT id,product,FL,FH,NH,NL FROM ovenshifter_products WHERE id=?"))
{
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result($id, $product, $FL, $FH, $NH, $NL);
$stmt->fetch();

// show the form
renderForm($product, $FL, $FH, $NH, $NL, NULL, $id);

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
header("Location: ovenproduct_view.php");
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
$product = htmlentities($_POST['product'], ENT_QUOTES);
$FL = htmlentities($_POST['FL'], ENT_QUOTES);
$FH = htmlentities($_POST['FH'], ENT_QUOTES);
$NH = htmlentities($_POST['NH'], ENT_QUOTES);
$NL = htmlentities($_POST['NL'], ENT_QUOTES);

// check that firstname and lastname are both not empty
if ($product == '' || $FL == '' || $FH == '' || $NH == '' || $NL == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($product, $FL, $FH, $NH, $NL, $error);
}
else
{
// insert the new record into the database
if ($stmt = $mysqli->prepare("INSERT ovenshifter_products (product, FL, FH, NH, NL) VALUES (?, ?, ?, ?, ?)"))
{
$stmt->bind_param("sssss", $product, $FL, $FH, $NH, $NL);
$stmt->execute();
$stmt->close();
}
// show an error if the query has an error
else
{
echo "ERROR: Could not prepare SQL statement.";
}

// redirec the user
header("Location: ovenproduct_view.php");
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
