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

      <main class="text-center pt-5">
          <?php 
          if (isset($_SESSION['account'])) {
          session_destroy();
          unset($_SESSION['account']);?> 
          <p>Vous êtes déconnecté.</p>
          <?php }
          else {
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