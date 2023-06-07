<?php
$a = 1;
$b = 10 * $a;

if (isset($_POST['a'])) {
    $a = $_POST['a'];
}
if (isset($_POST['plus'])) {
    $a++;
    $b = 10 * $a;
}

if (isset($_POST['minus'])) {
    $b = 9 * ($a - 1) + 1;
    $a = $a - 1;
}

// キャッシュディレクトリを作成
if (!is_dir('cache')){
    mkdir('cache');
}

// ポケモンデータのキャッシュをゲットだぜ
$pokemonData = array();
for ($i = $b; $i < ($b + 10); $i++) {
    $cacheFile = "cache/$i.json";
    if (file_exists($cacheFile)) {
        $response = file_get_contents($cacheFile);
        $value = json_decode($response, true);
    } else {
        $url = "https://pokeapi.co/api/v2/pokemon/$i/";
        $response = file_get_contents($url);
        $value = json_decode($response, true);
        $cachedValue = json_encode($value);
        file_put_contents($cacheFile, $cachedValue);
    }
    $pokemonData[$i] = $value;
}

// ポケモンデータを表示
foreach ($pokemonData as $i => $value) {
    $name = $value['name'];
    $image = $value['sprites']['front_default'];
    $height = $value['height'];
    $weight = $value['weight'];
    $type = $value['types'];

    $type1 = $type[0]['type']['name'];

    if (isset($type[1])) {
        $type2 = $type[1]['type']['name'];
    } else {
        $type2 = "";
    }

    $conf = fopen("pokemon.tmpl", "r");
    $size = filesize("pokemon.tmpl");
    $tmpl = fread($conf, $size);
    fclose($conf);

    $tmpl = str_replace("!name!", $name, $tmpl);
    $tmpl = str_replace("!image!", $image, $tmpl);
    $tmpl = str_replace("!height!", $height, $tmpl);
    $tmpl = str_replace("!weight!", $weight, $tmpl);
    if ($type2 !== "") {
        $tmpl = str_replace("!type!", $type1 . "/" . $type2, $tmpl);
    } else {
        $tmpl = str_replace("!type!", $type1, $tmpl);
    }

    echo $tmpl;
    echo '<form action="get_pokemon_data.php" method="POST">
        <input type="submit" name="details" value="details">
        </form>';
}

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        
    </body>
    </html>

    <?php
 ?>

 <form action="" method="POST">
     <input type="hidden" name="a" value="<?=$a?>">
     <input type="submit" name="minus" value="前へ">
     <input type="submit" name="plus" value="次へ">
    
 </form>
 <?=$a?>

