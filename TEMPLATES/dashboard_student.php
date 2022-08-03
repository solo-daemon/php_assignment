<?php
    session_start();
if(isset($_SESSION["id"])){
    include '../MODULES/objects.php';
    $sl=0;
}
    else{
    session_destroy();
    header("Location: http://localhost:8001/",true,301);
}
include '../MODULES/connect.php';
$id=$_SESSION["id"];
$sql_1='select * from submission inner join assignments on submission.assignment_id=assignments.assignment_id where stud_user="'.$id.'";';
$sql_2='select * from assignments where assignment_id not in (select assignments.assignment_id from submission inner join assignments on submission.assignment_id=assignments.assignment_id where stud_user="'.$id.'");';
$result_1=$conn->query($sql_1);
$result_2=$conn->query($sql_2);
$sql_3='select * from users where username="'.$_SESSION["id"].'" ;';
$result_3=$conn->query($sql_3);
$row_3=$result_3->fetch_array();
$sql_4='select username,first_name from users where Role="Reviewer";';
$result_4=$conn->query($sql_4);

// echo $sql_1;
// echo $result_1;
// echo $result_2;
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
        body{
            background-color: #fefec6;
        }
        .container{
            display: flex;
            align-items: center;
            flex-direction: column;
           padding: 7% 0;
        }
        table{
           
            width: 70%;
        }
        td{
            border-spacing: none;
            padding: 10px 10px;
            border: 1px solid black;
            background-color: rgb(245, 234, 136);
            color: purple;
        }
        a{
          color: purple;  
        }
        button{
            border-radius: 5px;
            border:2px solid rgb(26, 134, 4);
            background-color: rgb(87, 116, 7);
            color: white;
        }
        button:hover{
            background-color: rgb(157, 211, 9);
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
       #logout{
        border: 2px solid red;
             color: red;
             background-color: white;
             border-radius: 5px;
             padding: 2.5% 2.5%;
       }#logout:hover{
           color: white;
           background-color: red;
       }
       .left_nav{
           display: flex;
           width: 40%;
           justify-content: space-between;
           align-items: center;
       }
       .right_nav{
               display: flex;
               width: 20%;
               justify-content: flex-end;
               align-items: center;
       }
  

    .profile{
        position:absolute;
        left:0%;
        right:2%;
        width:10%;
       z-index:1;
       background-color:white;

       display:none;
       /* box-shadow: 2px 2px 1px black; */
    }
    .form{
        display: flex;
        flex-direction: column;
        margin: 8% 0;
        padding: 2% 6%;
        border: 2px solid black;
        background-color: rgb(245, 234, 136);
        border-radius: 5px;
    }
    #initiate{
        display: none;
        
    }
    </style>
</head>
<body>
   
<nav class="nav">
        <div class="left_nav">
          <img src="./user.png" alt="profile_img" id="profile_img" onclick="profile_div()">
        </div>
        <div class="right_nav">
            <button id="logout" onclick="logout()">Logout</button>
        </div>
        <?php
    
          echo '
          <div class="profile" id="profile">
          <div>Username : '.$row_3["username"].'</div>
          <div>Name : '.$row_3["first_name"].'</div>
          <div>Role : '.$row_3["Role"].'</div>
          </div>
  
          ';?>
    </nav>
    <div class="container">
        <table cellspacing=0>
            <tr>
                <th class="white">ass_id</th>
                <th class="green">assignment</th>
                <th class="white">rev_user</th>
                <th class="green">link</th>
                <th class="white">stat</th>
                <th class="green">last_date_submission</th>
            </tr>
       <?php
    //    echo $row
       while($row=$result_1->fetch_assoc()){
          
            echo '<tr>
            <td class="white">'.$row["assignment_id"].'</td>
            <td class="green"><a href="'.$row["assignmet_link"].'"><strong>'.$row["assignment_name"].'</strong></a></td>
            <td class="green">'.$row["rev_user"].'</td>
            <td class="white"><a href="'.$row["link"].'" target="_blank"><button>view</button></a></td>
            <td class="white">';
            if($row["stat"]=="-1"){
                echo "Accepted";
        }else{
            echo "in iteration ";
        }
            echo '</td>
            <td class="green">'.date('r',$row["last_submission"]).'</td>
            <td><button class="'.$row["assignment_id"].'" onclick="change(this.className)">give_iteration</button><button class="'.$row["assignment_id"].'"onclick="chat(this.className)">chat</button></td>
        </tr>
            ';
            
           
       }
       while($row=$result_2->fetch_assoc()){
           echo '
           <tr>
           <td class="white">'.$row["assignment_id"].'</td>
           <td class="green"><a href="'.$row["assignmet_link"].'"><strong>'.$row["assignment_name"].'</strong></a></td>
           <td class="green"></td>
           <td class="white"><a href=""></a></td>
           <td class="white">not initiated</td>
           <td class="green"><a href="#"><button id="'.$row["assignment_id"].'"onclick="initiate(this.id)">initiate</button></a></td>
           <td></td>
           </tr>
           ';
       }
       ?>
       </table>
       <div class="initiate" id="initiate">
           <form  class="form">
                    <label for="">reviewer_username</label>
                <select name="rev_name" id="rev_name">
                 <?php
                 while($row_4=$result_4->fetch_assoc()){
                echo     '<option value="'.$row_4["username"].'">'.$row_4["first_name"].'</option>';
                 }
                 ?>
                </select>
                   <label for="">assignment_link</label>
                   <input type="text" placeholder="assingnment_link" id="ass_link">
                   <button type="submit" onclick="submission()">submit</button>
           </form>
       </div>
</div>
<script>
     function logout(){
     
         let xhr=new XMLHttpRequest();
         xhr.onreadystatechange=function(){
             if(this.status==200 && this.readyState==4){
             document.location.reload();
             }
         }
         console.log('Sending request')
         xhr.open("POST",'../MODULES/logout.php');
         xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xhr.send("action=logout");
        }
            let x=0;
        function profile_div(){
            if(x==0){
            document.getElementById('profile').style.display="block";
            x=1;
            }else{
                document.getElementById('profile').style.display="none";
                x=0;
            }
        }
        let ass_id=0;
        let k=0
        function initiate(pass){
            if(k==0){
           document.getElementById('initiate').style.display="block";
           k=1;
           ass_id=pass;
           }
           else {
              k=0;
              document.getElementById('initiate').style.display="none";
           }
        }
        function submission(){
          
            const name=document.getElementById('rev_name').value;
            const link=document.getElementById('ass_link').value;
            document.getElementById('rev_name').value="";
            document.getElementById('ass_link').value="";
            // const date=new Date().getTime();
            // const stat=2;
            const xhr=new XMLHttpRequest();
            xhr.onreadystatechange=function(){
                if(this.readyState==4 && this.status==200){
                    document.getElementById('initiate').style.display="none";
                    if(this.responseText="Successful"){
                        window.confirm(this.responseText);
                    }else{
                        window.alert(this.responseText);
                    }
                }
            }
            xhr.open("POST",'../MODULES/submit.php')
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("name="+name+"&link="+link+"&ass_id="+ass_id+"&action=start");
        }
         function chat(pass){
             document.cookie="ass_id="+pass;
            window.location.assign("http://localhost:8001/TEMPLATES/comment_2.php");
         }
         function change(pass){
            if(k==0){
           document.getElementById('initiate').style.display="block";
           k=1;
           ass_id=pass;
           }
           else {
              k=0;
              document.getElementById('initiate').style.display="none";
           }
         }
          
</script>
</body>
</html>