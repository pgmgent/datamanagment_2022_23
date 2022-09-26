<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Session vs Cookie</h1>
    <?php
        session_start();

        $_SESSION['name'] = 'Gilbert';
        $aantal_req = $_SESSION['aantal_req'] ?? 0;

        $_SESSION['aantal_req'] = $aantal_req+1;

        //var_dump($_SESSION);
        
        setcookie('name', 'George');

        var_dump($_COOKIE);




        //phpinfo();


    ?>
</body>
</html>