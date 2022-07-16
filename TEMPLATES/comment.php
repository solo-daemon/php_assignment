<?php
session_start();
if(isset($_SESSION["id"])){
    $stud=$_COOKIE["student"];
    $ass=$action="i";
   
        // $ass=$_POST["ass"];
        $action=$_COOKIE["action"];
        $ass=$_COOKIE["ass"];
       $status=$_COOKIE["status"];
}else{
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
        *{
            box-sizing: border-box;
        }
        .container{
            display: flex;
            justify-content: center;
            
        }
        .comm{
            border: 2px solid purple;
            padding: 2% 2%;
            border-radius: 3%;
        }
        .ele{
            margin: 3% 0;
        }
        textarea{
            display: block;
            width: 100%;
            margin: 3% 0;
            outline: none;
        }
        button{
            margin: 5% 0;
            background-color: rgb(197, 8, 197);
            border: 2px solid purple;
            color: white;
            border-radius: 7%;
        }
        button:hover{
            background-color: rgb(250, 162, 250);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="comm">
        <div class="ele"><strong>Student:</strong><?php echo $_COOKIE["student"] ?></div>
            <div class="ele"><strong>Assignment :</strong><?php echo $ass ?></div>
            <div class="ele"><strong>Action :</strong><?php echo $action ?></div>
            <div class="ele">
                <strong>Comment :</strong>
                <textarea rows="7" cols="70" id="comment">
                  
           </textarea>
            <button onclick="done()">Done</button>
            </div>
        </div>
    </div>
<script>
     function done(){
         let comm=document.getElementById("comment");
         let stud="<?php echo $_COOKIE["student"] ?>";
         let ass="<?php echo $ass ?>";
         let action="<?php echo $action ?>";
         let status=<?php echo $status ?>;
         let str='stud='+stud+'&ass='+ass+'&action='+action+'&comm='+comm.value+'&status='+status;
         console.log(str);
         console.log(comm.value);
         xhr=new XMLHttpRequest();
         xhr.onreadystatechange=function(){
               if(this.readyState==4 && this.status==200){
                   console.log(this.responseText);
                   window.location.assign('http://localhost:8001/TEMPLATES/dashboard_reviewer_2.php');
               }
         };
         xhr.open("POST","../MODULES/update.php");
         xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xhr.send(str);
     }
    
</script>
</body>

</html>