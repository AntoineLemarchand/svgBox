<!DOCTYPE html>
<?php
$spacing = '20mm';
$hei = $_GET['Height'];
$wid = $_GET['Width'];
$len = $_GET['Length'];
$mat = $_GET['Thickness'];
$dowel = $_GET['DowelThickness'];
$bsize = $_GET['BitSize'];
$langlen = ($_GET['DowelThickness'] * 5)/10;
$langhei = ($_GET['DowelThickness'] * ($mat-0.5)/2)/10;

// superficie des rectangles
$order = array(
  "bot" => $len * $wid,
  "c1" => 2*($len*$hei),
  "c2" => 2*($wid*$hei)
);
// ils sont triés par leur superficie
arsort($order);
foreach ($order as $key=>$val) {
  if ($key == "bot") {
    $order[$key] = array($len,$wid);
  } else if ($key == "c1") {
    $order[$key] = array($len,$hei);
  } else {
    $order[$key] = array($wid,$hei);
  }
  rsort($order[$key]);
}
$c1=array_keys($order)[0];
$c2=array_keys($order)[1];
$c3=array_keys($order)[2];

function makeFace($face,$x,$y,$l1,$l2,$langlen,$langhei,$mat) {
    $roomX = ($l1-2*$langlen)/$l1;
    $roomY = ($l2-2*$langlen)/$l2;
  if ($face=="c1") {
    echo "<path d='M ".$x.",".$y."
      l ".$l1.",0 l 0,".($l2*$roomY*.3)."
      q ".$langhei.",0 ".$langhei.",".($langlen*.4)." l 0,".($langlen*.2)." q 0,".($langlen*.4)." ".-$langhei.",".($langlen*.4)."
      l 0,".($l2*$roomY*.4)."
      q ".$langhei.",0 ".$langhei.",".($langlen*.4)." l 0,".($langlen*.2)." q 0,".($langlen*.4)." ".-$langhei.",".($langlen*.4)."
      l 0,".($l2*$roomY*.3)." l ".-($l1*$roomX*.3).",0
      q 0,".$langhei." ".-($langlen*.4).",".$langhei." l ".-($langlen*.2).",0 q ".-($langlen*.4).",0 ".-($langlen*.4).",".-$langhei."
      l ".-($l1*$roomX*.4).",0
      q 0,".$langhei." ".-($langlen*.4).",".$langhei." l ".-($langlen*.2).",0 q ".-($langlen*.4).",0 ".-($langlen*.4).",".-$langhei."
      l ".-($l1*$roomX*.3).",0 l 0,".-($l2*$roomY*.3)."
      q ".-$langhei.",0 ".-$langhei.",".-($langlen*.4)." l 0,".-($langlen*.2)." q 0,".-($langlen*.4)." ".$langhei.",".-($langlen*.4)."
      l 0,".-($l2*$roomY*.4)."
      q ".-$langhei.",0 ".-$langhei.",".-($langlen*.4)." l 0,".-($langlen*.2)." q 0,".-($langlen*.4)." ".$langhei.",".-($langlen*.4)."
      L ".$x.",".$y."
      ' stroke='black' stroke-width='1' fill='none' \n/>";
  } else if ($face=="c2") {
    echo "<path d='M ".$x.",".$y."
      l ".$l1.",0
      l 0,".$l2."
      l ".-(($l1*$roomX)*.3).",0
      q 0,".$langhei." ".-($langlen*.4).",".$langhei." l ".-($langlen*.2).",0 q ".-($langlen*.4).",0 ".-($langlen*.4).",".-$langhei."
      l ".-(($l1*$roomX)*.4).",0
      q 0,".$langhei." ".-($langlen*.4).",".$langhei." l ".-($langlen*.2).",0 q ".-($langlen*.4).",0 ".-($langlen*.4).",".-$langhei."
      l ".-(($l1*$roomX)*.3).",0
      l 0,".-$l2."
      ' stroke='black' stroke-width='1' fill='none' \n/>";
  } else {
    echo "<path d='M ".$x.",".$y."
      l ".$l1.",0
      l 0,".$l2."
      l ".-$l1.",0
      l 0,".-$l2."
      ' stroke='black' stroke-width='1' fill='none' \n/>";
  }
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
						<input type="text" name="Length" <?php if (isset($_GET['Length'])) { echo "value=".$len; } ?>><br></div>
						<div class="input"><label for="Width">Width (cm)</label><br>
						<input type="text" name="Width" <?php if (isset($_GET['Width'])) { echo "value=".$wid; } ?>><br></div>
						<div class="input"><label for="Height">Height (cm)</label><br>
						<input type="text" name="Height" <?php if (isset($_GET['Height'])) { echo "value=".$hei; } ?>><br></div>
						<div class="input"><label for="Thickness">Material Thickness (mm)</label><br>
						<input type="text" name="Thickness" <?php if (isset($_GET['Thickness'])) { echo "value=".$mat; } ?>><br></div>
						<div class="input"><label for="DowelThickness">Dowel Thickness (mm)</label><br>
						<input type="text" name="DowelThickness" <?php if (isset($_GET['Height'])) { echo "value=".$dowel; } ?>><br></div>
						<div class="input"><input type="checkbox" name="drillMode" id="drillMode" <?php if (isset($_GET['drillMode'])) {echo "checked";} ?>><label for="drillMode">Are you planning to use a CNC?</label><br>
						<div id="option"><label for="BitSize">Bit Size (mm)</label><br>
						<input type="text" name="BitSize" <?php if (isset($_GET['BitSize'])) { echo "value=".$bsize; } ?>><br></div></div>
						<div </div>
						<div id="download"><input type="submit" name="gen" value="Preview Box"><input type="submit" name="dl" value="Download"></div>
					</form>
				</nav>
				<div id="preview">
					
                                  <svg width="100%" height="100%">
                                    <g transform="scale(3)">
<?php
if (isset($_GET['gen'])) {
  $i=0;
  if ($c1 == "bot") {
    makeFace($c1,10,10,$order[$c1][0],$order[$c1][1],$langlen,$langhei,$mat);
    for ($i=0;$i<2;$i++) {
      makeFace($c2,$order[$c1][0]+$spacing*$i+$spacing,10,$order[$c2][1],$order[$c2][0],$langlen,$langhei,$mat);
      if ($order[$c2][0] > $order[$c1][1]) {
        makeFace($c3,20,50,$order[$c3][0],$order[$c3][1],$langlen,$langhei,$mat);
      } else {
        makeFace($c3,20,50,$order[$c3][0],$order[$c3][1],$langlen,$langhei,$mat);
        }
    }
  } else {
    for ($i=0;$i<2;$i++) {
      makeFace($c1,10,$spacing +10*$i+ $order[$c1][1]*$i,$order[$c1][0],$order[$c1][1],$langlen,$langhei,$mat);
      makeFace($c2,$order[$c1][0]+$spacing*$i+10*$i+$spacing,20,$order[$c2][1],$order[$c2][0],$langlen,$langhei,$mat);
    }
    if ($order[$c2][0]+$spacing > (2*($order[$c1][1]+$langhei+$spacing))) {
      makeFace($c3,10,10,$order[$c3][0],$order[$c3][1],$langlen,$langhei,$mat);
    } else {
      makeFace($c3,$order[$c1][0]+$spacing,20+$order[$c2][0]+10,$order[$c3][0],$order[$c3][1],$langlen,$langhei,$mat);
    }
  }
}
?>
                                    </g>
                                  </svg>
				</div>
                        </div>
        </body>
</html>
