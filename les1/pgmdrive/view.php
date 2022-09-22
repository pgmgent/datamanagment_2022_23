<?php
    $item = $_GET['item'];
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
    
    <div class="drive">
        <h1><a href='/'>PGMdrive</a> / <?= $item; ?></h1>
    <?php
    
    if(file_exists($item)) {
        $pathinfo = pathinfo($item);

        switch($pathinfo['extension']) {
            case 'txt' :
            case 'md' :
            case 'html' :
                //include 'drive/' . $item;
                echo file_get_contents($item);
                break;
            case 'jpg' :
            case 'png' :
            case 'svg' :
                echo "<img src='$item'>";
                break;
            default :
                echo $item;
        }
    } else {
        echo 'page 404';
    }
    
    ?>
    </div>
</body>
</html>