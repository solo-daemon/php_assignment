<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST"){
    print_r($_POST);
    if($_POST["action"]=="logout"){
        $_SESSION["id"]=null;
        session_unset();
        session_destroy();
        setcookie("id",session_id(),time(),'/');
    }
}
?>
