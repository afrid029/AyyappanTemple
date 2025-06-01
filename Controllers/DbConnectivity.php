<?php
session_start();
try {
    // $db = mysqli_connect('localhost', 'root', '', 'ayyappan');
    
    if (!$db) {
        throw new Exception("Database connection failed");
    }
} catch (Exception $er) {
    //echo $er->getMessage();
    $_SESSION['error'] = $er->getMessage();
    header('Location: /error');
}

?>