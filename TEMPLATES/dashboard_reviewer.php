<?php
session_start();
if(isset($_SESSION['id'])){
require "../MODULES/connect.php";
$sql='select username,first_name from users where Role="Student";';
$result=$conn->query($sql);
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
        }
        .stud_card{
            width:30%;
            border:2px solid purple;
            border-radius:5px;
            display: flex;
            padding: 2% 2%;
            margin: 5px 0;
        }
        .nav{
       padding: 1% 10%;
       display: flex;
       justify-content: space-between;
       align-items: center;
       /* background-color: rgb(212, 211, 211); */
   }
   img{
       width: 30px;
       border: 2px solid red;
       border-radius: 50%;
       padding: 10% 10%;
   }
   #logout{
       background-color: red;
       padding: 12% 12%;
       border-radius: 10%;
   }
   #logout:hover{
       background-color: rgb(243, 130, 130);
   }
        .names{
            padding: 0 10%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            color: rgb(99, 10, 117);
        }
    </style>
</head>
<body>
<nav class="nav">
        <div>
            <img src="./user.png" alt="user">
        </div>
        <div>
          <button id="logout" onclick="logout()">Logout</button>
        </div>
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
                if(this.readyState==4 && this.status==200)
                window.location.assign("http://localhost:8001/")
            };
            xhr.open("POST","../MODULES/logout.php");
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("action=logout");
        }
            </script>
</body>
</html>