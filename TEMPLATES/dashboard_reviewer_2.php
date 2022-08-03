<?php
session_start();
$id="";
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
        body{
            background-color: #fefec6;
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
             padding: 2.5% 2.5%;
       }#back:hover{
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
               justify-content: flex-end;
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
<div class="container">
        <table cellspacing=0>
        <tr>
                <th class="white">ass_id</th>
                <th class="green">assignment</th>
                <th class="white">rev_user</th>
                <th class="green">link</th>
                <th class="white">stat</th>
                <th class="green">last_date_submission</th>
                <th class="white">action</th>
            </tr>
       <?php
        include '../MODULES/connect.php';
        $sql_1='select * from submission inner join assignments on submission.assignment_id=assignments.assignment_id where stud_user="'.$_COOKIE["student"].'";';
        $sql_2='select * from assignments where assignment_id not in (select assignments.assignment_id from submission inner join assignments on submission.assignment_id=assignments.assignment_id where stud_user="'.$_COOKIE["student"].'");';
        $result_1=$conn->query($sql_1);
        $result_2=$conn->query($sql_2);
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
            echo'</td>
            <td class="green">'.date('r',$row["last_submission"]).'</td>
            <td class="white">'; 
            if($row["rev_user"]==$_SESSION["id"]){
                echo'<button class="'.$row["assignment_id"].'" onclick="comment(this.className)">comment</button><button class="'.$row["assignment_id"].'" onclick="accept(this.className)">accept</button>';
            }else{
                echo 'you are not the reviewer';
            }
            
            echo'</td>
        </tr>
            ';
            
           
       }
       while($row=$result_2->fetch_assoc()){
           echo '
           <tr>
           <td class="white">'.$row["assignment_id"].'</td>
           <td class="green"><a href="'.$row["assignmet_link"].'"><strong>'.$row["assignment_name"].'</strong></a></td>
           <td class="green"></td>
           <td class="white"></a></td>
           <td class="white">not initiated</td>
           <td class="green"></td>
           <td></td>
           </tr>
           ';
       }
       ?>
       </table>
</div>
<script>
    //  function accept(st){
       
    //     document.cookie="status=";
    //     document.cookie="action=accept";
    //     document.cookie="ass="+st;
    //     let status =<?php
    //     $sql_1='select '.$id.'_status from assignmet where title="'.$_COOKIE["ass"].'";';
    //     $result=$conn->query($sql_1);
    //     $row=$result->fetch_array();
    //     echo $row[$status];
    //     ?>

    //     document.cookie="status="+status;
    //     window.location.assign("http://localhost:8001/TEMPLATES/comment.php");
    //  }
    //  function iteration(st){
    //     document.cookie="action=iteration";
    //     document.cookie="ass="+st;
    //     let status =<?php
    //     $sql_1='select '.$id.'_status from assignmet where title="'.$_COOKIE["ass"].'";';
    //     $result=$conn->query($sql_1);
    //     $row=$result->fetch_array();
    //     echo $row[$status];
    //     ?>

    //     document.cookie="status="+status;
    //     window.location.assign("http://localhost:8001/TEMPLATES/comment.php");
    //  }
     function back(){
         window.location.assign("http://localhost:8001/TEMPLATES/dashboard_reviewer.php");
     }
     function comment(pass){
        // console.log(pass)
        console.log(pass)
        let stud="<?php echo $id?>";
        document.cookie="ass_id="+pass;
        document.cookie="action=comment";
        
        // let xhr=new XMLHttpRequest()
        // xhr.onreadystatechange=function(){
        //           if(this.status==200 &&this.readyState==4){
                    window.location.assign("http://localhost:8001/TEMPLATES/comment_1.php");
        //           }
        // }
        // xhr.open("POST","./comment_1.php");
        // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // xhr.send("stud="+stud+"&ass_id="+pass+"&action=comment");
     }
     function accept(pass){
         let stud="<?php echo $id?>";
         console.log("stud="+stud+';ass_id='+pass+';action=accept')
        document.cookie="ass_id="+pass;
        document.cookie="action=accept";
        // let xhr=new XMLHttpRequest();
        // xhr.onreadystatechange=function(){
        //     if(this.status==200 && this.readyState==4){
                       window.location.assign("http://localhost:8001/TEMPLATES/comment_1.php");
        //             }
        // }
        // xhr.open("POST","./comment_1.php");
        // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // xhr.send("stud="+stud+"&ass_id="+pass+"&action=accept");
     }
     
</script>
</body>
</html>