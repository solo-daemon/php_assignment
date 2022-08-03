<?php
   if($_SERVER["REQUEST_METHOD"]=="POST"){
        include './connect.php';
        $prep=$conn->prepare("insert into assignments (assignment_name,assignmet_link) values (?,?);");
        $prep->bind_param('ss',$name,$link);
        $name=    test_input( $_POST["name"]);
        $link=     test_input($_POST["link"]);
        $st='select assignmet_link from assignments where assignmet_link="'.$link.'";';
        $st_1='select assignmet_name from assignments where assignmet_name="'.$name.'";';
        $prep_1=$conn->query($st);
        $prep_2=$conn->query($st_1);
        if($prep_1->num_rows>0 || $prep_2->num_rows>0){
            if($prep_1->num_rows>0 && $prep_2->num_rows>0){
                   echo "Assignment already exists";
            }
          else  if($prep_1->num_rows>0){
              echo "Assignment already posted";
            }else{
                echo "Try another name for assignment";
            }
        }else{
            
            $prep->execute();
            echo "success";
           
        }
   }
   function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>