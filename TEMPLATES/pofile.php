<?php
include '..MODULES/connect.php';
$user=$_SESSION["id"];
$sql='select * from users where username="'.$user.'"';

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
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
    <?php
        $result=$conn->query($sql);
        $row=$result->fetch_array();
        echo '
        <div class="profile">
        <div>Username : '.$row["username"].'</div>
        <div>Name : '.$row["first_name"]+$row["last_name"].'</div>
        <div>Role : '.$row["Role"].'</div>
        </div>

        ';
    ?>
</body>
</html>
