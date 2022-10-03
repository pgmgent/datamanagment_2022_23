<?php

class Course {

    public function getAll($selected_teacher = false) {
        global $db;
        
        $params = [];
        $sql = 'SELECT * FROM courses';

        if($selected_teacher) {
            $sql = 'SELECT * FROM courses WHERE teacher_short = :teacher';
            $params[':teacher'] = $selected_teacher;
        }
        /* SQL Prepare */
        $pdostmnt = $db->prepare($sql);
        /* Execute */
        /* !!!!!! Binden via placeholders om sql injection tegen te gaan !!!!!! */
        $pdostmnt->execute($params); 
        /* Fetch */
        return $pdostmnt->fetchAll();
    }

}