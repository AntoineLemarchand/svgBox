<!DOCTYPE html>
<?php 
$len = 20;
$wid = 90;
$hei = 120;

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


?>
<html>
<body>
<p><?php echo $c1."=".$order[$c1][0]."x".$order[$c1][1]." ".$c2."=".$order[$c2][0]."x".$order[$c2][1]." ".$c3."=".$order[$c3][0]."x".$order[$c3][1] ?></p>
<svg width="500" height="500">
<?php
  $i=0;
if (($len == $wid)&&($wid == $hei)) {
  for ($i=0;$i<3;$i++) {
    echo "<path d= '  M ".(10+$i*$len).",10 l ".$len.",0 l 0,".$len." l ".(-$len).",0  L ".(10+$i*$len).",10'  
          fill='none' stroke='black' stroke-width='1' />";
  }
  for ($i=0;$i<2;$i++) {
    echo "<path d= '  M ".(10+$i*$len).",".(10+$len)." l ".$len.",0 l 0,".$len." l ".(-$len).",0  L ".(10+$i*$len).",".(10+$len)."'  fill='none' stroke='black' stroke-width='1' />";
  }
} else {
  if ($c1 == "bot") {
    echo "<path d= '  M 10,10 l ".$order[$c1][0].",0 l 0,".$order[$c1][1]." l ".(-$order[$c1][0]).",0  L 10,10'  fill='none' stroke='black' stroke-width='1' />";
    for ($i=0;$i<2;$i++) {
      echo "<path d= '  M ".(10+$order[$c1][0]+$i*($order[$c2][1])).",10 l ".$order[$c2][1].",0 l 0,".$order[$c2][0]." l ".(-$order[$c2][1]).",0  L ".(10+$order[$c1][0]+$i*$order[$c2][1]).",10'  fill='none' stroke='black' stroke-width='1' />";
    if ($order[$c2][0] > $order[$c1][1]) {
        echo "<path d= '  M 10,".(10+$order[$c1][1]+$i*$order[$c3][1])." l ".$order[$c3][0].",0 l 0,".$order[$c3][1]." l ".(-$order[$c3][0]).",0  L 10,".(10+$order[$c1][1]+$i*$order[$c3][1])."'  fill='none' stroke='black' stroke-width='1' />";
      
    } else {
        echo "<path d= '  M ".$order[$c1][0].",".($order[$c2][0]+$i*$order[$c2][0])." l ".$order[$c3][0].",0 l 0,".$order[$c3][1]." l ".(-$order[$c3][0]).",0  L 10,".($order[$c2][0]+$i*$order[$c2][0])."'  fill='none' stroke='black' stroke-width='1' />";
      }
    }
  } else {
    for ($i=0;$i<2;$i++) {
      echo "<path d= '  M 10,".(10+$i*$order[$c1][1])." l ".$order[$c1][0].",0 l 0,".$order[$c1][1]." l ".(-$order[$c1][0]).",0  L 10,".(10+$i*$order[$c1][1])."'  fill='none' stroke='black' stroke-width='1' />";
      echo "<path d= '  M ".(10+$order[$c1][0]+$i*$order[$c2][1]).",10 l ".$order[$c2][1].",0 l 0,".$order[$c2][0]." l ".(-$order[$c2][1]).",0  L ".(10+$order[$c1][0]+$i*$order[$c2][1]).",10'  fill='none' stroke='black' stroke-width='1' />";
    }
    if ($order[$c2][0] > (2*$order[$c1][1])) {
      echo "<path d= '  M 10,".(10+2*$order[$c1][1])." l ".$order[$c3][0].",0 l 0,".$order[$c3][1]." l ".(-$order[$c3][0]).",0  L 10,".(10+2*$order[$c1][1])."'  fill='none' stroke='black' stroke-width='1' />";
      } else {
      echo "<path d= '  M ".(10+$order[$c1][0]).",".(10+$order[$c2][0])." l ".$order[$c3][1].",0 l 0,".$order[$c3][0]." l ".(-$order[$c3][1]).",0  L ".(10+$order[$c1][0]).",".(10+$order[$c2][0])."'  fill='none' stroke='black' stroke-width='1' />";
      }
  }
}
?>
  </svg>
</body>
</html>
