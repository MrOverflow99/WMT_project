<?php
session_start();
$is_invalid = false;

// Incluir el componente de la barra de navegación
require_once "navbar.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css?v=2.1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Usar el componente de la barra de navegación -->
    <?php renderNavbar(); ?>
    
    <!-- Contenedor principal con estilo coherente -->
    <div class="main">
        <div class="login-container">
            <h1>Login</h1>
            
            <?php if ($is_invalid): ?>
                <div class="error-message">
                    <em>Invalid login</em>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>
                
                <button>Log in</button>
            </form>
        
            <h2>If you still don't have an account, <a href="signup.html" class="signup">Sign Up</a>!</h2>
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
    
    <script src="app.js"></script>
</body>
</html>