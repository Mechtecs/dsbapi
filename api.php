<?php
require 'vendor/autoload.php';
$doc = json_decode(file_get_contents('https://iphone.dsbcontrol.de/iPhoneService.svc/DSB/timetables/'.str_replace("\"", "", file_get_contents('https://iphone.dsbcontrol.de/iPhoneService.svc/DSB/authid/193142/5LuisenG1'))), true);
$dom = new DomDocument("1.0", "utf-8");
$dom->loadHTMLFile($doc[1]["timetableurl"]);
$dom->preserveWhiteSpace = true;
//get tables
$tables = $dom->getElementsByTagName('table');
$list = $tables[2];
$rows = $list->getElementsByTagName("tr");

$daten = array();
$i = -1;
foreach($rows as $r){
  $cnt = $r->getElementsByTagName("td")->length;
  if($cnt == 1){
    $i++;
    $daten[$i]["banner"] = $r->nodeValue;
  }else{
    $tmp = array();
    $tr = $r->getElementsByTagName("td");
    $tmp["klasse"] = $tr[0]->nodeValue;
    $tmp["stunde"] = $tr[1]->nodeValue;
    $tmp["art"] = $tr[2]->nodeValue;
    $tmp["fach"] = $tr[3]->nodeValue;
    $tmp["raum"] = $tr[4]->nodeValue;
    $tmp["text"] = $tr[5]->nodeValue;
    $tmp["grund"] = $tr[6]->nodeValue;
    $daten[$i]["vertretungen"][] = $tmp;
  }
}

var_dump($daten);
