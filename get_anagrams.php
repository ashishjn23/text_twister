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
echo $myrack;
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
    $racki[] = get_twist();
    //print_r($racki);
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
    for($i = 0; $i < 120; $i++){
        $a = $racki[i];
        $query = "select words from RACKS WHERE RACK='$a'";
        $statement = $dbhandle->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($results != NULL){
            print_r($results);
        }
    }
    
    

    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    echo json_encode($results);
};
start();

?>