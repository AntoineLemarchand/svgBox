<!DOCTYPE html>
<?php

/*
 * TODO
 * - Régler orientation des pièces
 * - Ajouter les trous de dowel au maketongue()
 * - download button
 * - cleanup code
 * - cleanup frontend
 */

$spacing = 10;
$hei = $_GET['Height'];
$wid = $_GET['Width'];
$len = $_GET['Length'];
$mat = $_GET['Thickness']/10;
$dowel = $_GET['DowelThickness']/10;
$bsize = $_GET['BitSize']/10;
$langlen = $dowel * 5;
$langhei = $mat + 2 * $dowel ;

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

function maketongue($side="horizontal", $way=1) {
  global $langhei,$langlen,$dowel;
  $langheight = $langhei*$way;
  $langlength = $langlen*$way;
  if ($side=="horizontal") {
    return "
      q 0,".$langheight." ".-($langlength*.4).",".$langheight." 
      l ".-($langlength*.2).",0 
      q ".-($langlength*.4).",0 ".-($langlength*.4).",".-$langheight."";
  } else {
    return "
      q ".$langheight.",0 ".$langheight.",".($langlength*.4)." 
      l 0,".($langlength*.2)."
      q 0,".($langlength*.4)." ".-$langheight.",".($langlength*.4)."";
  }
}

function makehole($side="horizontal") {
  global $mat, $langlen;
  if ($side=="horizontal") {
    return "
      l $langlen,0
      l 0,$mat
      l ".-$langlen.",0
      l 0,".-$mat."";
  } else {
    return "
      l ".$mat.",0
      l 0,".$langlen."
      l ".-$mat.",0
      l 0,".-$langlen."";
  }
}

