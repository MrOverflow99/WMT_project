<?php

function renderNavbar() {
    // siamo loggati?
    $isLoggedIn = isset($_SESSION["user_id"]);
    
    // Se l'user è loggato metti il nome
    $username = "";
    if ($isLoggedIn) {
        $mysqli = require __DIR__ . "/database.php";
        $sql = "SELECT name FROM user WHERE id = {$_SESSION["user_id"]}";
        $result = $mysqli->query($sql);
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $username = htmlspecialchars($user["name"]);
        }
    }
    
    // navbar
    ?>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="index.php" id="navbar__logo">WEngineers</a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="index.php" class="navbar__links">Home</a>
                </li>
                <li class="navbar__item">
                    <a href="portfolio.php" class="navbar__links">Ingegneri</a>
                </li>
                <?php if ($isLoggedIn): ?>
                    <li class="navbar__item">
                        <a href="register-engineer.php" class="navbar__links">Unisciti al team!</a>
                    </li>
                    <li class="navbar__item">
                        <span class="navbar__links">Ciao, <?php echo $username; ?>!</span>
                    </li>
                    <li class="navbar__btn">
                        <a href="logout.php" class="button">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="navbar__item">
                        <a href="login.php" class="navbar__links">LogIn</a>
                    </li>
                    <li class="navbar__btn">
                        <a href="signup.html" class="button">SignUp</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <?php
}
?>