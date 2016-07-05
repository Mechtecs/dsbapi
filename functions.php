<?php

 function parse_r($url, $link){
  $dom = new DomDocument("1.0", "utf-8");
  $dom->loadHTMLFile($url);
  $dom->preserveWhiteSpace = true;
  //get tables
  $tables = $dom->getElementsByTagName('table');
  $date = explode(" ", $dom->getElementsByTagName('div')[0]->nodeValue)[0];
  $list = $tables[2];
  $rows = $list->getElementsByTagName("tr");

  $daten = array();
  $i = -1;
  foreach($rows as $r){
    $cnt = $r->getElementsByTagName("td")->length;
    if($i==-1){
      $i++;
      continue;
    }elseif($cnt == 1){
      $i++;
      if(!(strcmp($r->nodeValue, "-----") == 0)){
        $daten[$i]["bezeichnung"] = substr($r->nodeValue, 0, 2);
        $daten[$i]["lehrer"] = explode(")", explode("(", $r->nodeValue)[1])[0];
      }else{
        $daten[$i]["bezeichnung"] = $r->nodeValue;
        $daten[$i]["lehrer"] = $r->nodeValue;
      }
    }else{
      $tmp = array();
      $tr = $r->getElementsByTagName("td");
      $tmp["klasse"] = utf8_decode($tr[0]->nodeValue);
      $tmp["stunde"] = utf8_decode($tr[1]->nodeValue);
      $tmp["art"] = utf8_decode($tr[2]->nodeValue);
      $tmp["fach"] = utf8_decode($tr[3]->nodeValue);
      $tmp["raum"] = utf8_decode(str_replace("→", "=>", $tr[4]->nodeValue));
      $tmp["text"] = utf8_decode($tr[5]->nodeValue);
      $tmp["grund"] = utf8_decode($tr[6]->nodeValue);
      $daten[$i]["vertretungen"][] = $tmp;
    }
  }
  foreach($daten as $row){
    $bez = $row["bezeichnung"];
    $lehrer = $row["lehrer"];
    mysqli_query($link, "INSERT INTO klasse (bezeichnung, lehrer) VALUES ('$bez', '$lehrer') ON DUPLICATE KEY UPDATE lehrer='$lehrer'");
    foreach($row["vertretungen"] as $r){
      $klasse = $bez;
      $stunde = $r["stunde"];
      $art = $r["art"];
      $fach = str_replace("Â ", "---", $r["fach"]);
      $raum = str_replace("Â ", "---", $r["raum"]);
      $text = str_replace("Â ", "---", $r["text"]);
      $grund = str_replace("Â ", "---", $r["grund"]);
      echo $klasse."\n";
      mysqli_query($link, 'INSERT INTO vertretung (id_klasse, stunde, datum, art, fach, raum, txt, grund, created_at) VALUES ((SELECT id FROM klasse WHERE bezeichnung = "'.$klasse.'" LIMIT 1), "'.$stunde.'", STR_TO_DATE(\''.$date.'\', \'%d.%m.%Y\'), "'.$art.'", "'.$fach.'", "'.$raum.'", "'.$text.'", "'.$grund.'", CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `art` = "'.$art.'", `fach` = "'.$fach.'", `raum` = "'.$raum.'", `txt` = "'.$text.'", `grund` = "'.$grund.'"') or die(mysqli_error($link));
      $k = mysqli_affected_rows($link);
      if($k==1){
        echo "UPDATES!!!! WHOOP!"."\n";
        mysqli_query($link, "INSERT INTO updates() VALUES ()");
      }
    }
  }
}
?>