function makeFace($face,$x,$y,$l1,$l2) {
  global $langlen,$langhei,$mat;
    $roomX = ($l1-2*$langlen)/$l1;
    $roomY = ($l2-2*$langlen)/$l2;
  if ($face=="c1") {
    echo "<path d='M ".$x.",".$y."
      l ".$l1.",0 l 0,".($l2*$roomY*.3)."
      ".maketongue("vertical",1)."
      l 0,".($l2*$roomY*.4)."
      ".maketongue("vertical",1)."
      l 0,".($l2*$roomY*.3)." l ".-($l1*$roomX*.3).",0
      ".maketongue("horizontal",1)."
      l ".-($l1*$roomX*.4).",0
      ".maketongue("horizontal",1)."
      l ".-($l1*$roomX*.3).",0 l 0,".-($l2*$roomY*.3)."
      ".maketongue("vertical",-1)."
      l 0,".-($l2*$roomY*.4)."
      ".maketongue("vertical",-1)."
      L ".$x.",".$y."
      ' stroke='black' stroke-width='1' fill='none' \n/>";
  } else if ($face=="c2") {
    echo "<path d='M ".$x.",".$y."
      l ".$l1.",0
      l 0,".$l2."
      l ".-(($l1*$roomX)*.3).",0
      ".maketongue("horizontal",1)."
      l ".-(($l1*$roomX)*.4).",0
      ".maketongue("horizontal",1)."
      l ".-(($l1*$roomX)*.3).",0
      l 0,".-$l2."
      M ".($x+($l1*$roomX)*.1).",".($y+($l2*$roomY)*.3)."
      ".makehole("vertical")."
      M ".($x+$l1-($l1*$roomX)*.1-$mat).",".($y+($l2*$roomY)*.3)."
      ".makehole("vertical")."
      M ".($x+($l1*$roomX)*.1).",".($y+$l2-($l2*$roomY)*.3-$langlen)."
      ".makehole("vertical")."
      M ".($x+$l1-($l1*$roomX)*.1-$mat).",".($y+$l2-($l2*$roomY)*.3-$langlen)."
      ".makehole("vertical")."
      ' stroke='black' stroke-width='1' fill='none' \n/>";
  } else {
    echo "<path d='M ".$x.",".$y."
      l ".$l1.",0
      l 0,".$l2."
      l ".-$l1.",0
      l 0,".-$l2."
      M ".($x+($l1*$roomX)*.1).",".($y+($l2*$roomY)*.3)."
      ".makehole("vertical")."
      M ".($x+$l1-($l1*$roomX)*.1-$mat).",".($y+($l2*$roomY)*.3)."
      ".makehole("vertical")."
      M ".($x+($l1*$roomX)*.1).",".($y+$l2-($l2*$roomY)*.3-$langlen)."
      ".makehole("vertical")."
      M ".($x+$l1-($l1*$roomX)*.1-$mat).",".($y+$l2-($l2*$roomY)*.3-$langlen)."
      ".makehole("vertical")."
      M ".($x+($l1*$roomX)*.3).",".($y+($l2*$roomY)*.1)."
      ".makehole("horizontal")."
      M ".($x+$l1-($l1*$roomX)*.3-$langlen).",".($y+($l2*$roomY)*.1)."
      ".makehole("horizontal")."
      M ".($x+($l1*$roomX)*.3).",".($y+$l2-($l2*$roomY)*.1-$mat)."
      ".makehole("horizontal")."
      M ".($x+$l1-($l1*$roomX)*.3-$langlen).",".($y+$l2-($l2*$roomY)*.1-$mat)."
      ".makehole("horizontal")."

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
						<input type="text" name="Thickness" <?php if (isset($_GET['Thickness'])) { echo "value=".$mat*10; } ?>><br></div>
						<div class="input"><label for="DowelThickness">Dowel Thickness (mm)</label><br>
						<input type="text" name="DowelThickness" <?php if (isset($_GET['Height'])) { echo "value=".$dowel*10; } ?>><br></div>
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
    makeFace($c1,$spacing,$spacing,$order[$c1][0],$order[$c1][1]);
    for ($i=0;$i<2;$i++) {
      makeFace($c2,$spacing*2 + $order[$c1][0],$spacing+$i*($order[$c2][1]+$spacing),$order[$c2][0],$order[$c2][1]);
      if (2*($order[$c2][1]+$spacing) >= (2*($order[$c1][1]+$spacing))) {
        makeFace($c3,$spacing,$spacing,$order[$c3][0],$order[$c3][1]);
      } else {
        makeFace($c3,$spacing*2 + $order[$c1][0],$spacing+2*($order[$c2][1]+$spacing)+$i*($order[$c3][1]+$spacing),$order[$c3][0],$order[$c3][1]);
        }
    }
  
  } else if ($c2 == "bot") {
    for ($i=0;$i<2;$i++) {
      makeFace($c1,$spacing,$spacing+($spacing+$order[$c1][1])*$i,$order[$c1][0],$order[$c1][1]);   
      if (2*($order[$c2][1]+$spacing) >= (2*($order[$c1][1]+$spacing))) {
	makeFace($c3,$spacing+$i*($spacing+$order[$c3][0]),$spacing+2*($order[$c1][1]+$spacing),$order[$c3][0],$order[$c3][1]);
      } else {
	makeFace($c3,$spacing*2 + $order[$c1][0],$spacing+2*($order[$c2][1]+$spacing)+$i*($order[$c3][1]+$spacing),$order[$c3][0],$order[$c3][1]);
      }
    }
    makeFace($c2,$spacing*2+$order[$c1][0],$spacing,$order[$c2][1],$order[$c2][0]);
  } else {
    for ($i=0;$i<2;$i++) {
      makeFace($c1,$spacing,$spacing+($spacing+$order[$c1][1])*$i,$order[$c1][0],$order[$c1][1]);
      makeFace($c2,$order[$c1][0]+2*$spacing,$spacing + ($order[$c2][1]+$spacing)*$i,$order[$c2][0],$order[$c2][1]);
    }
    if (2*($order[$c2][1]+$spacing) >= (2*($order[$c1][1]+$spacing))) {
      makeFace($c3,$spacing,$spacing+($order[$c1][0]+$spacing)*2,$order[$c3][0],$order[$c3][1]);
    } else {
      makeFace($c3,$order[$c1][0]+2*$spacing,$spacing+2*($order[$c2][1]+$spacing),$order[$c3][0],$order[$c3][1]);
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
