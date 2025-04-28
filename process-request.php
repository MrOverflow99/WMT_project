<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mysqli = require __DIR__ . "/database.php";

// Recupero y validación de los datos enviados por el formulario
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$ingegnere = trim($_POST['ingegnere']);
$messaggio = trim($_POST['messaggio']);
$user_id = $_SESSION['user_id']; // ID del usuario que ha iniciado sesión

// Verificar que todos los campos hayan sido completados
if (empty($nome) || empty($email) || empty($ingegnere) || empty($messaggio)) {
    echo "Tutti i campi sono obbligatori.";
    exit();
}

// Preparar la consulta para insertar la solicitud en la base de datos
$stmt = $mysqli->prepare("INSERT INTO richieste (nome_utente, email_utente, ingegnere, messaggio, utente_id) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $nome, $email, $ingegnere, $messaggio, $user_id);

if ($stmt->execute()) {
    echo "<!DOCTYPE html>
    <html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Richiesta Inviata</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <div class='container' style='text-align: center; padding: 50px; max-width: 800px; margin: 0 auto;'>
            <h1>Richiesta inviata con successo!</h1>
            <p>Grazie, $nome. Ti contatteremo al più presto all'indirizzo <strong>$email</strong>.</p>
            <a href='portfolio.php' class='button' style='display: inline-block; margin-top: 20px;'>Torna al portfolio</a>
        </div>
    </body>
    </html>";
} else {
    echo "Errore durante l'invio della richiesta: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>