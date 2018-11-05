<?php
// On vérifie si GET['id'] existe et contient bien un numéro d'article valide
if(!isset($_GET['id']) OR !preg_match('#^[1-9][0-9]{0,9}$#', $_GET['id'])){
    $errors[] = 'ID invalide';
}

if(!isset($errors)){
    // Connexion BDD
    require('bdd.php');

    // On récupère les infos de l'article demandé
    $getArticle = $bdd->prepare('SELECT * FROM article WHERE id = ?');
    $getArticle->execute(array($_GET['id']));
    $article = $getArticle->fetch(PDO::FETCH_ASSOC);
    $getArticle->closeCursor();
    
    // Si la requête ne retourne rien, c'est qu'aucun article ne correspond à l'id demandé
    if(empty($article)){
        $errors[] = 'Cet article n\'existe pas';
    }
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Détails Article</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <style>
        .menu li{
            display:inline;
            margin:3px;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>
<?php
    // Si il y a des erreurs, on les affiche, sinon on affiche les détails de l'article demandé
    if(isset($errors)){
        foreach($errors as $error){
            echo '<p style="color:red;">'.$error.'</p>';
        }
    } else { ?>
        
        <h1>Détail de l'article <strong><?php echo htmlspecialchars($article['article_title']); ?></strong> :</h1>
        <ul>
            <li>Contenu : <?php echo htmlspecialchars($article['article_content']); ?></li>
            <li>Auteur : <?php echo htmlspecialchars($article['article_author']); ?></li>
            <li>Date : <?php echo htmlspecialchars(date('d m Y', strtotime($article['article_date']))); ?></li>
        </ul>
        <?php
    }
    ?>
    <p><a href="article.php">Retour à la liste des articles</a></p>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</body>
</html>