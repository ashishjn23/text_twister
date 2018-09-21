<?php

$ans;
$rackf;
$counters;

function initialize(){
    $GLOBALS['$ans'] = NULL;
    $GLOBALS['rackf'] = 0;
    $GLOBALS['counters'] = array(0,0,0,0,0);
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $query = "create table if not exists word (rack_id string primary key, words text, ctr3 integer, ctr4 integer, ctr5 integer, ctr6 integer, ctr7 integer)";
    $statement = $dbhandle->prepare($query);
    $statement->execute();

    $query1 = "delete from word";
    $statement = $dbhandle->prepare($query1);
    $statement->execute();
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

function start($ans){
    $racki = get_twist();
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $GLOBALS['rackf'] = $racki[119];
    
    for($i = 0; $i < 120; $i++){
        $query = "select words from RACKS where length >2 and RACK='$racki[$i]'";
        $statement = $dbhandle->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($results != NULL){
            $words[] = $results[0][words];
        }
    }
    for($j = 0; $j < count($words) ; $j++){
        $temp = explode("@@",$words[$j]);
        for($k = 0; $k < count($temp); $k++){
            $ans[] = $temp[$k];
        }
    }
    return $ans;
};

function get_counts($ans){
    for($p=0; $p < count($ans) ; $p++){
        $GLOBALS['counters'][strlen($ans[$p]) - 3] += 1;
    }
    if($GLOBALS['counters'][0] > 7 ){
        $GLOBALS['counters'][0] = 7;
    }
    if($GLOBALS['counters'][1] > 5 ){
        $GLOBALS['counters'][1] = 5;
    }
    if($GLOBALS['counters'][2] > 3 ){
        $GLOBALS['counters'][2] = 3;
    }
    if($GLOBALS['counters'][3] > 2 ){
        $GLOBALS['counters'][3] = 2;
    }
    if($GLOBALS['counters'][4] > 2 ){
        $GLOBALS['counters'][4] = 2;
    }
};

function validate($inputword, $rack){
    $flag = 0;
    $p = 0;
    $temp1 = NULL;
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $query3 = "select words from word where rack_id = '$rack'";
    $statement = $dbhandle->prepare($query3);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    if($results != NULL) {
        $words = $results[0][words];
        $temp = explode("@@",$words);
        for($j = 0; $j < count($temp) ; $j++){
            if(strtoupper($inputword) == $temp[$j]){
                $res =  "Correct";
                $flag = 1;
                break;
            }else{
                $res = "Try again!";
                $flag = 0;
            }
        }
        if($flag == 1){
            $p = 0;
            for($k = 0; $k < count($temp) ; $k++){
                if(strtoupper($inputword) != $temp[$k]){
                    $temp1[$p] = $temp[$k];
                    $p++;
                }
            }
            $temp2 = implode("@@",$temp1);

            
            if (strlen($inputword) == 3){
                $query4 = "update word set words = '$temp2' , ctr3 = ctr3 - 1 where rack_id = '$rack'";
            }elseif (strlen($inputword) == 4){
                $query4 = "update word set words = '$temp2' , ctr4 = ctr4 - 1 where rack_id = '$rack'";
            }elseif (strlen($inputword) == 5){
                $query4 = "update word set words = '$temp2' , ctr5 = ctr5 - 1 where rack_id = '$rack'";
            }elseif (strlen($inputword) == 6){
                $query4 = "update word set words = '$temp2' , ctr6 = ctr6 - 1 where rack_id = '$rack'";
            }elseif (strlen($inputword) == 7){
                $query4 = "update word set words = '$temp2' , ctr7 = ctr7 - 1 where rack_id = '$rack'";
            }
            $statement = $dbhandle->prepare($query4);
            $statement->execute();
            
            $query5 = "select ctr3, ctr4, ctr5, ctr6, ctr7 from word where rack_id = '$rack'";
            $statement = $dbhandle->prepare($query5);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            if($results != NULL){
                $ctr3 = $results[0][ctr3];
                $ctr4 = $results[0][ctr4];
                $ctr5 = $results[0][ctr5];
                $ctr6 = $results[0][ctr6];
                $ctr7 = $results[0][ctr7];
            }
        }
        $out = array('res' => $res, 'ctr3' => $ctr3, 'ctr4' => $ctr4, 'ctr5' => $ctr5, 'ctr6' => $ctr6, 'ctr7' => $ctr7);
        return $out;
    }
};


 $func = $_REQUEST["q"];
 $inputword = $_REQUEST["r"];
 $rackp = $_REQUEST["s"];
 
 $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
 if (!$dbhandle) die ($error);
 
 switch ($func){
    case "validate":
        $res = validate($inputword, $rackp);
        
        
        
        $res1 = json_encode($res);
        echo $res1;
        break;
    case "start":
        initialize();
        $GLOBALS['ans'] = start($GLOBALS['ans']);
        get_counts($GLOBALS['ans']);
        
        $wordstr = implode("@@",$ans);
        
        $query2 = "insert into word (rack_id, words, ctr3, ctr4, ctr5, ctr6, ctr7) values ( '$rackf' , '$wordstr' , '$counters[0]' , '$counters[1]' , '$counters[2]' , '$counters[3]' , '$counters[4]');";
        $statement = $dbhandle->prepare($query2);
        $statement->execute();
    
       // while($counters[0] < 7 || $counters[1] < 5 || $counters[2] < 1 || $counters[3] < 1){
        $final = array('rack' => $rackf, 'counts' => $counters, 'ans' => $ans);
        $myJSON = json_encode($final);
        echo $myJSON;
        //}
        break;
    default:
        echo json_encode("HAHA");
 }

?>