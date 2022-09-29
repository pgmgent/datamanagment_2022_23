<?php

include 'libs/db.php';

if(isset($_POST['name'])) {
    $sql = 'INSERT INTO courses (name, name_short, description) VALUES (:name, :name_short, :description);';
    $pdostmnt = $db->prepare($sql);
    $pdostmnt->execute([
        ':name' => $_POST['name'],
        ':name_short' => $_POST['name_short'] ?? '',
        ':description' => $_POST['description'] ?? ''
    ]); 
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
        <div class="mb-2">
            <label for="name" class="form-label">Naam</label>
            <input class="form-control" type="text" name="name" id="name" required>
        </div>
        <div class="mb-2">
            <label for="name_short" class="form-label">Korte benaming</label>
            <input class="form-control" type="text" name="name_short" id="name_short">
        </div>
        <div class="mb-2">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Verstuur</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>