<?php
session_start();
if(isset($_SESSION['id'])){
require "../MODULES/connect.php";
$sql='select username,first_name from users where Role="Student";';
$sql_1='selct * from users where username="'.$_SESSION['id'].'";';
$result=$conn->query($sql);
$result_1=$conn->query($sql_1);
$row_1=$result->fetch_array();
$sql_3='select * from users where username="'.$_SESSION["id"].'" ;';
$result_3=$conn->query($sql_3);
$row_3=$result_3->fetch_array();

}
else{
    session_destroy();
    header('Location: http://localhost:8001/',true,301);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
            .container{
           display:flex;
           flex-direction:column;
           align-items:center;
           padding: 4% 0;
        }
        .stud_card{
            width:30%;
            border:2px solid purple;
            border-radius:5px;
            display: flex;
            padding: 2% 2%;
            margin: 5px 0;
            align-items: center;
        }
        .nav{
       padding: 1% 10%;
       display: flex;
       justify-content: space-between;
       align-items: center;
       padding-bottom:0;
       /* background-color: rgb(212, 211, 211); */
   }
   img{
       width: 30px;
       border: 2px solid red;
       border-radius: 50%;
       padding: 10% 10%;
   }
   .nav{
           display: flex;
           justify-content: space-between;
           padding: 2% 10%;
           align-items: center;
           border-bottom:  2px  solid black;
       }
       #profile_img{
           width: 10%;
           border: 2px solid red;
           border-radius: 50%;
           padding: 2% 2%;
       }#profile_img:hover{
           background-color: rgb(241, 238, 238);
       }
       #add{
             border: 2px solid blue;
             color: blue;
             background-color: white;
             border-radius: 5px;
             padding: 2.5% 2.5%;
       }#add:hover{
           color: white;
           background-color: blue;
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
               justify-content: space-between;
               align-items: center;
       }
       .option{
           border: none;
           background-color: white;
           font-size: 20px;
       }
       .option:hover{
           background-color: grey;
           color: white;
           border-radius: 5px;
           padding: 2% 2%;

       }
      .names{
          display:flex;
          flex-direction:column;
          justify-content: space-between;
          /* height:20%; */
           padding: 5% 5%;
      }
   
      .add_button{
             border: 2px solid blue;
             color: blue;
             background-color: white;
             border-radius: 5px;
             padding: 1% 1%;
             margin: 4% 4%
       }.add_button:hover{
           color: white;
           background-color: blue;
       }
       .add_assignment{
           display:none;
           position:absolute;
           top: 50px;
           left:28%;
           padding:10% 10%;
           background-color:white;
           border:2px solid black;
           border-radius:5px;
           
       }
       .add_form{
           display:flex;
           flex-direction:column;
       }
       .add_item{
           position: relative;
       }
       label{
           margin: 4% 4%;
           padding: 1% 1%;
       }
       input{
        margin: 2% 2%;
        padding: 1% 1%;
        outline: none;
       }
       .profile{
           display: none;
       }
    </style>
</head>
<body>
<nav class="nav">
        <div class="left_nav">
          <img src="./user.png" alt="profile_img" id="profile_img" onclick="profile_div()">
          <button class="option">Students</button>
          <button class="option">Assignment</button>
        </div>
        <div class="right_nav">
            <div class="add_item">
            <button id="add" onclick="add_assignment()">+ Add Assignment</button>
            <div class="add_assignment" id="add_assignment">
                 <form class="add_form"  method="post" id="add_form">
                <div id="add_response"></div>
                 <label for="">Assignment Title</label>
                 <input type="text" placeholder="30-40 chars" required name="name" id="name">
                 <label for="" placeholder="link">Assignment Link</label>
                 <input type="text" placeholder="link" required name="link" id="link">
                 <button type="submit" class="add_button" id="add_button">Add</button>
                
    </form>

            </div>
        </div>
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
        <?php
        if($result->num_rows >0){
            while($row=$result->fetch_assoc()){
                echo '<div class="stud_card">
                <img src="./user.png" alt="profile" >
                <div class="names">
                      <div class="link" id="'.$row["username"].'" onclick="cook(this.id)"><a href="./dashboard_reviewer_2.php" ><strong>'.$row["username"].'</strong></a></div>
                      <div>'.$row["first_name"].'</div>
                </div>
                </div>';
            }
        }else{
            echo "<h3>Oops !! there is some error please reload the page</h3>";
        }
        ?>
   </div>
        <script>
        function cook(str){
               document.cookie="student="+str+";"
        }
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
     xhr.send("action=logout")
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
        let a=0;
        function add_assignment(){
            if(a==0){
             document.getElementById('add_assignment').style.display="block";
             a=1;
            }
             else{
                document.getElementById('add_assignment').style.display="none";
                a=0;
             }
        }
        
        document.getElementById('add_button').addEventListener('click',
        function (e){
                e.preventDefault()
                let name=document.getElementById('name').value;
                let link=document.getElementById('link').value;
                let xhr=new XMLHttpRequest();
                xhr.onreadystatechange=function(){
                    if(this.status==200 && this.readyState==4){
                        if(this.responseText=="success"){
                        document.getElementById('add_assignment').style.display="none";
                a=0;}
                document.getElementById("add_response").innerHTML=this.responseText;
                    }

                }
                xhr.open("post","../MODULES/assignment_new.php");
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("name="+name+"&link="+link);
        });
            </script>

            
</body>
</html>