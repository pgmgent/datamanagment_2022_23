<?php 

    require __DIR__ . '/vendor/autoload.php';

    // import the Intervention Image Manager Class
    use Intervention\Image\ImageManagerStatic as Image;

    $search = $_GET['q'] ?? '';

    $folder = 'drive/';
    $subfolder = $_GET['folder'] ?? '';
    
    if($subfolder) {
        $folder .= $subfolder . '/';
    }

    $drive = scandir($folder);

    //Check if the key 'file' exists in array
    if( isset($_FILES['file']) ) {
        //Get temp path and filename
        $tmp_name = $_FILES['file']["tmp_name"];
        $name = $_FILES['file']["name"];

        //echo "Move $tmp_name to $name";
        move_uploaded_file($tmp_name, $folder . $name);

        if(mime_content_type($folder . $name) == 'image/jpeg') { 
            $img = Image::make($folder . $name);
            $img->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($folder . $name);
        }

    }

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
    <h1><a href='/'>PGMdrive</a> <?php if($subfolder) { echo '/ ' . $subfolder; } ?></h1>

    <form method="get">
        <input type="search" name="q" value="<?= $search ?>">
        <button type="submit">Zoek</button>
    </form>

    <?php 
    foreach($drive as $item) {
        if(strpos($item, '.') !== 0){
            if( strpos($item, $search) !== false ) {
                include 'view/drive_item.php';
            }
        }
    }
    ?>
    
    <h2>Upload</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <button type="submit">Upload</button>
    </form>

</div>
</body>
</html>