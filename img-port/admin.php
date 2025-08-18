<?php
session_start();

// Protección simple con contraseña (cambia 'adminpass' por algo seguro)
$password = 'adminpass';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_POST['password']) && $_POST['password'] === $password) {
        $_SESSION['logged_in'] = true;
    } else {
        echo '<form method="post"><input type="password" name="password" placeholder="Contraseña"><button type="submit">Iniciar Sesión</button></form>';
        exit;
    }
}

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $newProject = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],  // Por ejemplo, puedes añadir lógica de carga de archivos más adelante
        'link' => $_POST['link'],
        'techs' => explode(',', $_POST['techs'])  // Ejemplo: "fab fa-react,fab fa-node-js"
    ];

    $projects = json_decode(file_get_contents('projects.json'), true);
    $projects[] = $newProject;
    file_put_contents('projects.json', json_encode($projects, JSON_PRETTY_PRINT));

    echo '<p>¡Proyecto añadido exitosamente!</p>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="styles.css"> <!-- Reutiliza tu CSS -->
</head>
<body>
    <h1>Panel de Control - Añadir Proyecto</h1>
    <form method="post">
        <label>Título: <input type="text" name="title" required></label><br>
        <label>Descripción: <textarea name="description" required></textarea></label><br>
        <label>URL de Imagen: <input type="text" name="image" required></label><br>
        <label>Enlace: <input type="text" name="link" required></label><br>
        <label>Tecnologías (separadas por coma, ej., fab fa-react,fab fa-node-js): <input type="text" name="techs" required></label><br>
        <button type="submit">Añadir Proyecto</button>
    </form>
    <a href="index.php">Volver al Portafolio</a>
</body>
</html>