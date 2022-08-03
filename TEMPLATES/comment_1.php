<?php
include '../MODULES/connect.php';
if(isset($_SESSION["id"])){
      
}
else{
    session_unset();
    session_destroy();
    header('Location: http://localhost:8001/',true,301);
}

$name=$_COOKIE["student"];
$ass_id=$_COOKIE["ass_id"];
$action=$_COOKIE["action"];

$get_data='select * from submission where assignment_id='.$ass_id.' and stud_user="'.$name.'";';
$result=$conn->query($get_data);
$row=$result->fetch_array(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         *{
        box-sizing: border-box;
    }
    textarea{
        resize: none;
        outline: none;
    }
    .send{
        background-color: white;
        color: blue;
        border: 2px solid blue;
        border-radius: 5px;
        margin: 0 2%;
    }
    .send:hover{
        background-color: blue;
        color: white;
    }
    .comment{
        display: flex;
        justify-content: space-evenly;
        
    }
    .chat{
        width: 70%;
        display: flex;
        align-items: center;
        flex-direction: column;
       background-color: antiquewhite;
       padding: 1% 0;
    }
    .chat_head{
        display: flex;
        justify-content: center;
    }
    .text{
        border: 2px solid blue;
        border-radius: 5px;
    }
    .history{
        height: 300px;
        background-color: white;
        width: 90%;
        margin:1% 0;
        overflow: scroll;
        overflow-x: hidden;
    }
    .history::-webkit-scrollbar{
        display: none;
    }
    .info{
        display: flex;
        align-items: center;
        flex-direction: column;
    }
    .nav{
           display: flex;
           justify-content: space-between;
           padding: 2% 10%;
           align-items: center;
       }
       #profile_img{
           width: 10%;
           border: 2px solid red;
           border-radius: 50%;
           padding: 2% 2%;
       }#profile_img:hover{
           background-color: rgb(241, 238, 238);
       }
       #back{
             border: 2px solid blue;
             color: blue;
             background-color: white;
             border-radius: 5px;
             padding: 5% 5%;
       }#back:hover{
           color: white;
           background-color: blue;
       }
    </style>
</head>
<body>
<nav class="nav">
        <div class="left_nav">
          <img src="./user.png" alt="profile_img" id="profile_img" onclick="profile_div()">
        </div>
        <div class="right_nav">
            <button id="back" onclick="back()">Back</button>
        
        </div>
    </nav>
    <div class="info">
        <?php
        echo '
        <div>Assignment : '.$row["assignment_id"].'</div>
        <div>Student : '.$row["stud_user"].'</div>
        <div>Status : '.$row["stat"].'</div>
        <div>Action : '.$_COOKIE["action"].'</div>
        ';
        ?>
    </div>
<div class="chat_head">
    <div class="chat">
        <div class="history">
            <?php
            $sql_1='select username,comment,date from comments where stud_user="'.$name.'" and assignment_id='.$ass_id.' order by date desc;';
            $result_1=$conn->query($sql_1);
            while($row_1=$result_1->fetch_assoc()){

            
          echo ' <fieldset>
                <legend>';
                if($row_1["username"]==$_SESSION["id"]){
                    echo "You";
                }else{
                    echo $row_1["username"];
                }
                echo '</legend>
                <span>'.$row_1["comment"].' </span>
            </fieldset>';}
            ?>
        </div>
        <div class="comment">
            <textarea name="text" id="comment" cols="65" rows="2" class="text"></textarea>
            <button class="send" onclick="send()">SEND</button>
        </div>
    </div>
    
</div>

<script>
    function send(){
      const comment=document.getElementById('comment').value;
     
      document.getElementById('comment').value="";
      let xhr=new XMLHttpRequest();
      xhr.onreadystatechange=function(){
          if(this.readyState==4 && this.status==200){
          location.reload();
        }
      }
      xhr.open("POST","./add_comment.php");
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("comment="+comment);
    }
    function back(){
        window.location.assign('http://localhost:8001/TEMPLATES/dashboard_reviewer_2.php');
    }
</script> 
</body>
</html>
