<?php session_start();?>
<!DOCTYPE html>
<?php
/*
 TODO
 - cleanup frontend
 */
include "./scripts/functions.php";

$_SESSION["spacing"] = 10;
$_SESSION["hei"] = $_GET['Height'];
$_SESSION["wid"] = $_GET['Width'];
$_SESSION["len"] = $_GET['Length'];
$_SESSION["mat"] = $_GET['Thickness']/10;
$_SESSION["dowel"] = $_GET['DowelThickness']/10;
$_SESSION["langlen"] = $_SESSION["dowel"] * 5;
$_SESSION["langhei"] = $_SESSION["mat"] + 2 * $_SESSION["dowel"] ;
if (isset($_GET["gen"])) {
  $_SESSION["gen"] = $_GET["gen"];
}

// getting pieces superficies
$order = array(
  "bot" => $_SESSION["len"] * $_SESSION["wid"],
  "c1" => 2*($_SESSION["len"]*$_SESSION["hei"]),
  "c2" => 2*($_SESSION["wid"]*$_SESSION["hei"])
);

// sort them
arsort($order);
foreach ($order as $key=>$val) {
  if ($key == "bot") {
    $order[$key] = array($_SESSION["len"],$_SESSION["wid"]);
  } else if ($key == "c1") {
    $order[$key] = array($_SESSION["len"],$_SESSION["hei"]);
  } else {
    $order[$key] = array($_SESSION["wid"],$_SESSION["hei"]);
  }
}
$c1=array_keys($order)[0];
$c2=array_keys($order)[1];
$c3=array_keys($order)[2];

if (isset($_GET["dl"])) {
  downloadSvg();
  session_destroy();
}
?>

<html>
	<head>
		<title>SVGbox</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="svgbox.css">
	</head>
	<body>
		<h1>Your svg box in seconds !</h1>
			<div id="content">
				<nav>
					<form action="<?php $_SERVER['SCRIPT_NAME'] ?>" method="GET">
					<div class="input"><label for="Length">Length (cm)</label><br>
						<input type="text" name="Length" <?php if (isset($_GET['Length'])) { echo "value=".$_SESSION["len"]; } ?>><br></div>
						<div class="input"><label for="Width">Width (cm)</label><br>
						<input type="text" name="Width" <?php if (isset($_GET['Width'])) { echo "value=".$_SESSION["wid"]; } ?>><br></div>
						<div class="input"><label for="Height">Height (cm)</label><br>
						<input type="text" name="Height" <?php if (isset($_GET['Height'])) { echo "value=".$_SESSION["hei"]; } ?>><br></div>
						<div class="input"><label for="Thickness">Material Thickness (mm)</label><br>
						<input type="text" name="Thickness" <?php if (isset($_GET['Thickness'])) { echo "value=".$_SESSION["mat"]*10; } ?>><br></div>
						<div class="input"><label for="DowelThickness">Dowel Thickness (mm)</label><br>
						<input type="text" name="DowelThickness" <?php if (isset($_GET['Height'])) { echo "value=".$_SESSION["dowel"]*10; } ?>><br></div>
						<div id="download"><input type="submit" name="gen" value="Preview Box"><input type="submit" name="dl" value="Download"></div>
					</form>
				</nav>
				<div id="preview">
					
<?php
if (isset($_SESSION['gen'])) {
  echo makesvg(5);
}
?>
				</div>
                        </div>
        </body>
</html>
