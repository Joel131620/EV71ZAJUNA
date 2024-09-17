<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellidos'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $tarjeta_credito = $_POST['tarjetadecredito'];
    $contrasena = $_POST['contraseña'];
    $confirmar_contrasena = $_POST['confirmalacontraseña'];

    // Validar si las contraseñas coinciden
    if ($contrasena !== $confirmar_contrasena) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT); // Encriptar la contraseña

        $sql = "INSERT INTO usuarios (nombre, apellido, email, edad, tarjeta_credito, contrasena)
                VALUES ('$nombre', '$apellido', '$email', '$edad', '$tarjeta_credito', '$contrasena_hash')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Registro exitoso. <a href='login.php'>Iniciar sesión</a>";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Rock</title>
    <link rel="stylesheet" href="crearcuenta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <div class="form-content">
            <h1 id="title">Crear cuenta</h1>
            <form action="register.php" method="post">
                <div class="input-group">
                    <div class="input-field" id="nameInput">
                        <label for="nombres">
                            <i class="fa-solid fa-id-card"></i>
                            <span class="sr-only">Nombre</span>
                        </label>
                        <input type="text" name="nombres" id="nombres" placeholder="Nombre" required>
                    </div>
                    <div class="input-field">
                        <label for="apellidos">
                            <i class="fa-solid fa-id-card"></i>
                            <span class="sr-only">Apellido</span>
                        </label>
                        <input type="text" name="apellidos" id="apellidos" placeholder="Apellido" required>
                    </div>
                    <div class="input-field">
                        <label for="email">
                            <i class="fa-solid fa-envelope"></i>
                            <span class="sr-only">Email</span>
                        </label>
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="input-field">
                        <label for="edad">
                            <i class="fa fa-address-book" aria-hidden="true"></i>
                            <span class="sr-only">Edad</span>
                        </label>
                        <input type="text" name="edad" id="edad" placeholder="Edad" maxlength="2" required pattern="\d{1,2}">
                    </div>
                    <div class="input-field">
                        <label for="tarjetadecredito">
                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            <span class="sr-only">Número de tarjeta de crédito</span>
                        </label>
                        <input type="text" name="tarjetadecredito" id="tarjetadecredito" placeholder="Número de tarjeta de crédito" maxlength="16" required pattern="\d{16}">
                    </div>
                    <div class="input-field">
                        <label for="contraseña">
                            <i class="fa-solid fa-lock"></i>
                            <span class="sr-only">Contraseña</span>
                        </label>
                        <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" required>
                    </div>
                    <div class="input-field">
                        <label for="confirmalacontraseña">
                            <i class="fa-solid fa-lock"></i>
                            <span class="sr-only">Confirmar contraseña</span>
                        </label>
                        <input type="password" name="confirmalacontraseña" id="confirmalacontraseña" placeholder="Confirma la contraseña" required>
                    </div>
                </div>

                <?php if (isset($error_message)) : ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <?php if (isset($success_message)) : ?>
                    <p style="color: green;"><?php echo $success_message; ?></p>
                <?php endif; ?>

                <p><a href="login.php">¿Ya tienes cuenta?</a></p>

                <div class="btn-field">
                    <button type="submit">Registrarse</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
