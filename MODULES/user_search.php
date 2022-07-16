<?php
$x=0;
$q=$_REQUEST['q'];
require "./connect.php";
$sql='select username from auth where username="'.$q.'";';
$result=$conn->query($sql);
if($result->num_rows >0){
     echo "Not Available";
}else{
    echo "Available";
}

?>