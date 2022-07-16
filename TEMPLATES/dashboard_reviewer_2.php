<?php
session_start();
if(isset($_SESSION["id"])){
       if(!isset($_COOKIE["student"])){    
       }else{
           $id=$_COOKIE["student"];
       }
}else{
    session_destroy();
    header("Location: http://localhost:8001/",true,301);
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
         *{
            box-sizing: border-box;
        }
        .container{
            display: flex;
            justify-content: center;
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
        .white{
           background-color: white;
           
        }.green{
         background-color:greenyellow ;
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
        <table cellspacing=0>
       <?php
        include '../MODULES/connect.php';
        $sql="select title,link,".$id."_status,".$id."_comment from assignmet;";
        // echo $sql;
        $result=$conn->query($sql);
        $status=$id.'_status';
        $comment=$id.'_comment';
       while($row=$result->fetch_assoc()){
            echo '<tr>
            <td class="white">'.++$sl.'</td>
            <td class="green"><a href="'.$row["link"].'"><strong>'.$row["title"].'</strong></a></td>
            <td class="white">';
            if($row[$status]==0){
               echo "Not initialised";
            }else if($row[$status]==-1){
                  echo "Completed";
            }else{
               echo "Iteration :".$row[$status];
            }
            echo '</td>
            <td class="green">'.$row[$comment].'</td>
            <td class="white"><button onclick="accept(this.className)" class="'.$row["title"].'">Accept</button>
            <button onclick="iteration(this.className)" class="'.$row["title"].'">Iteration</button>
            </td>
        </tr>';
       }
       ?>
       </table>
</div>
<script>
     function accept(st){
        // xhr=new XMLHttpRequest();
        // xhr.onreadystatechange=function(){
        //       if(this.readyState==4 && this.status==200){
        //          window.location.assign("http://localhost:8001/TEMPLATES/comment.php");
        //       }
        // };
        // xhr.open("POST","./comment.php");
        // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // xhr.send('action="submit');
        document.cookie="status=";
        document.cookie="action=accept";
        document.cookie="ass="+st;
        let status =<?php
        $sql_1='select '.$id.'_status from assignmet where title="'.$_COOKIE["ass"].'";';
        $result=$conn->query($sql_1);
        $row=$result->fetch_array();
        echo $row[$status];
        ?>

        document.cookie="status="+status;
        window.location.assign("http://localhost:8001/TEMPLATES/comment.php");
     }
     function iteration(st){
        // xhr=new XMLHttpRequest();
        // xhr.onreadystatechange=function(){
        //     if(this.readyState==4 && this.status==200){
        //         window.location.assign("http://localhost:8001/TEMPLATES/comment.php");
        //     }
        // };
        // xhr.open("POST","./comment.php");
        // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // xhr.send('action=iteration');
        
        
        document.cookie="action=iteration";
        document.cookie="ass="+st;
        let status =<?php
        $sql_1='select '.$id.'_status from assignmet where title="'.$_COOKIE["ass"].'";';
        $result=$conn->query($sql_1);
        $row=$result->fetch_array();
        echo $row[$status];
        ?>

        document.cookie="status="+status;
        window.location.assign("http://localhost:8001/TEMPLATES/comment.php");
     }
     function logout(){
            let xhr=new XMLHttpRequest();
            xhr.open("POST","../MODULES/logout.php");
            xhr.onreadystatechange=function(){
                if(this.readyState==4 && this.status==200)
                window.location.assign("http://localhost:8001/")
            };
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("action=logout");
        }
</script>
</body>
</html>