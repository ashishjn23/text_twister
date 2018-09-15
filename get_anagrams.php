<?php

$ans[]=0;
$rackf=0;
$ctr3=0;
$ctr4=0;
$ctr5=0;
$ctr6=0;
$ctr7=0;
$counters[] = NULL;

function initialize(){
    $GLOBALS['ans'] = NULL;
    $GLOBALS['rackf'] = 0;
    $GLOBALS['ctr3'] = 0;
    $GLOBALS['ctr4'] = 0;
    $GLOBALS['ctr5'] = 0;
    $GLOBALS['ctr6'] = 0;
    $GLOBALS['ctr7'] = 0;
    $GLOBALS['counters'] = NULL;
};

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
	$ansd = "";
	for($j = 0; $j < strlen($myrack); $j++){
		//if the jth digit of i is 1 then include letter
		if (($i >> $j) % 2) {
		  $ansd .= $myrack[$j];
		}
	}
	if (strlen($ansd) > 1){
  	    $racks[] = $ansd;	
	}
}
$racks = array_unique($racks);
return $racks;
};

function start(){
    $racki = get_twist();
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $GLOBALS['rackf'] = $racki[119];
    //print_r("Rack:" . $GLOBALS['rackf'] . "<br>");
    //echo "<br>words:";
    for($i = 0; $i < 120; $i++){
        $query = "select words from RACKS where length >2 and RACK='$racki[$i]'";
        $statement = $dbhandle->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($results != NULL){
            $words[] = $results[0][words];
        }
    }
    //header('HTTP/1.1 200 OK');
    for($j = 0; $j < count($words) ; $j++){
        $temp = explode("@@",$words[$j]);
        for($k = 0; $k < count($temp); $k++){
            $GLOBALS['ans'][] = $temp[$k];
        }
    }
};

function get_counts(){
    for($p=0; $p < count($GLOBALS['ans']) ; $p++){
        if(strlen($GLOBALS['ans'][$p]) == 3){
            $GLOBALS['ctr3'] += 1;
        }elseif(strlen($GLOBALS['ans'][$p]) == 4){
            $GLOBALS['ctr4'] += 1;
        }elseif(strlen($GLOBALS['ans'][$p]) == 5){
            $GLOBALS['ctr5'] += 1;
        }elseif(strlen($GLOBALS['ans'][$p]) == 6){
            $GLOBALS['ctr6'] += 1;
        }elseif(strlen($GLOBALS['ans'][$p]) == 7){
            $GLOBALS['ctr7'] += 1;
        }
    }
    $GLOBALS['counters']=[$GLOBALS['ctr3'], $GLOBALS['ctr4'], $GLOBALS['ctr5'], $GLOBALS['ctr6'], $GLOBALS['ctr7']];
};

function validate(){
    
};

 $func = $_REQUEST["q"];
 $inputword = $_REQUEST["r"];
if($func == "start"){
    //while($ctr3 < 7 || $ctr4 < 5 || $ctr5 < 1 || $ctr6 < 1){
        initialize();
        start();
        get_counts();
    //}
    $final = array('rack' => $rackf, 'counts' => $counters);
    $myJSON = json_encode($final);
    echo $myJSON;
}elseif($func == "validate"){
    
    if($inputword == "asdfa"){
        $res = "Correct";
    }
    else{
        $res = "Try Again";
    }
    $res1 = json_encode($res);
    echo $res1;
}

?>