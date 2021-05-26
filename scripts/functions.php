<?php
function isHorizontal($val) {
  if ($val=="horizontal") {
    return 1;
  }
}

function makehole($side="horizontal", $way=1) {
  if (isHorizontal($side)) {
    return "
      l ".$_SESSION["langlen"].",0
      l 0,".$_SESSION["mat"]."
      l ".-$_SESSION["langlen"].",0
      l 0,".-$_SESSION["mat"]."";
  } else if ($side=="roundh") {
    return "
      q ".($_SESSION["dowel"]/2).",0 ".($_SESSION["dowel"]/2).",".($_SESSION["dowel"]/2)."
      q 0,".($_SESSION["dowel"]/2)." ".-($_SESSION["dowel"]/2).",".($_SESSION["dowel"]/2)."
      q ".-($_SESSION["dowel"]/2).",0 ".-($_SESSION["dowel"]/2).",".-($_SESSION["dowel"]/2)."
      q 0,".-($_SESSION["dowel"]/2)." ".($_SESSION["dowel"]/2).",".-($_SESSION["dowel"]/2)."
      ";
  } else if ($side=="roundv") {
    return "
      q 0,".-($_SESSION["dowel"]/2)*$way." ".-($_SESSION["dowel"]/2)*$way.",".-($_SESSION["dowel"]/2)*$way."
      q ".-($_SESSION["dowel"]/2)*$way.",0 ".-($_SESSION["dowel"]/2)*$way.",".($_SESSION["dowel"]/2)*$way."
      q 0,".($_SESSION["dowel"]/2)*$way." ".($_SESSION["dowel"]/2)*$way.",".($_SESSION["dowel"]/2)*$way."
      q ".($_SESSION["dowel"]/2)*$way.",0 ".($_SESSION["dowel"]/2)*$way.",".-($_SESSION["dowel"]/2)*$way."
      ";
  } else {
    return "
      l ".$_SESSION["mat"].",0
      l 0,".$_SESSION["langlen"]."
      l ".-$_SESSION["mat"].",0
      l 0,".-$_SESSION["langlen"]."";
  }
}

function maketongue($side="horizontal", $way=1) {
  $langheight = $_SESSION["langhei"]*$way;
  $langlength = $_SESSION["langlen"]*$way;
  if (isHorizontal($side)) {
    return "
      q 0,".$langheight." ".-($_SESSION["langlen"]*.4).",".$langheight." 
      l ".-($_SESSION["langlen"]*.2).",0 
      q ".-($_SESSION["langlen"]*.4).",0 ".-($_SESSION["langlen"]*.4).",".-$langheight."
      m ".($_SESSION["langlen"]/2).",".($_SESSION["dowel"])*$way."
      ".makehole("roundh")."
      m ".-($_SESSION["langlen"]/2).",".-($_SESSION["dowel"])*$way."
      ";
  } else {
  return "
      q ".$langheight.",0 ".$langheight.",".($langlength*.4)." 
      l 0,".($langlength*.2)."
      q 0,".($langlength*.4)." ".-$langheight.",".($langlength*.4)."
      m ".($_SESSION["dowel"])*$way.",".-($langlength/2)."
      ".makehole("roundv",-$way)."
      m ".-($_SESSION["dowel"])*$way.",".($langlength/2)."
  ";
  }
}

function makeTonguedSide($len,$side="horizontal",$way=1,$num=2) {
  $lenWithoutTongues = $way*($len-$num*$_SESSION["langlen"]);
  if (isHorizontal($side)) {
    return "
      l ".$lenWithoutTongues*.3.",0
      ".maketongue("horizontal", -$way)."
      l ".$lenWithoutTongues*.4.",0
      ".maketongue("horizontal", -$way)."
      l ".$lenWithoutTongues*.3.",0
    ";
  } else {
    return "
      l 0,".$lenWithoutTongues*.3."
      ".maketongue("vertical", $way)."
      l 0,".$lenWithoutTongues*.4."
      ".maketongue("vertical", $way)."
      l 0,".$lenWithoutTongues*.3."
    ";
  }
}

