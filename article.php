<?php
// On déclare ici le nombre d'article à afficher par page au cas où on souhaiterais le modifier rapidement
$articlePerPage = 10;

// On vérifie si GET['page'] existe et contient bien un numéro de page valide, sinon on on met la page à afficher à 1 par défaut
if(isset($_GET['page']) AND preg_match('#^[1-9][0-9]{0,9}$#', $_GET['page'])){
    $pageNumber = $_GET['page'];
} else {
    $pageNumber = 1;
}

// On calcul ici le OFFSET qui nous servira dans la requête SQL à sélectionner les bons article selon la page demandée
$offset = ($pageNumber - 1) * $articlePerPage;

require('bdd.php');

// On récupère les articles de la page demandée, selon la nombre d'article à afficher par page (LIMIT) et la page demandée (OFFSET)
$getArticles = $bdd->prepare('SELECT * FROM article LIMIT :limit OFFSET :offset');
// On utilise PDO::PARAM_INT en tant que 3eme paramètre de bindvalue pour forcer les 2 paramètres à être des entiers et non des chaînes de texte, sinon la requête plante.
$getArticles->bindValue(':limit', $articlePerPage, PDO::PARAM_INT);
$getArticles->bindValue(':offset', $offset, PDO::PARAM_INT);
$getArticles->execute();

// On récupère tous les articles trouvés par la requête SQL et on les met sous forme de tableau associatif dans $articles
$articles = $getArticles->fetchAll(PDO::FETCH_ASSOC);
$getArticles->closeCursor();

// On fait une nouvelle requête pour récupérer le nombre total d'article dans la BDD. ça servira plus loin pour générer le menu de navigation des pages
$getTotalArticle = $bdd->query('SELECT COUNT(article_id) AS total FROM article');
$totalArticle = $getTotalArticle->fetch(PDO::FETCH_ASSOC)['total'];
$getTotalArticle->closeCursor();
// On arrondi la page max à l'unitée supérieur au cas où le nombre de page serait pas rond (ex: 15 articles sur la 1ere page et 5 sur la deuxieme donnerait 1.333 page, donc on arrondi à l'unitée supérieure pour bien avoir 2 pages)
$pageMax = ceil($totalArticle/$articlePerPage);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Article</title>
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
<h1>Articles</h1>
    <?php
    
    // Si il y a des articles à afficher, on les affiche sinon on affiche un message d'erreur
    if(!empty($articles)){
        echo "<ul>";
        // Extraction de tous les articles avec un foreach
        foreach($articles as $article){
            echo '<li><strong><a href="article_content.php?id='.htmlspecialchars($article['article_id']).'">'.htmlspecialchars($article['article_title']).'</a></strong> écrit par <strong>'. htmlspecialchars($article['article_author']) .'</strong></li>';
        }
        echo "</ul>";
    } else {
        echo '<p style="color:red;">Pas d\'articles</p>';
    }
    
    ?>
    
    <ul class="menu">
        <!-- Bouton pour revenir à la page 1 (pas en PHP car ce bouton sera toujours fixe) -->
        <li><a href="article.php?page=1">Début</a></li>
        
        <?php
        
        // Bouton permettant d'aller à la page précédente si elle existe (plus grand que 0)
        if(($pageNumber-1)>0){
        echo '<li><a href="article.php?page=' . ($pageNumber-1) . '">&larr;</a></li>';
        }
        
        // Bouton permettant d'aller 2 pages avant la page courante si elle existe (plus grand que 0)
        if(($pageNumber-2)>0){
        echo '<li><a href="article.php?page=' . ($pageNumber-2) . '">' . ($pageNumber-2) . '</a></li>';
        }
        
        // Bouton permettant d'aller à la page précédent la page courante si elle existe (plus grand que 0)
        if(($pageNumber-1)>0){
        echo '<li><a href="article.php?page=' . ($pageNumber-1) . '">' . ($pageNumber-1) . '</a></li>';
        }
        
        // Affiche juste la page courante, sans lien (nous sommes déjà dessus)
        echo '<li>' . $pageNumber . '</li>';
        
        // Bouton permettant d'aller à la page suivant la page courante si elle existe (plus petite ou égal à la page maximum)
        if(($pageNumber+1) <= $pageMax){
        echo '<li><a href="article.php?page=' . ($pageNumber+1) . '">' . ($pageNumber+1) . '</a></li>';
        }
        
        // Bouton permettant d'aller 2 pages après la page courante si elle existe (plus petite ou égal à la page maximum)
        if(($pageNumber+2) <= $pageMax){
        echo '<li><a href="article.php?page=' . ($pageNumber+2) . '">' . ($pageNumber+2) . '</a></li>';
        }
        
        // Bouton permettant d'aller à la page suivante si elle existe (plus petite ou égal à la page maximum)
        if(($pageNumber+1) <= $pageMax){
        echo '<li><a href="article.php?page=' . ($pageNumber+1) . '">&rarr;</a></li>';
        }
        
        // Bouton permettant d'aller à la dernière page
        echo '<li><a href="article.php?page=' . $pageMax .'">Fin</a></li>';
        ?>
    </ul>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</body>
</html>