<?php

session_start();

if (!isset($_SESSION['email'])) {

// Inclusion du fichier contenant la fonction de vérification du captcha
require('recaptcha_valid.php');


// Vérifier la présence des champs 
if (
    isset($_POST['email']) && 
    isset($_POST['password'])
) {

    // Vérification des champs
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'L\'email n\'est pas valide';
    }
    if (!preg_match('#^.{5,300}$#', $_POST['password'])) {
        $errors['password'] = 'Le mot de passe  n\'est pas valide';
    }
    
    // Si pas d'erreurs
    if(!isset($errors)) {
        
        // Requete à la bdd et verif du mail
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=projet2;charset=utf8', 'root', '');
        } catch(Exception $e){
            die('Erreur de connexion à la bdd');
        }

        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $response = $bdd->prepare('SELECT * FROM user WHERE user_email = ? ');

        $response->execute(array(
            $_POST['email']
        ));

        $userInfos = $response->fetch(PDO::FETCH_ASSOC);

        $response->closeCursor();

            // Si mail ok, vérif password
            if (!empty($userInfos)) {
        
                // Si password ok, création session
                if (password_verify($_POST['password'], $userInfos['user_password'])) {
                    $success = 'Vous etes connecté.';

                    $_SESSION['account'] = $userInfos;
                
                } else {
                    $errors['password_user'] = 'Le mot de passe ne correspond pas avec l\'email';
                }         
            
            } else {
                $errors['email_user'] = 'Cet email ne correspond à aucun compte';
            }
                
            $response->closeCursor();

    } 
}


?>



<!doctype html>
<html lang="fr">
<head>
    <?php include('head.php'); ?>
  </head>
  <body>
    <?php include('header.php'); ?>

        <main class="w-50 m-auto pt-5">

        <?php
        if (!isset($success)) {
        ?>
                <form method="POST" action="login.php">
                <div class="form-group">
                    <input name="email" type="email" class="form-control" placeholder="Votre mail">
                </div>
                        <?php 
                        if(isset($errors['email'])) {
                            echo '<p style="color:red;">' . $errors['email'] . '</p>'; 
                        }
                        if (isset($errors['email_user'])) {
                            echo '<p style="color:red">' . $errors['email_user'] . '</p>';
                        }
                        ?>

                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Votre mot de passe">        
                </div>
                    <?php 
                    if(isset($errors['password'])) {
                        echo '<p style="color:red;">' . $errors['password'] . '</p>';     
                    }
                    if (isset($errors['password_user'])) {
                        echo '<p style="color:red">' . $errors['password_user'] . '</p>';
                    }
                    ?>

                <div class="form-group">
                    <a href="reset.php">Mot de passe oublié?</a>
                </div>

                <button type="submit" class="btn btn-primary">Connexion</button>
            </form>   
        <?php
        } else {
            echo '<p class="text-center" style="color:green">' . $success . '</p>';
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

<?php 
} else if (isset($_SESSION['email'])) {
?>
    <!doctype html>
    <html lang="fr">
    <head>
    <?php include('head.php'); ?>
  </head>
    <body>
        <?php include('header.php'); ?>

            <main class="pt-5 text-center">   
                <p>Vous n'avez pas accès à cette page.</p>
            </main>
    
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } ?>