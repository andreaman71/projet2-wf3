<?php

session_start();
if($_SESSION['account']['user_rank'] == 1){
// Connexion à la BDD
try{
    $bdd = new PDO('mysql:host=localhost;dbname=projet2;charset=utf8', 'root', '');
} catch(Exception $e){
    die('Erreur de connection à la BDD');
}

// Afficher les erreurs SQL si il y en a
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récup de la liste des auteurs
$authors = $bdd->query('SELECT user_id, user_firstname, user_lastname FROM user ORDER BY user_lastname');
$listeAuthors = $authors->fetchAll();

// Si tous les champs du formulaire sont là
if(
    isset($_POST['title']) &&
    isset($_POST['content']) &&
    isset($_POST['author']) &&
    isset($_POST['date'])
){
    
    // Bloc vérifications des champs
    if(!preg_match('#^.{2,100}$#', $_POST['title'])){
        $errors['title'] = 'Titre invalide';
    }

    if(!preg_match('#^.{2,20000}$#', $_POST['content'])){
        $errors['content'] = 'Description invalide';
    }

    if(!filter_var($_POST['author'],FILTER_VALIDATE_INT)){
        $errors['author'] = 'Auteur invalide';
    }

    if(!preg_match('#^((((19|[2-9]\d)\d{2})\-(0[13578]|1[02])\-(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})\-(0[13456789]|1[012])\-(0[1-9]|[12]\d|30))|(((19|[2-9]\d)\d{2})\-02\-(0[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\-02\-29))$#', $_POST['date'])){
        $errors['date'] = 'Date invalide';
    }

    // Si pas d'erreurs
    if(!isset($errors)){

        // Insertion avec une requête préparée (protégée contre injection SQL !) d'un nouvel article
        $response = $bdd->prepare('INSERT INTO article(article_title, article_content, article_author, article_date) VALUES(:title, :content, :author, :date)');

        // Liaison de :name dans la requête avec $_POST['name'], etc..
        $response->bindValue('title', $_POST['title']);
        $response->bindValue('content', $_POST['content']);
        $response->bindValue('author', $_POST['author']);
        $response->bindValue('date', $_POST['date']);

        // Execution de la requête SQL
        $response->execute();

        // Si la requête a affecté aucune ligne, il y a eu une erreur, sinon tout va bien
        if($response->rowCount() > 0){
            $success = 'Article inséré !';
        } else {
            $errors['other'] = 'Erreur dans la bdd';
        }
    }
}
}else{
    
    header('Location: http://localhost/projet2-wf3/article.php');

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Création article</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

</head>
<body>
    <?php include('header.php'); ?>

    <main class="w-50 m-auto pt-5">

    <h1>Création d'un article</h1>
    
    <?php

    // Si success n'existe pas, on affiche le formulaire, sinon on affiche le message de succès
    if(!isset($success)){
    ?>
    <form action="articlecreate.php" method="POST">
        <div class="form-group">
            <input type="text"  class="form-control" name="title" placeholder="Titre">
            <?php
            if(isset($errors['title'])){
                echo '<p style="color:red;">' . $errors['title'] . '</p>';
            } ?>
        </div>
        <div class="form-group">
            <input type="text"  class="form-control" name="content" placeholder="Contenu">
            <?php if(isset($errors['content'])){
                echo '<p style="color:red;">' . $errors['content'] . '</p>';
            } ?>
        </div>
        <div class="form-group">
            <select name="author"  class="form-control" >
            <?php
                // Pour chaque auteur dans le tableau, on crée une option dans le select
                foreach($listeAuthors as $author){
                    echo '<option value="' . $author['user_id'] . '">' . ucfirst($author['user_lastname']) . ' ' . ucfirst($author['user_firstname']) . '</option>';
                }
            ?>
            </select>
            <?php if(isset($errors['author'])){
                echo '<p style="color:red;">' . $errors['author'] . '</p>';
            } ?>
        </div>
        <div class="form-group">
            <input type="date"  class="form-control" name="date" placeholder="Date :">
            <?php if(isset($errors['date'])){
                echo '<p style="color:red;">' . $errors['date'] . '</p>';
            } ?>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
    <?php

        // Si l'erreur 'other' existe, on l'affiche en dessous du formulaire
        if(isset($errors['other'])){
            echo '<p style="color:red;">' . $errors['other'] . '</p>';
        }

    } else {
        echo '<p style="color:green;">' . $success . '</p>';
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