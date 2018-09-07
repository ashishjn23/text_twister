<?php
$str = "Helloworld@@It's a @@beautiful day.";
$a = $str;

$temp = explode("@@",$a);
print_r($temp[0][1]);
//for($j = 0; $j < count($sharray[0]) ; $j++){
  //  print_r();
//}
?>