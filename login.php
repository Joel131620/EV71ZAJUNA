<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena']; // Asegúrate de que el nombre del campo sea correcto

    $sql = "SELECT contrasena FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row['contrasena'])) {
            $_SESSION['loggedin'] = true;
            header("Location: screen.html");
            exit();
        } else {
            $error_message = "Contraseña incorrecta.";
        }
    } else {
        $error_message = "No se encontró un usuario con ese email.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Horror</title>
    <link rel="stylesheet" href="desing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <div class="form-content">
            <h1 id="title">Iniciar sesión</h1>
            <form action="login.php" method="post">
                <div class="input-group">
                    <div class="input-field" id="nameInput">
                        <label for="email">
                            <i class="fa-solid fa-envelope"></i>
                            <span class="sr-only">Correo</span>
                        </label>
                        <input type="email" id="email" name="email" placeholder="Correo" required>
                    </div>
                    <div class="input-field">
                        <label for="contrasena">
                            <i class="fa-solid fa-lock"></i>
                            <span class="sr-only">Contraseña</span>
                        </label>
                        <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                    </div>
                </div>
                <?php if (isset($error_message)) : ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <p>Olvidaste tu contraseña? <a href="#">Haz clic aquí</a></p>
                <div class="btn-field">
                    <button type="submit">Acceder</button>
                    <button type="button" onclick="location.href='register.php'">Crear cuenta</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
