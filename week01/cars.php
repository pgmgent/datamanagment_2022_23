<?php
include 'cars/data.php';

$search = trim($_GET['car'] ?? '');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars</title>
</head>
<body>
    <h1>Carshop</h1>

    <form method="GET">
        <input type="search" name="car" value="<?= $search; ?>">
        <button type="submit">Zoek</button>
    </form>

    <?php
    foreach($cars as $car) {
        if($search == '' || strtolower($car['brand']) == strtolower($search)) {
            include 'view/car_item.php';
        }
    } 
    ?>
</body>
</html>