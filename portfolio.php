<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Conectar a la base de datos
$mysqli = require __DIR__ . "/database.php";

// Obtener información del usuario actual
$sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

// Obtener todos los ingenieros de la base de datos
$sql_ingenieros = "SELECT * FROM ingegneri";
$result_ingenieros = $mysqli->query($sql_ingenieros);

// Incluir el componente de la barra de navegación
require_once "navbar.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingegneri - Portfolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Usar el componente de la barra de navegación -->
    <?php renderNavbar(); ?>

    <main class="engineer-section">
    <?php 
    // Mostrar ingenieros desde la base de datos
    if ($result_ingenieros->num_rows > 0) {
        while($ingeniero = $result_ingenieros->fetch_assoc()) { 
            $image_data = $ingeniero['foto_url'];
    ?>
        <div class="engineer-card">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($image_data); ?>" class="engineer-photo">
            <h2><?php echo htmlspecialchars($ingeniero['nome']); ?></h2>
            <p><?php echo htmlspecialchars($ingeniero['specialita']); ?></p>
            <p>Progetti: <?php echo htmlspecialchars($ingeniero['progetti']); ?></p>
            <a href="<?php echo htmlspecialchars($ingeniero['github_url']); ?>" target="_blank">GitHub</a> |
            <a href="<?php echo htmlspecialchars($ingeniero['linkedin_url']); ?>" target="_blank">LinkedIn</a> |
            <a href="<?php echo htmlspecialchars($ingeniero['instagram_url']); ?>" target="_blank">Instagram</a> |
            <a href="<?php echo htmlspecialchars($ingeniero['email_url']); ?>" target="_blank">Email</a>
        </div>
    <?php 
        }
    } else {
        echo "<p>Nessun ingegnere trovato nel database.</p>";
    }
    ?>
</main>

    <section class="form-section">
        <h2>Richiedi un servizio</h2>
        <form action="process-request.php" method="POST">
            <!-- Autocompletamos el formulario con los datos del usuario logueado -->
            <input type="text" name="nome" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Il tuo nome" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="La tua email" required>
            <select name="ingegnere" required>
                <?php 
                // Reiniciamos el puntero del resultado
                $result_ingenieros->data_seek(0);
                while($ingeniero = $result_ingenieros->fetch_assoc()) { 
                ?>
                <option value="<?php echo htmlspecialchars($ingeniero['nome']); ?>"><?php echo htmlspecialchars($ingeniero['nome']); ?></option>
                <?php } ?>
            </select>
            <textarea name="messaggio" placeholder="Descrivi la tua richiesta" required></textarea>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="submit" value="Invia richiesta">
        </form>
    </section>
  
    <!-- HTML DEL FOOTER -->
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
                <a href="index.html" id="footer__logo"><i class="fas fa-gem"></i>WEngineers</a>
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