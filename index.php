<?php
session_start();

// Incluir el componente de la barra de navegación
require_once "navbar.php";

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>WEngineers</title>
            <link rel="stylesheet" href="styles.css?v=2.0">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&display=swap" rel="stylesheet">
        </head>
        <body>
         <!-- Usar el componente de la barra de navegación -->
         <?php renderNavbar(); ?>

        <!-- Hero Section -->
        <div class="main">
          <div class="main__container">
            <div class="main__content">
              <h1>NEXT GENERATION</h1>
              <h2>TECHNOLOGY</h2>
              <p>UNIPV DOCET</p>
              <?php if (!isset($_SESSION["user_id"])): ?>
                <button class="main__btn"><a href="signup.html">Inizia ora!</a></button>
              <?php else: ?>
                <button class="main__btn"><a href="portfolio.php">Scopri gli ingegneri</a></button>
              <?php endif; ?>
              </div>
              <div class="main__img--container">
                <img src="images/pic1.svg" alt="pic" id="main__img"/>
              </div>
            </div>
         </div>
      

        <!-- Sezione Servizi -->
         <div class="services">
          <h1>Guarda come lavoriamo ed ingaggiaci!</h1>
          <div class ="services__container">
           <div class="services__card">
            <h2>Vuoi qualche esempio?</h2>
            <p>Guarda questo video!</p>
            <a href="https://youtu.be/dQw4w9WgXcQ?si=SB3QmDDmZKu-ipqk"><button>Clicca qui!</button></a>
           </div> 
           <div class="services__card">
            <h2>Sei pronto?</h2>
            <p>Iscriviti al nostro sito!</p>
            <?php if (!isset($_SESSION["user_id"])): ?>
              <a href="signup.html"><button>Iscriviti qui!</button></a>
            <?php else: ?>
              <a href="portfolio.php"><button>Vai al portfolio!</button></a>
            <?php endif; ?>
           </div> 
          </div>
         </div>

         <!-- Footer -->
          <div class="footer__container">
            <div class="footer__links">
              <div class="footer__link--wrapper">
                <div class="footer__link--items">
                  <h2>About us</h2>
                  <a href="http://webing.unipv.eu/">Dove studiamo</a>
                  <a href="https://vision.unipv.it/wmt/">Sito del corso</a>
                </div>
              </div>
                <div class="footer__link--items">
                  <h2>Social Media</h2>
                  <a href="/">Instagram</a>
                  <a href="/">Facebook</a>
                  <a href="/">Youtube</a>
                  <a href="/">X</a>
                  <a href="/">Linkedin</a>
                </div>
              </div>
              <div class="social__media">
                <div class="social__media--wrap">
                  <div class="footer__logo">
                    <a href="index.php" id="footer__logo"><i class="fas fa-gem"></i>WEngineers</a>
                  </div>
                  <p class="website__right">&copy; WEngineers. 2025. All Rights Reserved.</p>
                  <div class="social__icons">
                    <a href="" class="social__icon--link" target="_blank">
                      <i class="fab fa-facebook"></i>
                    </a>
                    <a href="" class="social__icon--link" target="_blank">
                      <i class="fab fa-instagram"></i>
                    </a>
                    <a href="" class="social__icon--link" target="_blank">
                      <i class="fab fa-x"></i>
                    </a>
                    <a href="" class="social__icon--link" target="_blank">
                      <i class="fab fa-youtube"></i>
                    </a>
                    <a href="" class="social__icon--link" target="_blank">
                      <i class="fab fa-linkedin"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <script src="app.js"></script>
    </body>
</html>