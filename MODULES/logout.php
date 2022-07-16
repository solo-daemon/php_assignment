<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST["action"]=="logout"){
        $_SESSION=array();
        session_unset();
        session_destroy();
        $_SESSION['id']==null;
    }
}

?>
