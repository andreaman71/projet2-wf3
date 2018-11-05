<?php 
if(isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['password']) && isset($_POST['confirm_password'])){

    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $errors['email']= "Email Invalide"; 
    }

    if(!preg_match('#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð \'-]{2,100}$#', $_POST['firstname'])){
        $errors['firstname']= "Prénom invalide"; 
    }

    if(!preg_match('#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð \'-]{2,100}$#' , $_POST['lastname'])){
        $errors['lastname'] = "Nom de famille invalide"; 
    }

    if(!preg_match('#^.{5,300}$#', $_POST['password'])){
        $errors['password']="Mot de passe invalide"; 
    }

    if($_POST['password'] != $_POST['confirm_password']){
        $errors['confirm_password'] = "Confirmation du mot de passe invalide"; 
    }

    if(!isset($errors)){
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=project;charset=utf8', 'root', '');
        } catch(Exception $e){
            die('Erreur de connection à la BDD');
        }

         // Afficher les erreurs SQL si il y en a
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Selection du compte (hypothétique) ayant déjà l'adresse email dans le formulaire
    $verifyIfExist = $bdd->prepare('SELECT * FROM users WHERE email = ?');

    $verifyIfExist->execute(array(
        $_POST['email']
    ));

    $account = $verifyIfExist->fetch();

    // Si account est vide, c'est que l'email n'est pas utilisée, sinon erreur
    if(empty($account)){

        // Insertion du nouveau compte en BDD
        $response = $bdd->prepare('INSERT INTO users(email, password, ip, date, lastname, firstname, ) VALUES(?,?)');

        $response->execute(array(
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_BCRYPT)
        ));

        // Si la requête SQL a touchée au moins 1 ligne tout vas bien, sinon erreur
        if($response->rowCount() > 0){
            $success = 'Compte créé !';
        } else {
            $errors[] = 'Problème lors de la création du compte.';
        }

    } else {
        $errors[] = 'Email déjà utilisée';
    }




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
        <form method="POST" action="inscription.php">
            <div class="form-group">
                <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Votre mail" name="email">
            </div>
            <div class="form-group">
                <input type="firstname" class="form-control" aria-describedby="emailHelp" placeholder="Votre prénom" name="firstname">
            </div>
            <div class="form-group">
                <input type="lastname" class="form-control" aria-describedby="emailHelp" placeholder="Votre nom" name="lastname">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Votre mot de passe" name="password">
            </div>
            <div class="form-group">
                <input type="password-confirm" class="form-control" placeholder="Votre mot de passe (confirmation)" name="confirm_password">
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </main>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
  </body>
</html>