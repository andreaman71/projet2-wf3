<?php 
// Inclusion du fichier contenant la fonction de vérification du captcha
require('recaptcha_valid.php');

// Verification de la présence des champs et variable de formulaire
if(isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['g-recaptcha-response']) && isset($_SERVER['REMOTE_ADDR'])){
    
    //Verification de la validité de l'email 
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $errors['email']= "Email Invalide"; 
    }

    //  Verif prénom
    if(!preg_match('#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð \'-]{2,100}$#', $_POST['firstname'])){
        $errors['firstname']= "Prénom invalide"; 
    }

    // verif nom
    if(!preg_match('#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð \'-]{2,100}$#' , $_POST['lastname'])){
        $errors['lastname'] = "Nom de famille invalide"; 
    }

    // verif mot de pass
    if(!preg_match('#^.{5,300}$#', $_POST['password'])){
        $errors['password']="Mot de passe invalide"; 
    }

    // verif confirmation mdp
    if($_POST['password'] != $_POST['confirm_password']){
        $errors['confirm_password'] = "Confirmation du mot de passe invalide"; 
    }
    // Vérification que le captcha soit valide
    if(!recaptcha_valid($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'])){
        $errors['recaptcha'] = 'Recaptcha invalide';
    }

    // S'il n'y a pas d'erreur
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
        $verifyIfExist = $bdd->prepare('SELECT * FROM user WHERE user_email = ?');

        $verifyIfExist->execute(array(
            $_POST['email']
        ));

        $account = $verifyIfExist->fetch();

        // Si account est vide, c'est que l'email n'est pas utilisée, sinon erreur
        if(empty($account)){

            // Insertion du nouveau compte en BDD
            $response = $bdd->prepare('INSERT INTO user(user_email, user_password, user_ip, user_date, user_lastname, user_firstname) VALUES(?,?,?,?,?,?)');

            $response->execute(array(
                $_POST['email'],
                password_hash($_POST['password'], PASSWORD_BCRYPT),
                $_SERVER['REMOTE_ADDR'], 
                date('Y-m-d H:i:s'), 
                $_POST['lastname'], 
                $_POST['firstname']
            ));

            // Si la requête SQL a touchée au moins 1 ligne tout vas bien, sinon erreur
            if($response->rowCount() > 0){
                $success = 'Compte créé !';
            } else {
                $errors['other'] = 'Problème lors de la création du compte.';
            }

        } else {
            $errors['other'] = 'Email déjà utilisé';
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
    <!-- Ajout du fichier JS de fonctionnement de recaptcha v2 -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>
    <?php include('header.php'); ?>

    <main class="w-50 m-auto pt-5">
    <?php 
    // Si la variable succès n'existe pas on affiche le formulaire. 
    if(!isset($success)){
    ?>
        <form method="POST" action="inscription.php">
            <div class="form-group">
                <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Votre mail" name="email">
                <?php if(isset($errors['email'])){
                    echo '<p style="color: red;">' . $errors['email'] . '</p>'; 
                }
                ?>
            </div>
            <div class="form-group">
                <input type="firstname" class="form-control" aria-describedby="emailHelp" placeholder="Votre prénom" name="firstname">
                <?php if(isset($errors['firstname'])){
                    echo '<p style="color: red;">' . $errors['firstname'] . '</p>'; 
                }
                ?>
            </div>
            <div class="form-group">
                <input type="lastname" class="form-control" aria-describedby="emailHelp" placeholder="Votre nom" name="lastname">
                <?php if(isset($errors['lastname'])){
                    echo '<p style="color: red;">' . $errors['lastname'] . '</p>'; 
                }
                ?>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Votre mot de passe" name="password">
                <?php if(isset($errors['password'])){
                    echo '<p style="color: red;">' . $errors['password'] . '</p>'; 
                }
                ?>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Votre mot de passe (confirmation)" name="confirm_password">
                <?php if(isset($errors['confirm_password'])){
                    echo '<p style="color: red;">' . $errors['confirm_password'] . '</p>'; 
                }
                ?>
            </div>
            <!-- insertion champ recaptcha google avec clé publique -->
            <div class="g-recaptcha" data-sitekey="6LfJ8HcUAAAAADSATsaou1zeRq7FnkI4K7XPXoUQ"></div>
            <?php if(isset($errors['recaptcha'])){
                echo '<p style="color: red;">' . $errors['recaptcha'] . '</p>'; 
            }
            ?>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    <?php 

        // Affichage du message d'erreur. 
        if(isset($errors['other'])){
            echo '<p style="color: red;">' . $errors['other'] . '</p>';
        }

    // Affichage du message de succès. 
    } else {
        echo '<p style ="color:green;">' . $success . '</p>';
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