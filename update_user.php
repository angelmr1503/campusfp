<?php
include 'config.php';  // configuracion bd

// verificar datos formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // obtener los datos
    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];
    $id_plan = $_POST['id_plan'];
    $duracion = $_POST['duracion'];
    $paquetes = isset($_POST['paquetes']) ? $_POST['paquetes'] : [];

    try {
        // actualizar la tabla usuarios
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo, edad = :edad, id_plan = :id_plan, duracion = :duracion WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':id_plan', $id_plan);
        $stmt->bindParam(':duracion', $duracion);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        // eliminar los paquetes del usuario 
        $stmt = $pdo->prepare("DELETE FROM usuario_paquetes WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        // insert con los nuevos paquetes
        if (!empty($paquetes)) {
            foreach ($paquetes as $id_paquete) {
                $stmt = $pdo->prepare("INSERT INTO usuario_paquetes (id_usuario, id_paquete) VALUES (:id_usuario, :id_paquete)");
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(':id_paquete', $id_paquete, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        echo "Usuario actualizado correctamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // despues de 2seg redirige a la pag principal
    header("refresh:2;url=index.php");
    exit();
}
?>
