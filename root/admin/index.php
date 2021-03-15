<?php
require_once('../connect.php');
$error = '';
if(isset($_POST['submit'])){
    if(!empty($_POST['login']) && !empty($_POST['pass'])){

        $login = trim(htmlentities($_POST['login']));
        $pass = md5(trim(htmlentities($_POST['pass'])));

        $sql = "SELECT * 
                FROM utilisateurs
                WHERE login = '$login' AND pass = '$pass'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $data = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['auth'] = $data;
            header('location:liste.php');
        }else{
            $error='<div class="alert alert-danger">Le login et/ou le mot ne correspondent pas</div>';
        }
    }else{
        $error = '<div class="alert alert-danger text-center">Le login et le mot de passe sont réquis</div>';
    }

    
}

?>
<?php require_once('../partials/header.inc'); ?>
<div class="container">
<div class="card offset-4 col-4 mt-5">
  <?=$error;?>
  <div class="card-header text-center">
    Formulaire de Connexion
  </div>
  <div class="card-body">
    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
    <div class="mb-2">
        <label for="login" class="form-label">Login*</label>
        <input type="text" class="form-control" id="login" name="login"placeholder="Entrer le login" >
        <!--
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        -->
    </div>
    <div class="mb-2">
        <label for="pass" class="form-label">Mot de passe*</label>
        <input type="password" class="form-control" id="pass" name="pass" placeholder="Entrer le mot de passe" required>
    </div>
    <!--
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    -->
    <button type="submit" class="btn btn-primary col-12" name="submit">Soumettre</button>
    </form>
  </div>
</div>
</div>
<?php require_once('../partials/footer.inc'); ?>