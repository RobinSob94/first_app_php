<?php

require_once('../connect.php');

require_once('security.inc');

if(isset($_POST['submit']) && !empty($_POST['search'])){
    $mCle = trim(addslashes(htmlentities($_POST['search'])));
    $sql = " SELECT * FROM personne p
    INNER JOIN langues l
    ON p.id_l = l.id
    WHERE nom LIKE '$mCle%' OR libelle LIKE '$mCle%'";
}else{
    $sql = "SELECT * FROM personne p
        INNER JOIN langues l
        ON p.id_l = l.id";

}
$result = mysqli_query($conn, $sql);

include_once '../partials/header.inc';?>
<div class="container">
    <h1>Liste des traducteurs </h1>
    <p class="text-right"><a href="ajouter.php" class="btn btn-info"><i class="fas fa-plus"></i> Ajouter</a></p>
    <form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" >
        <div class="input-group justify-content-end">
            <input type="search" class="form-control offset-9 col-3 text-center" name="search" id="search" placeholder="Recherche">
            <button type="submit" name="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Age</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Photo</th>
                <th>langue</th>
                <th>Date de création</th>
                <?php if(isset($_SESSION['auth']) && $_SESSION['auth']['role']==1){ ?>
                <th colspan="2" class="text-center">Actions</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            while($rows = mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?= $rows['id_p']; ?></td>
                <td><?= $rows['nom']; ?></td>
                <td><?= $rows['age']; ?></td>
                <td><?= $rows['telephone']; ?></td>
                <td><?= $rows['email']; ?></td>
                <td><img src="../assets/images/<?= $rows['image']; ?>" width="50" alt="..."></td>
                <td><?= $rows['libelle']; ?> <img src="../assets/drapeau/<?= $rows['drapeau']; ?>" width="25" alt="..."></td>
                <td><?= $rows['created']; ?></td>
                <?php if(isset($_SESSION['auth']) && $_SESSION['auth']['role']==1){ ?>
                <td>
                    <a href="editer.php?id=<?= $rows['id_p']; ?>" class="btn btn-success">
                    <i class="fas fa-edit"></i> Editer</a>
                </td>
                <td>
                    <a href="supprimer.php?id=<?= $rows['id_p']; ?>" class="btn btn-danger" onclick="return confirm('Êtes vous sûr de vouloir supprimer')">
                    <i class="fas fa-trash"></i> Supprimer</a>
                </td>
                <?php } ?>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
<?php include_once '../partials/footer.inc';?>
