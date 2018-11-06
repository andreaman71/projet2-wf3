<?php

session_start();

?>
<!doctype html>
<html lang="fr">
  <head>
    <?php include('head.php'); ?>
  </head>

    <body>
      <?php include('header.php'); ?>

        <main class="w-75 m-auto">
          <?php
          if (isset($_SESSION['account'])) {
          ?>
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
                      echo '<td>' . htmlspecialchars($_SESSION['account']['user_email']) . '</td>';
                      echo '<td>' . htmlspecialchars($_SESSION['account']['user_firstname']) . '</td>';
                      echo '<td>' . htmlspecialchars($_SESSION['account']['user_lastname']) . '</td>';
                      echo '<td>' . htmlspecialchars($_SESSION['account']['user_date']) . '</td>';
                  ?>
                </tr>
              </tbody>
            </table>
          <?php
          } else {
          ?>
            <p class="text-center pt-5">Vous n'avez pas accès à cette page.</p>
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
