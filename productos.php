<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php'; // Aquí cambiamos a db.php

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conn, $sql); // Cambié $conexion por $conn
        $productos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $productos[] = $row;
        }

        echo json_encode($productos);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (isset($data['nombre'], $data['descripcion'], $data['precio'], $data['imagen'])) {
            $nombre = $data['nombre'];
            $descripcion = $data['descripcion'];
            $precio = $data['precio'];
            $imagen = $data['imagen'];

            $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES ('$nombre', '$descripcion', '$precio', '$imagen')";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['message' => 'Producto agregado correctamente']);
            } else {
                echo json_encode(['message' => 'Error al agregar producto']);
            }
        } else {
            echo json_encode(['message' => 'Datos incompletos']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (isset($data['id'], $data['nombre'], $data['descripcion'], $data['precio'], $data['imagen'])) {
            $id = $data['id'];
            $nombre = $data['nombre'];
            $descripcion = $data['descripcion'];
            $precio = $data['precio'];
            $imagen = $data['imagen'];

            $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', imagen='$imagen' WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['message' => 'Producto actualizado correctamente']);
            } else {
                echo json_encode(['message' => 'Error al actualizar producto']);
            }
        } else {
            echo json_encode(['message' => 'Datos incompletos']);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "DELETE FROM productos WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['message' => 'Producto eliminado correctamente']);
            } else {
                echo json_encode(['message' => 'Error al eliminar producto']);
            }
        } else {
            echo json_encode(['message' => 'ID no especificado']);
        }
        break;

    default:
        echo json_encode(['message' => 'Método no permitido']);
        break;
}

mysqli_close($conn); // Cambié $conexion por $conn
?>
