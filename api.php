<?php
require 'vendor/autoload.php';
require 'config.php';
require 'functions.php';

$link = mysqli_connect($db_con["host"], $db_con["username"], $db_con["password"], $db_con["db"]);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
mysqli_set_charset($link, "utf8");

$doc = json_decode(file_get_contents('https://iphone.dsbcontrol.de/iPhoneService.svc/DSB/timetables/'.str_replace("\"", "", file_get_contents('https://iphone.dsbcontrol.de/iPhoneService.svc/DSB/authid/193142/5LuisenG1'))), true);
foreach($doc as $d){
  if(strcmp($d["timetabletitle"], "Aktuell keine Inhalte") == 0)
    continue;
    parse_r($d["timetableurl"], $link);
}
var_dump($doc);

mysqli_close($link);
