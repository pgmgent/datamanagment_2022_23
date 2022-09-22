<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Lotto</h1>

    <?php

    $numbers = [];

    do {
        $new_number = rand(1, 45);
        if( ! in_array($new_number, $numbers) ) {
            $numbers[] = $new_number;
        }
    } while ( count($numbers) < 6 );

    foreach($numbers as $number) {
        echo "<div>$number</div>";
    }

    ?>
</body>
</html>