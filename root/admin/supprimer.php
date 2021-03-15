<?php

require_once('../connect.php');
require_once('security.inc');

if(isset($_GET['id']) && $_GET['id']<1000){

    $id = (int)htmlspecialchars(addslashes($_GET['id']));
    $req = "SELECT image FROM personne WHERE id_p=$id";
    $res = mysqli_query($conn, $req);
    $data = mysqli_fetch_assoc($res);

    $sql = "DELETE FROM personne WHERE id_p=$id";
    $result = mysqli_query($conn, $sql);
  
    if(mysqli_affected_rows($conn)>0){
        copy("../assets/images/".$data['image'], "../assets/archives/".$data['image']);
        unlink("../assets/images/".$data['image']);
        header('location:liste.php');
    }else{
        echo '<div>Erreur de suppression</div>';
    }
}

?>