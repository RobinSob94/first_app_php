<?php
require_once('security.inc');
require_once('../connect.php');
$error="";
require_once('../connect.php');
$sql = "SELECT * FROM langues";
$result = mysqli_query($conn, $sql);

if(isset($_POST['soumis'])){
    if(isset($_POST['nom']) && strlen($_POST['nom'])<=20 && strlen($_POST['nom'])>=1 && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $nom = trim(htmlspecialchars(addslashes($_POST['nom'])));
        $prenom = trim(htmlspecialchars(addslashes($_POST['prenom'])));
        $age = trim(htmlspecialchars(addslashes($_POST['age'])));
        $email = trim(htmlspecialchars(addslashes($_POST['email'])));
        $telephone = trim(htmlspecialchars(addslashes($_POST['phone'])));
        $description = trim(htmlspecialchars(addslashes($_POST['description'])));
        $id_l = trim(htmlspecialchars(addslashes($_POST['langue'])));
        $image = $_FILES['image']['name'];

        $destination ="../assets/images/";
        move_uploaded_file($_FILES['images']['tmp_name'],$destination.$image);

        $sql2 ="INSERT INTO personne(nom, prenom, age, telephone, email,image, description, id_l)
                VALUES('$nom','$prenom','$age','$telephone','$email','$image','$description','$id_l')";
        $result2 = mysqli_query($conn,$sql2);
        if(mysqli_insert_id($conn)>0){
            header('location:liste.php');
        }else{
            $error = '<div class="alert alter-danger">Erreur d\'ajout</div>';
        }
    }
}

require_once('../partials/header.inc'); 

?>
<div class="container">
<h1 class="text-center">Admin</h1>
<div class="offset-1 col-10">
<h2>Formulaire d'ajout</h2>
<?= $error;?>
    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <div class="row">
    <div class="col-5">
        <label for="nom">Nom*</label>
        <input type="text" class="form-control" required id="nom" name="nom" placeholder="Entrez votre nom svp">
    </div>
    <div class="col-5">
        <label for="prenom">Prénom*</label>
        <input type="text" class="form-control" required id="prenom" name="prenom" placeholder="Entrez votre prénom svp" >
    </div>
    <div class="col-2">
        <label for="age">Age*</label>
        <input type="number" class="form-control" required id="age" name="age" placeholder="Entrez votre âge svp" min="18">
    </div>
    </div>
    <div class="row">
    <div class="col">
        <label for="email">Email adresse*</label>
        <input type="email" class="form-control" required id="email" name="email" placeholder="Entrez votre email svp">
    </div>
    <div class="col">
        <label for="phone">Téléphone*</label>
        <input type="tel" class="form-control" required id="phone" name="phone" placeholder="Entrez votre numéro de téléphone svp" >
    </div>
    </div>
    <div class="row">
    <div class="col">
        <label for="image">Photo</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <div class="col">
        <label for="langue">Langue*</label>
        <select class="form-select" required id="langue" name="langue" >
        <option >Choisir</option>
        <?php
            while($rows = mysqli_fetch_assoc($result)){
        ?>
        <option value="<?= $rows['id']; ?>"><?= $rows['libelle']; ?></option>
        <?php } ?>
        </select>
    </div>
    </div>
    <div class="row">
    <div class="col mb-2">
        <label for="desc">Description</label>
        <textarea  class="form-control" id="desc" rows="5" placeholder="Entrez la description svp" name="description"></textarea>
    </div>

    </div>
    <a href="liste.php" class="btn btn-info offset-1 col-5" name="soumis">Retour</a>
    <button type="submit" class="btn btn-success col-5" name="soumis" >Soumettre</button>
    </form>
</div>
</div>
<?php require_once('../partials/footer.inc');?>