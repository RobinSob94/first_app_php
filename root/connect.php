<?php

    $conn = mysqli_connect('localhost', 'root','','bdd');

    if(!$conn){
        echo 'Code erreur : '.mysqli_connect_errno().' Message Erreur : '.mysqli_connect_error();
        
    }
        

    echo '<br/>';
?>