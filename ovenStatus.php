<!DOCTYPE html>
<html>
  <head>
    <title>Oven Status</title>
  </head>

  <body>
    <?php include 'header.php';?>

    <style>
      #OvenTable {
        border:1px solid #C0C0C0;
        border-collapse:collapse;
        padding:5px;
        width: 100%;
        font-size: 2vw;
        text-align: center;
        font-weight: bold;
      }
      #OvenTable th {
        border:1px solid #C0C0C0;
        padding:5px;
        background:#F0F0F0;
      }
      #OvenTable td {
        border:1px solid #C0C0C0;
        padding:5px;
      }
    </style>

    <table id="OvenTable"  border="1" cellpadding="2"></table>

    <script type="text/javascript" src="statusScript.php"></script>

  </body>

</html>
