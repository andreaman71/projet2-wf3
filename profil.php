<?php

session_start();

if (isset($_SESSION['email'])) {

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

?>
  <!doctype html>
  <html lang="fr">
  <head>
    <?php include('head.php'); ?>
  </head>
    <body>
      <?php include('header.php'); ?>

      <main class="w-75 m-auto">
        <h3 class="mt-5">Mon profil</h3>
          <table class="mt-5 table">
    <thead>
      <tr>
        <th scope="col">Email</th>
        <th scope="col">Prénom</th>
        <th scope="col">Nom</th>
        <th scope="col">Date d'inscription</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php
          foreach($users as $user){
            echo '<td>' . htmlspecialchars($user) . '</td>';
          }
        ?>
      </tr>
    </tbody>
  </table>

      </main>
        
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    </body>
  </html>
<?php
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
          <p>Vous n'avez pas accès à cette page.</p>
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
