<?php

function generate_rack($n){
  $tileBag = "AAAAAAAAABBCCDDDDEEEEEEEEEEEEFFGGGHHIIIIIIIIIJKLLLLMMNNNNNNOOOOOOOOPPQRRRRRRSSSSTTTTTTUUUUVVWWXYYZ";
  $rack_letters = substr(str_shuffle($tileBag), 0, $n);
  
  $temp = str_split($rack_letters);
  sort($temp);
  return implode($temp);
};


function get_twist(){
$myrack = generate_rack(7);
$racks = [];
for($i = 0; $i < pow(2, strlen($myrack)); $i++){
	$ans = "";
	for($j = 0; $j < strlen($myrack); $j++){
		//if the jth digit of i is 1 then include letter
		if (($i >> $j) % 2) {
		  $ans .= $myrack[$j];
		}
	}
	if (strlen($ans) > 1){
  	    $racks[] = $ans;	
	}
}
$racks = array_unique($racks);
return $racks;
};

function start(){
    $racki = get_twist();
    $words="";
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    //print_r($racki[119]);
    //echo "<br>words:";
    for($i = 0; $i < 120; $i++){
        //print_r($racki[$i]);
        //print_r($a);
        $query = "select rack, words from RACKS where length >2 and RACK='$racki[$i]'";
        $statement = $dbhandle->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($results != NULL){
            //echo $results[0];
            $words .= $results[0];
        }
    }
    header('HTTP/1.1 200 OK');
    echo $racki[119];
    //header('Content-Type: application/json');
    //echo json_encode($results);
};
start();

?>