<?php
$verb = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['PATH_INFO'];
$routes = explode("/", $uri);
echo $verb;
//print_r($routes);
/*for ($i=0;$i<count($routes);$i++){
  echo $routes[i][0];
};*/
//echo $routes;
if ($routes[1] == "ashish"){
  $fruit = $routes[2];
  $count = $routes[3];
  echo ("You have " . $count . " " . $fruit);
} else {
  echo "Usage: /fruit/:count_of_fruits.";
}
?>