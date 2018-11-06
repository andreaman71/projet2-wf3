<?php

session_start();

if(isset($_POST['email'])){
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        
    } else{

        try{
            $bdd= new PDO('mysql:host=localhost;dbname=projet2;charset=utf8', 'root', '');
        } catch(Exeption $e){
            die('Erreur de connexion à la bdd');
        }
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $response = $bdd->prepare('SELECT user_id FROM user WHERE user_email = ? ' );

        $response->execute(array(
            $_POST['email']
        ));

        $id = $response->fetch(PDO::FETCH_NUM);

        if($response->rowCount() > 0){

            $key = md5(rand().time().uniqid());

            $response = $bdd->prepare('UPDATE user SET password_reset_key = ? WHERE user_email = ?');

            $response->execute(array(
                $key,
                $_POST['email']
            ));
            
            require('mail.php');

            $response->closeCursor();

            $success = 'Nous vous avons envoyer un mail de réinitialisation';

        } else{
        $errors[] = 'Cet email ne correspond à aucun compte';
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
        <form method="POST" action="reset.php">
            <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="Votre mail">
            </div>
                <?php

                if(isset($errors)){
                    echo '<p style="color:red;">' .$errors[0]. '</p>';
                }

                ?>
            <button type="submit" class="btn btn-primary">Réinitialiser</button>
        </form>
        <?php
        if (isset($success)) {
            echo '<p style="color:green">' . $success . '</p>';
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