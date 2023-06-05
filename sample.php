<?php
$i = 0;
$url = "https://pokeapi.co/api/v2/pokemon/$i";
$response = file_get_contents($url);


$value= json_decode($response, true);



echo $value['name'];

?>
