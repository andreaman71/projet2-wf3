<?php 
session_start();
?>

<!doctype html>
<html lang="fr">
<head>
    <?php include('head.php'); ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <?php include('header.php'); ?>

    <main class="w-50 m-auto pt-5">
        <?php 
        if (!isset($_SESSION['account'])) {
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
                        $response = $bdd->prepare('INSERT INTO user(user_email, user_password, user_ip, user_date, user_lastname, user_firstname, user_key, password_reset_key, user_rank) VALUES(?,?,?,?,?,?,?,?,?)');

                        // génération d'une clé unique sur 32 caractères en vue création token
                        $key = md5(rand().time().uniqid());

                        $response->execute(array(
                            $_POST['email'],
                            password_hash($_POST['password'], PASSWORD_BCRYPT),
                            $_SERVER['REMOTE_ADDR'], 
                            date('Y-m-d H:i:s'), 
                            $_POST['lastname'], 
                            $_POST['firstname'],
                            $key,
                            $key,
                            0
                        ));

                        

                        // Envoi email de confirmation
                        $mail = $_POST['email']; // destinataire du mail
                        $crlf = "\r\n";
                        $message_txt = 'Veuillez cliquer sur ce lien http://localhost/projet2-wf3/activation.php?account=' . $_POST['email'] . '&key=' . $key . ' pour activer votre compte';  // contenu du mail en texte simple
                        $message_html = '<html><head></head><body>Veuillez cliquer sur ce lien http://localhost/projet2-wf3/activation.php?account=' . $_POST['email'] . '&key=' . $key . ' pour activer votre compte</body></html>'; // contenu du mail en html
                        $boundary = "-----=".md5(rand());
                        $sujet = "Activation du compte";   // sujet du mail
                        $header = "From: \"Administrateur du site\"<admin@exemple.com>".$crlf;    // expediteur
                        $header.= "Reply-to: \"Administrateur du site\" <admin@exemple.com>".$crlf;   // personne en retour de mail
                        $header.= "MIME-Version: 1.0".$crlf;
                        $header.= "Content-Type: multipart/alternative;".$crlf." boundary=\"$boundary\"".$crlf;
                        $message = $crlf."--".$boundary.$crlf;
                        $message.= "Content-Type: text/plain; charset=\"UTF-8\"".$crlf;
                        $message.= "Content-Transfer-Encoding: 8bit".$crlf;
                        $message.= $crlf.$message_txt.$crlf;
                        $message.= $crlf."--".$boundary.$crlf;
                        $message.= "Content-Type: text/html; charset=\"UTF-8\"".$crlf;
                        $message.= "Content-Transfer-Encoding: 8bit".$crlf;
                        $message.= $crlf.$message_html.$crlf;
                        $message.= $crlf."--".$boundary."--".$crlf;
                        $message.= $crlf."--".$boundary."--".$crlf;
                        mail($mail,$sujet,$message,$header);
                        

                        // Si la requête SQL a touchée au moins 1 ligne tout vas bien, sinon erreur
                        if($response->rowCount() > 0){
                            $success = 'Compte créé ! Vous allez recevoir un email de confirmation pour activer votre compte';
                        } else {
                            $errors['other'] = 'Problème lors de la création du compte.';
                        }

                    } else {
                        $errors['other'] = 'Email déjà utilisé';
                    }
                }
            }
            if(!isset($success)){
            ?>
                <form method="POST" action="inscription.php">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Votre mail" name="email">
                        <?php if(isset($errors['email'])){
                            echo '<p style="color: red;">' . $errors['email'] . '</p>'; 
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <input type="firstname" class="form-control" placeholder="Votre prénom" name="firstname">
                        <?php if(isset($errors['firstname'])){
                            echo '<p style="color: red;">' . $errors['firstname'] . '</p>'; 
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <input type="lastname" class="form-control" placeholder="Votre nom" name="lastname">
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
                    
                    <div class="form-group">
                        <!-- insertion champ recaptcha google avec clé publique -->
                        <div class="g-recaptcha" data-sitekey="6LfJ8HcUAAAAADSATsaou1zeRq7FnkI4K7XPXoUQ"></div>
                        <?php if(isset($errors['recaptcha'])){
                            echo '<p style="color: red;">' . $errors['recaptcha'] . '</p>'; 
                        }
                        ?>                
                    </div>

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
            <?php
            } else {
            ?>
                <p>Vous n'avez pas accès à cette page.</p>
            <?php
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
