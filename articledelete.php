<?php
// On vérifie si GET['article_id'] existe et contient bien un numéro d'article
if(isset($_GET['article_id'])) {
    $article_id = $_GET['article_id'];
    if(!preg_match('#^[1-9][0-9]{0,9}$#', $article_id)){
        $errors['other'] = 'URL incorrecte : article_id incorrect !';
    }
} else {
    $errors['other'] = 'URL incorrecte : article_id manquant !';
}

if(!isset($errors)) {
    require('bdd.php');
    
    // Récup de l'article appelé
    $verifyIfExist = $bdd->prepare('SELECT COUNT(*) FROM article WHERE article_id = ?');
    
    $verifyIfExist->execute(array(
        $article_id
    ));

    $article = $verifyIfExist->fetch();

    // Cas où l'article n'existe pas
    if($article[0] == 0){
        $errors['other'] = 'Cet article n\'existe pas';
    }
}

if(!isset($errors)){       
    // Suppression avec une requête préparée (protégée contre injection SQL !)
    $supprime = $bdd->prepare('DELETE FROM article WHERE article_id = ?');

    $supprime->execute(array(
        $article_id
    ));

    // Vérification du résultat de la requête
    if($supprime->rowCount() > 0){
        $success = 'Article supprimé !';
    } else {
        $errors['other'] = 'Problème lors de la suppression';
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suppression article</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

</head>
<body>
    <?php include('header.php'); ?>

    <main class="w-50 m-auto pt-5">

    <h1>Suppression d'un article</h1>
    
    <?php

    // Affichage message succès
    if(isset($success)){
        echo '<p style="color:green;">' . $success . '</p>';
    }

    // Affichage message erreur
    if(isset($errors)){
        foreach($errors as $error){
            echo '<p style="color:red;">' . $error . '</p>';
        }
    }
    ?>

    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</body>
</html>