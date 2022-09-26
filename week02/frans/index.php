<?php
include 'data.php';
session_start();

$total_correct = $_SESSION['total_correct'] ?? 0;
$total_questions = $_SESSION['total_questions'] ?? 0;

if(isset($_POST['answer'])) {
    $answer = $_POST['answer'];
    $verb = $_POST['verb'];
    $person = $_POST['person'];
    $correct = $verbs[$verb][$person];

    $total_questions++;

    if($answer == $correct) {
        $feedback = "<div class='info correct'>Juist</div>";
        $total_correct++;
    }
    else {
        $feedback = "<div class='info fout'>Fout: $person ($verb) => $person $correct</div>";
    }

    $_SESSION['total_correct']  = $total_correct;
    $_SESSION['total_questions'] = $total_questions;
}

if(isset($_POST['config'])) {
    print_r($_POST['config']);
}

$next_verb = array_rand($verbs);
$next_person = $persons[array_rand($persons)];

?><!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frans voor Tergroenepoorte</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
<form method='post'>
    <div lang="fr">
    <?= $feedback ?? ''; ?>
    <?= $next_person ?> (<?= $next_verb ?>)
    </div>
    <input type='text' name="answer"> 
    <input type='hidden' name="verb" value="<?= $next_verb; ?>">
    <input type='hidden' name="person" value="<?= $next_person ?>">
    
    <input type="submit" value="verstuur">

    <p><?= "$total_correct / $total_questions"; ?></p>
</form>
</div>
<footer>
    <form method="post">
    <strong>Config</strong>
    <?php foreach($verbs as $verb => $conjugations) : ?>
        <label>
            <input type="checkbox" name="config[]" value="<?= $verb ?>">
            <?= $verb ?>    
        </label>
    <?php endforeach; ?>
    <input type="submit" value="save" name="update_config">
    </form>
</footer>
</body>
</html>