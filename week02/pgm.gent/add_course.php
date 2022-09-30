<?php
include 'libs/db.php';
$errors = [];


if(isset($_POST['name'])) {

    //csrf of Cross Site Request Forgery tegen gaan (requests vqn een ander domein blokkeren)
    if($_SERVER["HTTP_REFERER"] != "http://localhost:898/add_course.php") {
        echo 'Stop hacking';
        die();
    }


    //xss of Cross Site Scripting tegen te gaan (ervoor zorgen dat <script> </script> niet uitgevoerd kan worden)
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $name_short = filter_input(INPUT_POST, 'name_short', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    

    if ( strlen($name) > 20 ) {
        $errors[] = "Naam mag niet meer dan 20 tekens zijn.";
    }

    if ( count($errors) == 0 ) {
        $sql = 'INSERT INTO courses (name, name_short, description) VALUES (:name, :name_short, :description);';
        $pdostmnt = $db->prepare($sql);
        //bind parameters om sqlinjection tegen te gaan
        $pdostmnt->execute([
            ':name' => $name,
            ':name_short' => $name_short,
            ':description' => $description
        ]); 
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Add course</h1>
    <form method="POST">

        <?php foreach($errors as $error) {
            echo "<div class=\"alert alert-warning\">$error</div>";
        } ?>

        <div class="mb-2">
            <label for="name" class="form-label">Naam</label>
            <input class="form-control" type="text" name="name" id="name" value="<?= $name ?? ''; ?>" required>
        </div>
        <div class="mb-2">
            <label for="name_short" class="form-label">Korte benaming</label>
            <input class="form-control" type="text" name="name_short" value="<?= $name_short ?? ''; ?>" id="name_short">
        </div>
        <div class="mb-2">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description"><?= $description ?? ''; ?></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Verstuur</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>