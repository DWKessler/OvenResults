<!DOCTYPE html>
<html>
  <head>
    <!-- Pullin the stylesheets and jquery -->
    <link rel="stylesheet" href="css/results.css" />
    <script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="jquery.stickytableheaders.min.js" type="text/javascript" charset="utf-8"></script>
    <title>Oven Results</title>
  </head>
  <body>
    <!-- Pull in the header file -->
    <?php include 'header.php';?>

    <!-- Create a table, which will be filled using javascript -->
    <span class="tableContainer">
      <table id="OvenTable" class="OvenTable" border="1" cellpadding="2">
        <tbody id="OvenBody">
        </tbody>
      </table>
    </span>

    <!-- This javascript fills the above tableContainer with rows/columns/data -->
    <script type="text/javascript" src="resultsScript.js"></script>
  </body>
</html>
