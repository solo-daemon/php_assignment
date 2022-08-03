<?php
include '../MODULES/connect.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $date=time();
    $username=test_input($_SESSION["id"]);
    $ass_id=test_input($_COOKIE["ass_id"]);
    $student=test_input($_COOKIE["student"]);
    $comment=test_input($_POST["comment"]);
    $type=test_input($_COOKIE["action"]);
    $stat=1;
    if($type=="accept"){
              $stat=-1;
    }else{
        
    }
    $sql_1='update submission set stat='.$stat.' where assignment_id='.$ass_id.' and stud_user="'.$student.'"';
    $sql_2='insert into comments(assignment_id,comment,username,date,stud_user,type) values ('.$ass_id.',"'.$comment.'","'.$username.'",'.$date.',"'.$student.'","'.$type.'");';
    $conn->query($sql_1);
    $conn->query($sql_2);
    echo $sql_1;
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>