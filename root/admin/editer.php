<?php
require_once('../connect.php');

require_once('security.inc');

$error = "";

$sql = "SELECT id, libelle FROM langues";
$res = mysqli_query($conn, $sql);

if(isset($_GET['id']) && $_GET['id'] <= 1000 && filter_var($_GET['id'], FILTER_VALIDATE_INT)){
    $id = htmlspecialchars(addslashes($_GET['id']));
    $sql = "SELECT * FROM personne p
            INNER JOIN langues l
            ON p.id_l = l.id
            WHERE p.id_p = '$id'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);

        //var_dump($data);
    }
}

if(isset($_POST['soumis'])){
    if(isset($_POST['nom']) && strlen($_POST['nom'])<=20 && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $id_p = trim(htmlspecialchars(addslashes($_POST['id_p'])));
        $nom = trim(htmlspecialchars(addslashes($_POST['nom'])));
        $prenom = trim(htmlspecialchars(addslashes($_POST['prenom'])));
        $age = trim(htmlspecialchars(addslashes($_POST['age'])));
        $email = trim(htmlspecialchars(addslashes($_POST['email'])));
        $telephone = trim(htmlspecialchars(addslashes($_POST['phone'])));
        $id_l = trim(htmlspecialchars(addslashes($_POST['langue'])));
        $description= trim(htmlspecialchars(addslashes($_POST['desc'])));
        $image = $_FILES['image']['name'];

        $destination ="../assets/images/";
        move_uploaded_file($_FILES['image']['tmp_name'], $destination.$image);

        if(empty($image)){
            $sql = "UPDATE personne SET nom = '$nom', prenom = '$prenom', age = '$age', email = '$email', telephone = '$telephone', id_l = '$id_l', description = '$description' 
            WHERE id_p = '$id_p'";
        }else{
            if(file_exists('../assets/images/'.$data['image'])){

                unlink('../assets/images/'.$data['image']);
            }
            $sql = "UPDATE personne SET nom = '$nom', prenom = '$prenom', age = '$age', email = '$email', telephone = '$telephone', id_l = '$id_l', image = '$image', description = '$description' 
            WHERE id_p = '$id_p'"; 
        }

        $resultat = mysqli_query($conn, $sql);

        if($resultat){
            header('location:liste.php');
        }
        }else{
            $error = '<div class="alert alert-danger">Erreur d\'insertion</div>';
        }
        
    }

 require_once('../partials/header.inc'); 
?>
<div class="container">
<h1 class="text-center">Admin</h1>
<div class="offset-2 col-8">
<h2>Formulaire d'édition</h2>
    <?= $error; ?>
    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_p" value="<?=$data['id_p'];?>">
    <div class="row">
    <div class="col-5">
        <label for="nom">Nom*</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?=$data['nom'];?>" placeholder="Entrez votre nom svp" required>
    </div>
    <div class="col-5">
        <label for="prenom">Prénom*</label>
        <input type="text" class="form-control" id="prenom" name="prenom" value="<?=$data['prenom'];?>" placeholder="Entrez votre prénom svp" required>
    </div>
    <div class="col-2">
        <label for="age">Age*</label>
        <input type="number" class="form-control" id="age" name="age" value="<?=$data['age'];?>" placeholder="Entrez votre âge svp" min="18" required>
    </div>
    </div>
    <div class="row">
    <div class="col">
        <label for="email">Email adresse*</label>
        <input type="email" class="form-control" id="email" name="email" value="<?=$data['email'];?>" placeholder="Entrez votre email svp" required>
    </div>
    <div class="col">
        <label for="phone">Téléphone*</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?=$data['telephone'];?>" placeholder="Entrez votre numéro de téléphone svp" required>
    </div>
    </div>
    <div class="row">
    <div class="col">
        <label for="image">Photo</label>
        <input type="file" class="form-control" id="image" name="image">
        <img src="../assets/images/<?=$data['image'];?>" width="50" alt="">
    </div>
    <div class="col">
        <label for="langue">Langue*</label>
        <select class="form-select" id="langue" name="langue" >
        <option value="<?=$data['id_l'];?>" ><?=$data['libelle'];?></option>
        <?php while($rows = mysqli_fetch_assoc($res)){ if($data['id_l'] !== $rows['id']){ ?>
            <option value="<?=$rows['id']; ?>"><?=ucfirst($rows['libelle']); ?></option>
        <?php }} ?>
        </select>
    </div>
    </div>
    <div class="row">
    <div class="col mb-2">
        <label for="desc">Description</label>
        <textarea  class="form-control" id="desc" name="desc" rows="5" placeholder="Entrez la description svp"><?=$data['description'];?></textarea>
    </div>

    </div>
    <a href="liste.php" class="btn btn-info offset-1 col-5" name="soumis">Retour</a>
    <button type="submit" class="btn btn-success col-5" name="soumis" >Modifier</button>
    </form>
</div>
</div>
<?php require_once('../partials/footer.inc');?>