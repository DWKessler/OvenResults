<!DOCTYPE html>
<html>
  <head>
    <!-- Pull in the stylesheets -->
    <link rel="stylesheet" href="css/header.css" />
  </head>
  <body>
    <div class="header">
        <!-- This form is the main logo -->
        <form method="get" action="index.php" class="topNav">
          <button onclick="" class="dropTitle mainNav" type="submit"><img class="logo" src="img/LogoTrans.png">Electronics Statistics</button>
        </form>
        <!-- Each of the following top level divs are hoverable titles that show dropdown menus -->
        <div onclick="" class="dropdown"><p class="dropTitle">Ovens &#x25BC</p>
          <!-- Each of the inner divs are clickable links to subpages -->
          <div onclick="" class="dropdown-content">
            <a href="ovenStatus.php">Status</a>
            <a href="ovenResults.php">Results</a>
            <!-- Temporarily removed some sections -->
            <!-- <a href="ovenruns_view.php">Runs</a> -->
            <!-- <a href="ovenproduct_view.php">Products</a> -->
            <!-- <a href="ovendevices_view.php">Devices</a> -->
          </div>
        </div>
        <!-- Some of the top level divs have a longTitle and a shortTitle that are toggled depending on the screen size -->
        <div onclick="" class="dropdown"><p class="dropTitle"><span class="longTitle">Assembly 5</span><span class="shortTitle">Assy 5</span> &#x25BC</p>
          <div onclick="" class="dropdown-content">
            <a href="chartAssembly5CPtime.php">Status</a>
            <a href="#">Blank Entry</a>
            <a href="#">Blank Entry</a>
          </div>
        </div>
        <!-- Temporarily removed some sections -->
        <!-- <div class="dropdown"><p class="dropTitle"><span class="longTitle">Base Unit Asm</span><span class="shortTitle">BU Asm</span> &#x25BC</p>
          <div class="dropdown-content">
            <a href="chartBaseUnitCP.php">Status</a>
            <a href="#">History</a>
          </div>
        </div> -->
        <div onclick="" class="dropdown"><p class="dropTitle"><span class="longTitle">Multitester</span><span class="shortTitle">Tester</span> &#x25BC</p>
          <div onclick="" class="dropdown-content">
            <!-- Temporarily removed some sections -->
            <!-- <a href="multitesterruns_view.php">Runs</a> -->
            <!-- <a href="multitesterproduct_view.php">Products</a> -->
            <a href="multitesterdevices_view.php">Devices</a>
            <a href="#">Blank Entry</a>
            <a href="#">Blank Entry</a>
          </div>
        </div>
    </div>
  </body>
</html>
