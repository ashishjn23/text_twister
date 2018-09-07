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
    $racki[] = get_twist();
    //print_r($racki[0]);
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    print_r($racki[0][119]);
    echo "       words:";
    for($i = 0; $i < 120; $i++){
        $a = $racki[0][$i];
        print_r($a);
        $query = "select words from RACKS where RACK='$a'";
        $statement = $dbhandle->prepare($query);
        //$statement -> bindValue(':x',$a,SQLITE3_TEXT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($results);
        print_r($results[0][words]);
        echo "     ";
    }
    //header('HTTP/1.1 200 OK');
    //header('Content-Type: application/json');
    //echo json_encode($results);
};
start();

?>