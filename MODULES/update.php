<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    echo "hello";
    $stud=test_input($_POST["stud"]);
    $comm=test_input($_POST["comm"]);

    $ass=test_input($_POST["ass"]);
    $action=test_input($_POST['action']);
    if($action=="iteration"){
          $status=test_input($_POST['status'])+1;
    }else if($action=="accept"){
        $status=-1;
    }
    include './connect.php';
    $sql='update assignmet set '.$stud.'_status='.$status.', '.$stud.'_comment="'.$comm.'"  where title="'.$ass.'";';
    echo $sql;
   $result=$conn->query($sql);
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>