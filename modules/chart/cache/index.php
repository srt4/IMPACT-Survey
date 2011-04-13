<?php 
// Google Chart Cacher 

// Accepts an FSCS id, and then places the outputted png from Google Charts
// into a directory of the format "cache/$FSCS/$Chart_Title.png"

$url    = $_SERVER['REQUEST_URI']; 

$parts  = parse_url($url); 

$query  = $parts['query']; 
$md5 = md5($query); 


//$image = @file_get_contents('cache/'.$md5.'.png'); 

$fscs = $_REQUEST['fscs'];
$title_pre = $_REQUEST['chtt'];
$title = str_replace(" ","_",$title_pre);

$dir = "cache/" . $fscs;

$image = @file_get_contents($dir . '/' . $title . '.png');

if (!is_dir($dir)) {
	mkdir($dir);
}

if(!$image) { 
        $image = @file_get_contents("http://chart.apis.google.com/chart?". 
$query); 
        $handle = fopen ('cache/' . $fscs . '-' . $title . '.png', "w"); 
        fwrite($handle, $image); 
        fclose($handle); 
} 

header("Content-Type: image/png"); 
echo $image; 
?> 
