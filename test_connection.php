<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Manejar GET
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);
        $productos = array();
        while($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        echo json_encode($productos);
        break;

    case 'POST':
        // Manejar POST
        $data = json_decode(file_get_contents('php://input'), true);

        // Verificar que todos los campos estén presentes
        if (isset($data['nombre']) && isset($data['descripcion']) && isset($data['precio']) && isset($data['imagen'])) {
            $nombre = $data['nombre'];
            $descripcion = $data['descripcion'];
            $precio = $data['precio'];
            $imagen = $data['imagen'];

            // Escapar datos para evitar inyecciones SQL
            $nombre = $conn->real_escape_string($nombre);
            $descripcion = $conn->real_escape_string($descripcion);
            $precio = (float)$precio; // Asegurarse de que el precio sea un número
            $imagen = $conn->real_escape_string($imagen);

            $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES ('$nombre', '$descripcion', $precio, '$imagen')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Producto agregado correctamente"]);
            } else {
                echo json_encode(["message" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos"]);
        }
        break;

    case 'PUT':
        // Manejar PUT
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id']) && isset($data['nombre']) && isset($data['descripcion']) && isset($data['precio']) && isset($data['imagen'])) {
            $id = $data['id'];
            $nombre = $data['nombre'];
            $descripcion = $data['descripcion'];
            $precio = $data['precio'];
            $imagen = $data['imagen'];

            $id = (int)$id;
            $nombre = $conn->real_escape_string($nombre);
            $descripcion = $conn->real_escape_string($descripcion);
            $precio = (float)$precio;
            $imagen = $conn->real_escape_string($imagen);

            $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio=$precio, imagen='$imagen' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Producto actualizado correctamente"]);
            } else {
                echo json_encode(["message" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos"]);
        }
        break;

    case 'DELETE':
        // Manejar DELETE
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $sql = "DELETE FROM productos WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Producto eliminado correctamente"]);
            } else {
                echo json_encode(["message" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["message" => "ID no proporcionado"]);
        }
        break;

    default:
        echo json_encode(["message" => "Método no permitido"]);
        break;
}

$conn->close();
?>
