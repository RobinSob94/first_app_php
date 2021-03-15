<?php

require_once('connect.php');
$sql = "SELECT * FROM personne p
INNER JOIN langues l
ON p.id_l = l.id";
$result = mysqli_query($conn, $sql);


include_once 'partials/header.inc';?>
<div class="container">
    <div class="bg-light text-center">
        <h1>Traducteurs assermentés</h1>
        <p>Nos traducteur son a votre service ...</p>
    </div>
    <div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while($rows = mysqli_fetch_assoc($result)){?>
        <div class="col">
            <div class="card text-white bg-dark">
                <img src="assets/images/<?=$rows['image'];?>" class="card-img-top" alt="..." height="350">
                <div class="card-body">
                    <h5 class="card-title"><?=$rows['nom'];?> <?=$rows['prenom'];?></h5>
                    <p class="card-text"><?=$rows['age'];?> ans</p>
                    <p class="card-text">Langues : <?=$rows['libelle'];?> <img src="assets/drapeau/<?=$rows['drapeau'];?>" alt="..." height="50"></p>
                    <p class="card-text">Contacte : <?=$rows['telephone'];?>, <?=$rows['email'];?></p>
                    <p class="card-text">En service depuis :
                        <?php
                            $date=$rows['created'];
                            $dateArray =(explode("-",substr($date,0,10)));
                            echo $dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0];
                        ?>
                    </p>
                    <p class="card-text"><?=$rows['description'];?></p>
                </div>
                <div class="card-body">
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</div>
</div>
<?php include_once 'partials/footer.inc';?>