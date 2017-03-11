<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/header.css" />
    <script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
  </head>

  <body>
    <div class="header">
        <form method="get" action="index.php" class="topNav">
          <button class="dropTitle mainNav" type="submit"><img class="logo" src="img/WakoLogoTrans.png">Wako Electronics Statistics</button>
        </form>

        <div class="dropdown"><p class="dropTitle">Ovens &#x25BC</p>
          <div class="dropdown-content">
            <a href="ovenStatus.php">Status</a>
            <a href="ovenResults.php">Results</a>
            <a href="ovenruns_view.php">Oven Runs</a>
            <a href="ovenproduct_view.php">Oven Product</a>
            <a href="ovendevices_view.php">Oven Devices</a>
          </div>
        </div>
        <div class="dropdown"><p class="dropTitle">Assembly 5 &#x25BC</p>
          <div class="dropdown-content">
            <a href="chartAssembly5CPtime.php">Status</a>
            <a href="#">History</a>
          </div>
        </div>
        <div class="dropdown"><p class="dropTitle">Base Unit Asm &#x25BC</p>
          <div class="dropdown-content">
            <a href="chartBaseUnitCP.php">Status</a>
            <a href="#">History</a>
          </div>
        </div>
        <div class="dropdown"><p class="dropTitle">Multitester &#x25BC</p>
          <div class="dropdown-content">
            <a href="multitesterruns_view.php">Multitester Runs</a>
            <a href="multitesterproduct_view.php">Multitester Products</a>
            <a href="multitesterdevices_view.php">Multitester Devices</a>
          </div>
        </div>
    </div>
  </body>

</html>
