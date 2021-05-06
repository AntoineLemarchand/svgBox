<?php

use function PHPSTORM_META\type;

function islonger($length,$height,$width) {
	$array = array($length, $height, $width);
	$sort = sort($array);
	$short = $sort[0];
	$mid = $sort[1];
	$long = $sort[2];
	return array($long, $mid, $short);
}

$sortie = islonger(3,5,1);
echo type($sortie);
?>


