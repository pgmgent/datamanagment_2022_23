<?php
include 'libs/db.php';
include 'models/Course.php';

$selected_teacher = $_GET['teacher'] ?? '';

$courseModel = new Course();

$courses = $courseModel->getAll($selected_teacher);


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