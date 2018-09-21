<?php
$dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
if (!$dbhandle) die ($error);
$query = "create table if not exists word (rack_id string primary key, words text, ctr3 integer, ctr4 integer, ctr5 integer, ctr6 integer, ctr7 integer)";
$statement = $dbhandle->prepare($query);
$statement->execute();

$query1 = "delete from word";
$statement = $dbhandle->prepare($query1);
$statement->execute();

$a1 = array(1,2,3,4,5);
$str1 = "AEIPRST";
$str2 = "ADE@@asdfkjashdf@@anskdjghlaskjdgh@@sdfgjhlksdjfghl";
$query2 = "insert into word (rack_id, words, ctr3, ctr4, ctr5, ctr6, ctr7) values ( '$str1' , '$str2', '$a1[0]' , '$a1[1]' , '$a1[2]' , '$a1[3]' , '$a1[4]');";

$statement = $dbhandle->prepare($query2);
$statement->execute();
$l = "4";
$query3 = "update word set ctr4 = ctr4 - 1 where rack_id = 'AEIPRST'";
$statement = $dbhandle->prepare($query3);
$statement->execute();


?>