<?php 

if(isset($_GET['account']) && isset($_GET['key'])){

    $login = $_GET['account'];
    $cle = $_GET['key'];

    if(!filter_var($login, FILTER_VALIDATE_EMAIL)){
        $errors[]= "Ceci n'est pas une adresse mail!" ;
    }

    if(!mb_strlen($cle) == 32){
        $errors[]= "Ceci n'est pas une clé de validation! ";
    }
    if(!isset($errors)){
        // Connexion à la base de données
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projet2;charset=utf8', 'root', '');
        } catch(Exception $e){
            die('Erreur de connection à la BDD');
        }

         // Afficher les erreurs SQL si il y en a
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Selection du compte (hypothétique) ayant déjà l'adresse email dans le formulaire
        $verifyIfExist = $bdd->prepare('SELECT user_key, user_active, id FROM user WHERE user_email = ?');

        $verifyIfExist->execute(array(
            $login
        ));

        $found = $verifyIfExist->fetch();
        
        // Si found n'est pas vide, c'est que l'utilisateur existe
        if(!empty($found)){

            if($found['user_active'] == '1'){
                $errors[]= "Compte déjà actif!";
            } else {

                // mise à jour  / activation du  compte en BDD
                $response = $bdd->prepare('UPDATE user SET user_active = 1 WHERE id = ?');
                $response->execute(array(
                    $found['id']
                ));

                // Si la requête SQL a touchée au moins 1 ligne tout vas bien, sinon erreur
                if($response->rowCount() > 0){
                    $success = 'Compte activé!';
                } else {
                    $errors[] = 'Problème lors de l\'activation du compte.';
                }
            }

        } else {
            $errors[] = 'Compte introuvable';
        }
    }

}

?>
<!doctype html>
<html lang="fr">
  <head>
    <title>Projet 2</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
  </head>
  <body>
    <?php include('header.php'); ?>

    <main class="w-50 m-auto pt-5">
        <p>Votre compte est activé</p>
    </main>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
  </body>

</html>