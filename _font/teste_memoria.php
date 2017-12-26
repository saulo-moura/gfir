<?php

require_once '../configuracao.php';

function echo_memory_usage() { 
	$mem_usage = memory_get_usage(true); 
	echo convert($mem_usage);
	
	/*
	if ($mem_usage < 1024) 
		echo $mem_usage." bytes"; 
	elseif ($mem_usage < 1048576) 
		echo round($mem_usage/1024,2)." kilobytes"; 
	else 
		echo round($mem_usage/1048576,2)." megabytes"; 
	*/
		
	echo "<br/>"; 
} 

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

p(echo_memory_usage());

ini_set('memory_limit', '-1');

$sql = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non, facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam, orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus. Fusce mi pede, tempor id, cursus ac, ullamcorper nec, enim. Sed tortor. Curabitur molestie. Duis velit augue, condimentum at, ultrices a, luctus ut, orci. Donec pellentesque egestas eros. Integer cursus, augue in cursus faucibus, eros pede bibendum sem, in tempus tellus justo quis ligula. Etiam eget tortor. Vestibulum rutrum, est ut placerat elementum, lectus nisl aliquam velit, tempor aliquam eros nunc nonummy metus. In eros metus, gravida a, gravida sed, lobortis id, turpis. Ut ultrices, ipsum at venenatis fringilla, sem nulla lacinia tellus, eget aliquet turpis mauris non enim. Nam turpis. Suspendisse lacinia. Curabitur ac tortor ut ipsum egestas elementum. Nunc imperdiet gravida mauris.';

$vet = Array();

for ($tp = 0; $tp <= 1000000000000000; $tp++) {
	$vet[] = $sql;
}

p(echo_memory_usage());

echo 'Fim..';