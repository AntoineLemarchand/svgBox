<!DOCTYPE html>
<?php

/*
 TODO
 - download button
 - cleanup frontend
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

// getting pieces superficies
$order = array(
  "bot" => $len * $wid,
  "c1" => 2*($len*$hei),
  "c2" => 2*($wid*$hei)
);

// sort them
arsort($order);
foreach ($order as $key=>$val) {
  if ($key == "bot") {
    $order[$key] = array($len,$wid);
  } else if ($key == "c1") {
    $order[$key] = array($len,$hei);
  } else {
    $order[$key] = array($wid,$hei);
  }
}
$c1=array_keys($order)[0];
$c2=array_keys($order)[1];
$c3=array_keys($order)[2];

function isHorizontal($val) {
  if ($val=="horizontal") {
    return 1;
  }
}

function makehole($side="horizontal", $way=1) {
  global $mat, $langlen, $dowel;
  if (isHorizontal($side)) {
    return "
      l $langlen,0
      l 0,$mat
      l ".-$langlen.",0
      l 0,".-$mat."";
  } else if ($side=="roundh") {
    return "
      q ".($dowel/2).",0 ".($dowel/2).",".($dowel/2)."
      q 0,".($dowel/2)." ".-($dowel/2).",".($dowel/2)."
      q ".-($dowel/2).",0 ".-($dowel/2).",".-($dowel/2)."
      q 0,".-($dowel/2)." ".($dowel/2).",".-($dowel/2)."
      ";
  } else if ($side=="roundv") {
    return "
      q 0,".-($dowel/2)*$way." ".-($dowel/2)*$way.",".-($dowel/2)*$way."
      q ".-($dowel/2)*$way.",0 ".-($dowel/2)*$way.",".($dowel/2)*$way."
      q 0,".($dowel/2)*$way." ".($dowel/2)*$way.",".($dowel/2)*$way."
      q ".($dowel/2)*$way.",0 ".($dowel/2)*$way.",".-($dowel/2)*$way."
      ";
  } else {
    return "
      l ".$mat.",0
      l 0,".$langlen."
      l ".-$mat.",0
      l 0,".-$langlen."";
  }
}

function maketongue($side="horizontal", $way=1) {
  global $langhei,$langlen,$dowel;
  $langheight = $langhei*$way;
  $langlength = $langlen*$way;
  if (isHorizontal($side)) {
    return "
      q 0,".$langheight." ".-($langlength*.4).",".$langheight." 
      l ".-($langlength*.2).",0 
      q ".-($langlength*.4).",0 ".-($langlength*.4).",".-$langheight."
      m ".($langlength/2).",".($dowel)*$way."
      ".makehole("roundh")."
      m ".-($langlength/2).",".-($dowel)*$way."
      ";
  } else {
    return "
      q ".$langheight.",0 ".$langheight.",".($langlength*.4)." 
      l 0,".($langlength*.2)."
      q 0,".($langlength*.4)." ".-$langheight.",".($langlength*.4)."
      m ".($dowel)*$way.",".-($langlength/2)."
      ".makehole("roundv",-$way)."
      m ".-($dowel)*$way.",".($langlength/2)."
      ";
  }
}

function makeTonguedSide($len,$side="horizontal",$way=1,$num=2) {
  global $langlen;
  if (isHorizontal($side)) {
    return "
      l ".$way*($len - $num*$langlen)*.3.",0
      ".maketongue("horizontal", -$way)."
      l ".$way*($len - $num*$langlen)*.4.",0
      ".maketongue("horizontal", -$way)."
      l ".$way*($len - $num*$langlen)*.3.",0
    ";
  } else {
    return "
      l 0,".$way*($len- $num*$langlen)*.3."
      ".maketongue("vertical", $way)."
      l 0,".$way*($len- $num*$langlen)*.4."
      ".maketongue("vertical", $way)."
      l 0,".$way*($len- $num*$langlen)*.3."
    ";
  }
}

function makeHoledSide($len,$side="horizontal", $way=1, $num=2) {
  global $langlen, $langhei,$mat;
  if (isHorizontal($side)) {
    if ($way==1) {
      return "
	l ".$len.",0
	m ".-$langlen.",".-$mat."
	m ".(($len-$num*$langlen)*-.3).",".$langhei."
	".makehole("horizontal")."
	m ".($len-$num*$langlen)*-.4.",0
	m ".-$langlen.",0
	".makehole("horizontal")."
	m ".($len-$num*$langlen)*.7.",".$mat."
	m ".(2*$langlen*$way).",".-$langhei."
      ";
    } else {
      return "
	l ".-$len.",0
	m ".($len-$num*$langlen)*.3.",".-$langhei."
	".makehole("horizontal")."
	m ".($len-$num*$langlen)*.4.",0
	m ".$langlen.",0
	".makehole("horizontal")."
	m ".($len-$num*$langlen)*-.7.",".$langhei."
	m ".-$langlen.",0
      ";
    }
  } else {
    if ($way==1) {
      return "
	l 0,".$len."
	m ".-$langhei.",".($len-$num*$langlen)*-.3."
	m 0,".-$langlen."
	".makehole("vertical")."
	m 0,".($len-$num*$langlen)*-.4."
	m 0,".-$langlen."
	".makehole("vertical")."
	m $langhei,".($len-$num*$langlen)*.7."
	m 0,".(2*$langlen)."
      ";
    } else {
      return "
	l 0,".-$len."
	m ".$langhei.",".($len-$num*$langlen)*.3."
	m ".-$mat.",0
	".makehole("vertical")."
	m 0,".($len-$num*$langlen)*.4."
	m 0,".$langlen."
	".makehole("vertical")."
	m ".-$langhei.",".($len-$num*$langlen)*-.7."
	m ".$mat.",".-$langlen."
      ";

    }

  }
}

function makeFace($face,$x,$y,$l1,$l2) {
  if ($face=="c1") {
    echo "<path d='M ".$x.",".$y."
      l ".$l1.",0 
      ".makeTonguedSide($l2,"vertical",1)."
      ".makeTonguedSide($l1,"horizontal",-1)."
      ".makeTonguedSide($l2,"vertical",-1)."
      ' stroke='black' stroke-width='.3' fill='none' \n/>";
  } else if ($face=="c2") {
    echo "<path d='M ".$x.",".$y."
      l ".$l1.",0
      ".makeHoledSide($l2,"vertical",1)."
      ".makeTonguedSide($l1,"horizontal",-1)."
      ".makeHoledSide($l2,"vertical",-1)."
      ' stroke='black' stroke-width='.3' fill='none' \n/>";
  } else {
    echo "<path d='M ".$x.",".$y."
      ".makeHoledSide($l1,"horizontal",1)."
      ".makeHoledSide($l2,"vertical",1)."
      ".makeHoledSide($l1,"horizontal", -1)."
      ".makeHoledSide($l2,"vertical",-1)."
      ' stroke='black' stroke-width='.3' fill='none' \n/>";
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
						<div class="input"><input type="checkbox" name="drillMode" id="drillMode" <?php if (isset($_GET['drillMode'])) {echo "checked";} ?>><label for="drillMode">CNC mode</label><br>
						<div id="option"><label for="BitSize">Bit Size (mm)</label><br>
						<input type="text" name="BitSize" <?php if (isset($_GET['BitSize'])) { echo "value=".$bsize; } ?>><br></div></div>
						<div </div>
						<div id="download"><input type="submit" name="gen" value="Preview Box"><input type="submit" name="dl" value="Download"></div>
					</form>
				</nav>
				<div id="preview">
					
                                  <svg width="100%" height="100%">
                                    <g transform="scale(5)">
<?php
if (isset($_GET['gen'])) {
  $i=0;
  if ($c1 == "bot") {
    makeFace($c1,$spacing,$spacing,$order[$c1][0],$order[$c1][1]);
    for ($i=0;$i<2;$i++) {
      makeFace($c2,$spacing*2 + $order[$c1][0],$spacing+$i*($order[$c2][1]+$spacing),$order[$c2][0],$order[$c2][1]);
      makeFace($c3,$spacing,2*($spacing+$spacing*$i)+$order[$c1][1],$order[$c3][0],$order[$c3][1]);
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
      makeFace($c2,$order[$c1][0]+2*$spacing,$spacing+($spacing+$order[$c2][1])*$i,$order[$c2][0],$order[$c2][1]);
    }
    makeFace($c3,$spacing,$spacing+($order[$c1][1]+$spacing)*2,$order[$c3][0],$order[$c3][1]);
  }
}
?>
                                    </g>
                                  </svg>
				</div>
                        </div>
        </body>
</html>
