<?php
// session_start();
include '../MODULES/connect.php';

    $name=test_input($_SESSION["id"]);
    $date=time();
    $comment=test_input($_POST["comment"]);
    $type="comment";
    $ass_id=test_input($_COOKIE["ass_id"]);
    $sql_2='insert into comments(assignment_id,comment,username,date,stud_user,type) values ('.$ass_id.',"'.$comment.'","'.$name.'",'.$date.',"'.$name.'","'.$type.'");';
    echo $sql_2;
    $conn->query($sql_2);
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
      
?>
