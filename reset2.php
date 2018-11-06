<?php

session_start();
 
if(isset($_GET['key'])) {
     
    $cle = $_GET['key'];

            // Connexion à la base de données
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=projet2;charset=utf8', 'root', '');
            } catch(Exception $e){
                die('Erreur de connection à la BDD');
            }
    
             // Afficher les erreurs SQL si il y en a
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Selection du compte (hypothétique) ayant déjà l'adresse email dans le formulaire
            $verifyIfExist = $bdd->prepare('SELECT * FROM user WHERE password_reset_key = ?');
    
            $verifyIfExist->execute(array(
                $cle
            ));
    
            if($verifyIfExist->rowCount() > 0){
                if(isset($_POST['password']) && isset($_POST['password-confirm'])) {
                    if(!preg_match('#^.{5,300}$#', $_POST['password'])){
                        $errors['password']="Mot de passe invalide"; 
                    }
                        // verif confirmation mdp
                    if($_POST['password'] != $_POST['password-confirm']){
                        $errors['password-confirm'] = "Confirmation du mot de passe invalide"; 
                    }

                    // Injection de nouveau mdp dans la bdd
                    $newPassword = $bdd->prepare('UPDATE user_password FROM user WHERE password_reset_key = ?');
            
                    $newPassword->execute(array(
                        password_hash($_POST['password'], PASSWORD_BCRYPT),
                    ));

                    $succes = 'Vous avez modifié votre mot de passe.';

                    $key = md5(rand().time().uniqid());

                    //MAJ de password reset key
                    $newKey = $bdd->prepare('UPDATE user SET password_reset_key = ? WHERE password_reset_key = ?');
            
                    $newKey->execute(array(
                        $key,
                        $cle
                    ));
    

                } else {
                    $errors[] = 'Veuillez saisir un mot de passe';
                }
            } else {
                $errors[] = 'Erreur';
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
    <?php
    if (!isset($success)) {
    ?>
        <form method="POST" action="reset2.php">
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Votre nouveau mot de passe">
            </div>
            <div class="form-group">
                <input name="password-confirm" type="password" class="form-control" placeholder="Votre nouveau mot de passe (confirmation)">
            </div>
                <?php

                if(isset($errors)){
                    echo '<p style="color:red;">' .$errors[0]. '</p>';
                }

                ?>
            <button type="submit" class="btn btn-primary">Réinitialiser</button>

        </form>    
    <?php   
    } else if (isset($success)) {
        echo '<p style="color:green";>' . $success . '</p>';
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