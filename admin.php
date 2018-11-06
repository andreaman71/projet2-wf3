<?php

session_start();

if($_SESSION[''])

if(isset($_POST['email'])){
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $errors[] = 'Veuillez saisir un email valide';
  }

  try {
    $bdd = new PDO('mysql:host=localhost;dbname=projet2;charset=utf8', 'root', '');
  } catch(Exception $e){
      die('Erreur de connexion à la bdd');
    }

  $response = $bdd->prepare('SELECT user_email, user_firstname, user_lastname, user_date FROM user WHERE user_email = ? ');

  $response->execute(array(
      $_SESSION['email'],
  ));

  $users = $response->fetch(PDO::FETCH_NUM);

  $response->closeCursor();
}




if (isset($_SESSION['account'])) {

    if ($_SESSION['rank'] == 1) {
        ?>
        <!doctype html>
        <html lang="fr">
          <?php include('head.php'); ?>
          <body>
          <?php include('header.php'); ?>
              
            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
          </body>
        </html> 
<?php
    }
} else {
?>
<!doctype html>
<html lang="fr">
  <head>
    <?php include('head.php'); ?>
  </head>
  <body>
  <?php include('header.php'); ?>

    <main class="text-center pt-5">
  
      <form method="POST" action="admin.php">
        <div class="form-group">
            <input name="email" type="email" class="form-control" placeholder="Admin">
        </div>

        <div class="form-group">
            <input type="submit" class="form-control">
        </div>

      </form>

    </main>    




      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
  </body>
</html> 
<?php   
}
?>
