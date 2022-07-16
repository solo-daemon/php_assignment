<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    echo "hello";
    $stud=$_POST["stud"];
    $comm=$_POST["comm"];

    $ass=$_POST["ass"];
    $action=$_POST['action'];
    if($action=="iteration"){
          $status=$_POST['status']+1;
    }else if($action=="accept"){
        $status=-1;
    }
    include './connect.php';
    $sql='update assignmet set '.$stud.'_status='.$status.', '.$stud.'_comment="'.$comm.'"  where title="'.$ass.'";';
    echo $sql;
   $result=$conn->query($sql);
}
?>