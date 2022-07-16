<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST["action"]=="logout"){
        session_unset();
        session_destroy();
    }
}

?>