function makeHoledSide($len,$side="horizontal", $way=1, $num=2) {
  if (isHorizontal($side)) {
    if ($way==1) {
      return "
	l ".$len.",0
	m ".-$_SESSION["langlen"].",".-$_SESSION["mat"]."
	m ".(($len-$num*$_SESSION["langlen"])*-.3).",".$_SESSION["langhei"]."
	".makehole("horizontal")."
	m ".($len-$num*$_SESSION["langlen"])*-.4.",0
	m ".-$_SESSION["langlen"].",0
	".makehole("horizontal")."
	m ".($len-$num*$_SESSION["langlen"])*.7.",".$_SESSION["mat"]."
	m ".(2*$_SESSION["langlen"]*$way).",".-$_SESSION["langhei"]."
      ";
    } else {
      return "
	l ".-$len.",0
	m ".($len-$num*$_SESSION["langlen"])*.3.",".-$_SESSION["langhei"]."
	".makehole("horizontal")."
	m ".($len-$num*$_SESSION["langlen"])*.4.",0
	m ".$_SESSION["langlen"].",0
	".makehole("horizontal")."
	m ".($len-$num*$_SESSION["langlen"])*-.7.",".$_SESSION["langhei"]."
	m ".-$_SESSION["langlen"].",0
      ";
    }
  } else {
    if ($way==1) {
      return "
	l 0,".$len."
	m ".-$_SESSION["langhei"].",".($len-$num*$_SESSION["langlen"])*-.3."
	m 0,".-$_SESSION["langlen"]."
	".makehole("vertical")."
	m 0,".($len-$num*$_SESSION["langlen"])*-.4."
	m 0,".-$_SESSION["langlen"]."
	".makehole("vertical")."
	m ".$_SESSION["langhei"].",".($len-$num*$_SESSION["langlen"])*.7."
	m 0,".(2*$_SESSION["langlen"])."
      ";
    } else {
      return "
	l 0,".-$len."
	m ".$_SESSION["langhei"].",".($len-$num*$_SESSION["langlen"])*.3."
	m ".-$_SESSION["mat"].",0
	".makehole("vertical")."
	m 0,".($len-$num*$_SESSION["langlen"])*.4."
	m 0,".$_SESSION["langlen"]."
	".makehole("vertical")."
	m ".-$_SESSION["langhei"].",".($len-$num*$_SESSION["langlen"])*-.7."
	m ".$_SESSION["mat"].",".-$_SESSION["langlen"]."
      ";

    }

  }
}

function makeFace($face,$x,$y,$l1,$l2) {
  if ($face=="c1") {
    return "<path d='M ".$x.",".$y."
      l ".$l1.",0 
      ".makeTonguedSide($l2,"vertical",1)."
      ".makeTonguedSide($l1,"horizontal",-1)."
      ".makeTonguedSide($l2,"vertical",-1)."
      ' stroke='black' stroke-width='.3' fill='none' \n/>";
  } else if ($face=="c2") {
    return "<path d='M ".$x.",".$y."
      l ".$l1.",0
      ".makeHoledSide($l2,"vertical",1)."
      ".makeTonguedSide($l1,"horizontal",-1)."
      ".makeHoledSide($l2,"vertical",-1)."
      ' stroke='black' stroke-width='.3' fill='none' \n/>";
  } else {
    return "<path d='M ".$x.",".$y."
      ".makeHoledSide($l1,"horizontal",1)."
      ".makeHoledSide($l2,"vertical",1)."
      ".makeHoledSide($l1,"horizontal", -1)."
      ".makeHoledSide($l2,"vertical",-1)."
      ' stroke='black' stroke-width='.3' fill='none' \n/>";
  }
}

