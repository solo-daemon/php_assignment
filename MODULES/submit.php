<?php
    include '../MODULES/connect.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
       $name=test_input($_POST["name"]);
       $link=test_input($_POST["link"]);
       $date=time();
       $stat=1;
       $ass_id=test_input($_POST["ass_id"]);
       $sql='select username from users where Role="Reviewer"';
       $rev=$conn->query($sql);
    //    echo $_SESSION["id"];
       
    //    $max_rev=$rev->num_rows;
    //   $reviewer="";
    //    $rev_num=rand(0,$max_rev-1);
       $i=0;
       while($row=$rev->fetch_assoc()){
            //  if($i==$rev_num){
            //   $reviewer=$row["username"];
            //   break;
            //  }else{
            //      $i++;
            //  }
            if($name==$row["username"]){
                $i++;
                break;
            }
       }
       if($i==0){
           echo "Reviewer does not exist";
       }else{
           $sql_2='select * from submission where assignment_id="'.$ass_id.'" and stud_user="'.$_SESSION["id"].'";';
           $result_2=$conn->query($sql_2);
           if($result_2->num_rows>0){
                $sql_3='update submission set rev_user="'.$name.'", link="'.$link.'" ,last_submission='.$date.' where assignment_id="'.$ass_id.'" and stud_user="'.$_SESSION["id"].'";';
                $conn->query($sql_3);
                echo "done";
           }else{
       $sql_1='insert into submission(assignment_id,stud_user,link,last_submission,rev_user,stat) values ('.$ass_id.',"'.$_SESSION["id"].'","'.$link.'",'.$date.',"'.$name.'",'.$stat.');';
       $conn->query($sql_1);
       echo "Successful";
           }
}
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
