<?php
include 'libs/db.php';

$teacher = $_GET['teacher'] ?? '';

$params = [];
$sql = 'SELECT * FROM courses';

if($teacher) {
    $sql = 'SELECT * FROM courses WHERE teacher_short = :teacher';
    $params[':teacher'] = $teacher;
}
/* SQL Prepare */
$pdostmnt = $db->prepare($sql);
/* Execute */
/* !!!!!! Binden via placeholders om sql injection tegen te gaan !!!!!! */
$pdostmnt->execute($params); 
/* Fetch */
$courses = $pdostmnt->fetchAll();

$pdostmnt = $db->prepare('SELECT * FROM teachers');
$pdostmnt->execute(); 
$teachers = $pdostmnt->fetchAll();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graduaat Programmeren</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Graduaat Programmeren</h1>

    <form>
        <select name='teacher'>
            <option value="">Alle...</option>
        <?php foreach($teachers as $teacher) {
            include 'view/teacher_options.php';           
        } ?>
        </select>
    <button type="submit">Filter</button>
    </form>
    
    <?php foreach($courses as $course) {
        include 'view/course_item.php';
    } ?>
</body>
</html>