 <?php

 function parse_r($url, $link){
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
  echo json_encode($daten, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  foreach($daten as $row){
    $bez = $row["bezeichnung"];
    $lehrer = $row["lehrer"];
    mysqli_query($link, "INSERT INTO klasse (bezeichnung, lehrer) VALUES ('$bez', '$lehrer') ON DUPLICATE KEY UPDATE lehrer='$lehrer'");
    foreach($row["vertretungen"] as $r){

    }
  }
}
?>
