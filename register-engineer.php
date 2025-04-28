<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "navbar.php";
$mysqli = require __DIR__ . "/database.php";

// Obtener información del usuario actual
$sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar que todos los campos requeridos estén presentes
    if (empty($_POST['nome']) || empty($_POST['specialita']) || empty($_POST['progetti']) || 
        empty($_POST['github_url']) || empty($_POST['linkedin_url']) || 
        empty($_FILES['foto']['name'])) {
        $error_message = "Tutti i campi sono obbligatori!";
    } else {
        // Procesar y validar la imagen
        $target_dir = "uploads/";
        $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        
        if (!in_array($file_extension, $allowed_extensions)) {
            $error_message = "Solo immagini JPG, JPEG, PNG e GIF sono permesse.";
        } elseif ($_FILES["foto"]["size"] > 5000000) { // 5MB max
            $error_message = "L'immagine è troppo grande. Il limite è 5MB.";
        } else {
            // La imagen es válida, procesarla
            $image_data = file_get_contents($_FILES["foto"]["tmp_name"]);
            
            // Preparar los datos para insertar en la base de datos
            $nome = $mysqli->real_escape_string($_POST['nome']);
            $specialita = $mysqli->real_escape_string($_POST['specialita']);
            $progetti = $mysqli->real_escape_string($_POST['progetti']);
            $github_url = $mysqli->real_escape_string($_POST['github_url']);
            $linkedin_url = $mysqli->real_escape_string($_POST['linkedin_url']);
            $email_url = $mysqli->real_escape_string($_POST['email_url'] ?? '');
            $instagram_url = $mysqli->real_escape_string($_POST['instagram_url'] ?? '');
            
            // Preparar la consulta SQL
            $stmt = $mysqli->prepare("INSERT INTO ingegneri (nome, specialita, progetti, github_url, linkedin_url, foto_url, email_url, instagram_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            if (!$stmt) {
                $error_message = "Errore nella preparazione: " . $mysqli->error;
            } else {
                // Vincular parámetros y ejecutar
                $stmt->bind_param("ssssssss", $nome, $specialita, $progetti, $github_url, $linkedin_url, $image_data, $email_url, $instagram_url);
                
                if ($stmt->execute()) {
                    $success_message = "Registrazione completata con successo! Ora sei parte del nostro team di ingegneri.";
                } else {
                    $error_message = "Errore durante la registrazione: " . $stmt->error;
                }
                
                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione Ingegnere</title>
    <link rel="stylesheet" href="styles.css?v=2.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Barra de navegación -->
    <?php renderNavbar(); ?>
    
    <div class="engineer-form-section">
        <h1>Registrati come Ingegnere</h1>
        
        <?php if ($success_message): ?>
            <div class="success-message">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="specialita">Specialità</label>
                <input type="text" id="specialita" name="specialita" placeholder="Es. Ingegnere del Software, Ingegnere Elettronico" required>
            </div>
            
            <div class="form-group">
                <label for="progetti">Progetti (breve descrizione)</label>
                <textarea id="progetti" name="progetti" rows="4" placeholder="Descrivi brevemente i tuoi progetti più importanti" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="github_url">URL GitHub</label>
                <input type="url" id="github_url" name="github_url" placeholder="https://github.com/tuUsername" required>
            </div>
            
            <div class="form-group">
                <label for="linkedin_url">URL LinkedIn</label>
                <input type="url" id="linkedin_url" name="linkedin_url" placeholder="https://linkedin.com/in/tuUsername" required>
            </div>
            
            <div class="form-group">
                <label for="email_url">Email di contatto</label>
                <input type="email" id="email_url" name="email_url" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            
            <div class="form-group">
                <label for="instagram_url">URL Instagram</label>
                <input type="url" id="instagram_url" name="instagram_url" placeholder="https://instagram.com/tuUsername">
            </div>
            
            <div class="form-group">
                <label for="foto">Foto Profilo</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
                <small>Formato: JPG, JPEG, PNG o GIF. Dimensione massima: 5MB.</small>
            </div>
            
            <button type="submit">Registrati come Ingegnere</button>
        </form>
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