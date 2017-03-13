<!DOCTYPE html>
<html>
  <head>
    <!-- Pull in the stylesheet -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/status.css" />
    <title>Oven Status</title>
  </head>
  <body>
    <!-- Pull in the header file -->
    <?php include 'header.php';?>

    <!-- This creates a table that is later filled using javascript -->
    <table id="OvenTable"  border="1" cellpadding="2"></table>

    <!-- This javascript adds rows/columns/data/color-highlighting to the above OvenTable -->
    <script type="text/javascript" src="statusScript.php"></script>
  </body>
</html>
