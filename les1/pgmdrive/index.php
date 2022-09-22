<!DOCTYPE html>
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
        <h1>PGMdrive</h1>
    <?php 
    
    $drive = scandir('drive');

    foreach($drive as $item) {
        if(strpos($item, '.') !== 0){
            include 'view/drive_item.php';
        }
    }
    
    ?>
    </div>
</body>
</html>