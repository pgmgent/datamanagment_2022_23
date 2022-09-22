<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h1><?php echo "Hello world"; ?></h1>

<?php 
//echo phpinfo(); 
$naam = 'Dieter';
//echo "<h2>Hello $naam</h2>";
//echo '<h2>Hello ' . $naam . '</h2>';
?>

<h2>Hello <?= $naam; ?></h2>

<?php
$list = ['first', 'second', 'third'];

//print_r($list);
//var_dump($list);

foreach ($list as $key => $item) {
    echo $item;
}

for ($i = 0; $i < 10; $i++) {
    echo "<li>$i</li>";
}

while ($i < 20) {
    echo "<li>$i</li>";  
    $i++;
}


include 'cars/data.php';

foreach ($colors as $key => $color) {
    echo "<div style='background:$color'>$key => $color</div>";
}

?>

</body>
</html>