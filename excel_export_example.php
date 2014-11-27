 <?PHP
  $data = array(
    array("firstname" => "Dwarikesh", "lastname" => "Sharma", "age" => 25),
    array("firstname" => "Kalicharan", "lastname" => "Singh", "age" => 35),
    array("firstname" => "Ravendra", "lastname" => "Singh", "age" => 34),
    array("firstname" => "Tanaya", "lastname" => "Vashisth", "age" => 26),
    array("firstname" => "Deepali", "lastname" => "Kakkar", "age" => 26)
  );
 function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // file name for download
  $filename = "teacher_report_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\n";
  }

  exit;
?>