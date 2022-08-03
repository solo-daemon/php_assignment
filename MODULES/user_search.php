<?php
$x=0;
$q=test_input($_REQUEST['q']);
require "./connect.php";
$sql='select username from auth where username="'.$q.'";';
$result=$conn->query($sql);
if($result->num_rows >0){
     echo "Not Available";
}else{
    echo "Available";
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>