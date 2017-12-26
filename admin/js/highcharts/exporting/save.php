<?php
/**
 * This file is part of the exporting module for Highcharts JS.
 * www.highcharts.com/license
 * 
 *  
 * Available POST variables:
 *
 * $filename  string   The desired filename without extension
 * $type      string   The MIME type for export. 
 * $width     int      The pixel width of the exported raster image. The height is calculated.
 * $svg       string   The SVG source code to convert.
 */
ini_set('display_errors', 'On');
set_time_limit(5 * 60);

// Options
define('BATIK_PATH', 'batik-rasterizer.jar');

///////////////////////////////////////////////////////////////////////////////
ini_set('magic_quotes_gpc', 'off');

$type = $_POST['type'];
$svg = (string)$_POST['svg'];
$filename = (string)$_POST['filename'];

// prepare variables
if (!$filename) {
    echo "Invalid filename";
} else {
    if (get_magic_quotes_gpc()) {
        $svg = stripslashes($svg);
    }

    // check for malicious attack in SVG
    if (strpos($svg, "<!ENTITY") !== false || strpos($svg, "<!DOCTYPE") !== false) {
        exit("Execution is topped, the posted SVG could contain code for a malicious attack");
    }

    $tempName = md5(rand());

    $svg = base64_decode($svg);
    $svg = str_replace('http://'.$_SERVER["HTTP_HOST"], 'http://localhost', $svg);

    // allow no other than predefined types
    if ($type == 'image/png') {
        $typeString = '-m image/png';
        $ext = 'png';
    } elseif ($type == 'image/jpeg') {
        $typeString = '-m image/jpeg';
        $ext = 'jpg';
    } elseif ($type == 'application/pdf') {
        $typeString = '-m application/pdf';
        $ext = 'pdf';
    } else { // prevent fallthrough from global variables
        $ext = 'txt';
    }

    $outfile = $filename;

    if (isset($typeString)) {

        // size
        $width = '';
        if ($_POST['width']) {
            $width = (int)$_POST['width'];
            if ($width)
                $width = "-w $width";
        }

        // generate the temporary file
        if (!file_put_contents("temp/$tempName.svg", $svg)) {
            die("Couldn't create temporary file. Check that the directory permissions for
			the /temp directory are set to 777.");
        }

        // do the conversion

        $run = "jre\bin\java.exe -jar ".BATIK_PATH." $typeString -d $outfile $width temp/$tempName.svg";
        //$run = "java.exe -jar ".BATIK_PATH." $typeString -d $outfile $width temp/$tempName.svg";
        //echo $run; exit();
        $output = shell_exec($run);

        // catch error
        if (!is_file($outfile) || filesize($outfile) < 10) {
            echo "<pre>$output</pre>";
            echo "Error while converting SVG. ";
        }

        // delete it
        unlink("temp/$tempName.svg");

    // SVG can be streamed directly back
    } else {
        echo "Invalid type";
    }
}