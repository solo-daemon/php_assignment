<?php
$x=0;$alert=0;
$user_name=$pass=$role=$fname=$lname=$year="";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["user"])){
        $user=test_input($_POST["user"]);
    }else{
        $x+=1;
    }
    if(isset($_POST["fname"])){
        $fname=test_input($_POST["fname"]);
    }else{
        $x+=1;
    }
    if(isset($_POST["lname"])){
        $lname=test_input($_POST["lname"]);
    }else{
        $x+=1;
    }
    if(isset($_POST["pass"])){
        if($_POST["pass"]==$_POST["cpass"]){
            $pass=hash("sha256",test_input($_POST["pass"]),true);
        }else{
            $x+=1;
        }
    }else{
        $x+=1;
    }
    if(isset($_POST["role"])){
        $role=test_input($_POST["role"]);
    }else{
        $x+=1;
    }
    if(isset($_POST["year"])){
        $year=test_input($_POST["year"]);
    }else{
        $x+=1;
    }
     if($x==0){
         require "../MODULES/connect.php";
         $sql=$conn->prepare("insert into auth (username, password) values (?, ?);");
         $sql_1=$conn->prepare("insert into users (username, first_name, last_name, Year_of_Passing, Role) values (?, ?, ?, ?, ?);");
         $sql_1->bind_param("sssis",$user,$fname,$lname,$year,$role);
         $sql->bind_param("ss",$user,$pass);
         $sql->execute();
         $sql_1->execute();
        $sql->close();
        $sql_1->close();
         $alert=1;

    }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
          box-sizing:border-box;
        }
        .container{
            display: flex;
            align-items: center;
            border: 2px solid purple;
            box-shadow: 1px 1px 4px 1px rgb(140, 3, 145) ;
            width: 35%;
            margin: 5% auto;
            flex-direction: column;
            border-radius: 10px;
        }
        label{
            display: block;
            padding: 7% 0px;
            color: rgb(73, 38, 73);
        }
        input{
            padding-top: 4%;
            border-width: 0 0 2px 0;
            border-color: rgb(245, 17, 245);
            outline: none;
        }
        button{
            display: block;
            margin: 7% 0;
            background-color: rgb(163, 21, 132);
            color: white;
            border-radius: 5px;
            padding: 6px 6px;
        }
        #uniq{
            color: rgb(73, 38, 73);
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="">First Name</label>
            <input type="text"  name="fname" placeholder="first name">
            <label for="">Last Name</label>
            <input type="text" name="lname" placeholder="last name">
            <label for="">Username :</label>
            <input type="text"  name="user" placeholder="30 chars(unique)" onkeyup="check()" id="user">
            <span id="uniq">Enter</span>
            <label for="">Password</label>
            <input type="text" name="pass" placeholder="password">
            <label for="">Confirm Password</label>
            <input type="text" name="cpass" placeholder="re-type password">
            <label for="">Year of Passing</label>
            <input type="number" name="year" placeholder="20xx">
            <label for="">Specify your Role :</label>
            <input type="radio" name="role" value="Reviewer"><span>Reviewer</span>
            <input type="radio" name="role" value="Student"><span>Student</span>
           <button type="submit">Sign-up</button>
        </form>
        <a href="../index.php"> <button>Log-in</button></a> 
    </div>
    <script>
      let  uniq=document.getElementById("uniq");
      let user=document.getElementById("user");
        function check(){
          let  str="";
          str= user.value;
          console.log(user.value);
            if(str.length==0){
                 uniq.innerHTML="Enter";
                 uniq.style.color="purple";
            }
            else{
            xhr=new XMLHttpRequest();
            xhr.onreadystatechange=function(){
                if(this.readyState==4 && this.status==200){
                    uniq.innerHTML=this.responseText;
                    if(this.responseText==" Available"){
                         uniq.style.color="green";
                    }else{
                         uniq.style.color="red";
                    }
                }
            };
            xhr.open("GET","../MODULES/user_search.php?q="+str,true);
            xhr.send();
        }}
    <?php

    if($alert==1){
        echo 'window.alert("account created successfully")';
        header("Location : http://localhost:8001/",true,301);
    }
    
    ?>
    </script>
</body>
</html>