function makesvg($size) {
  global $c1, $c2, $c3, $order;
  $return = "<svg>\n<g transform='scale(".$size.")'> ";
  if ($c1 == "bot") {
    $return .= "
      ".makeFace($c1,$_SESSION["spacing"],$_SESSION["spacing"],$order[$c1][0],$order[$c1][1])."
      ".makeFace($c2,$_SESSION["spacing"]*2 + $order[$c1][0],$_SESSION["spacing"],$order[$c2][0],$order[$c2][1])."
      ".makeFace($c2,$_SESSION["spacing"]*2 + $order[$c1][0],2*$_SESSION["spacing"]+$order[$c2][1],$order[$c2][0],$order[$c2][1])."
      ".makeFace($c3,$_SESSION["spacing"],2*$_SESSION["spacing"]+$order[$c1][1],$order[$c3][0],$order[$c3][1])."
      ".makeFace($c3,$_SESSION["spacing"],4*$_SESSION["spacing"]+$order[$c1][1],$order[$c3][0],$order[$c3][1])."
    ";
  } else if ($c2 == "bot") {
    $return .= "
      ".makeFace($c1,$_SESSION["spacing"],$_SESSION["spacing"],$order[$c1][0],$order[$c1][1])."
      ".makeFace($c1,$_SESSION["spacing"],$_SESSION["spacing"]+($_SESSION["spacing"]+$order[$c1][1]),$order[$c1][0],$order[$c1][1])."
      ".makeFace($c2,$_SESSION["spacing"]*2+$order[$c1][0],$_SESSION["spacing"],$order[$c2][1],$order[$c2][0])."";
    if (2*($order[$c2][1]+$_SESSION["spacing"]) >= (2*($order[$c1][1]+$_SESSION["spacing"]))) {
      $return .= "
	".makeFace($c3,$_SESSION["spacing"],$_SESSION["spacing"]+2*($order[$c1][1]+$_SESSION["spacing"]),$order[$c3][0],$order[$c3][1])."
	".makeFace($c3,$_SESSION["spacing"]+($_SESSION["spacing"]+$order[$c3][0]),$_SESSION["spacing"]+2*($order[$c1][1]+$_SESSION["spacing"]),$order[$c3][0],$order[$c3][1])."";
    } else {
      $return .= "
	".makeFace($c3,$_SESSION["spacing"]*2 + $order[$c1][0],$_SESSION["spacing"]+2*($order[$c2][1]+$_SESSION["spacing"]),$order[$c3][0],$order[$c3][1])."
	".makeFace($c3,$_SESSION["spacing"]*2 + $order[$c1][0],$_SESSION["spacing"]+2*($order[$c2][1]+$_SESSION["spacing"])+($order[$c3][1]+$_SESSION["spacing"]),$order[$c3][0],$order[$c3][1])."";
    }
  } else {
    $return .= "
      ".makeFace($c1,$_SESSION["spacing"],$_SESSION["spacing"],$order[$c1][0],$order[$c1][1])."
      ".makeFace($c1,$_SESSION["spacing"],$_SESSION["spacing"]+($_SESSION["spacing"]+$order[$c1][1]),$order[$c1][0],$order[$c1][1])."
      ".makeFace($c2,$order[$c1][0]+2*$_SESSION["spacing"],$_SESSION["spacing"],$order[$c2][0],$order[$c2][1])."
      ".makeFace($c2,$order[$c1][0]+2*$_SESSION["spacing"],$_SESSION["spacing"]+($_SESSION["spacing"]+$order[$c2][1]),$order[$c2][0],$order[$c2][1])."
      ".makeFace($c3,$_SESSION["spacing"],$_SESSION["spacing"]+($order[$c1][1]+$_SESSION["spacing"])*2,$order[$c3][0],$order[$c3][1])."
    ";
  }
  $return .= "\n</g>\n</svg>";
  return $return;
}

function downloadSvg() {
  $path = "tmp/box.svg";
  $content = makesvg(37.495);
  $file= fopen($path,"w");
  fwrite($file,$content);
  fclose($file);

  header("Content-Type: image/svg+xml");
  header("Vary: Accept-Encoding");
  header("Content-Disposition: attachment; filename=box.svg");
  header("Cache-Control: no-cache, must-revalidate");
  header("Expires: 0");
  header("Content-Transfer-Encoding: binary");

  ob_clean();
  flush();  
  readfile($path);
}
