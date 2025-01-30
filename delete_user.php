<?php
include 'config.php';  // conexion con la bd

// verifica el parametro del id y si es numero
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];  // Obtener el id del usuario

    // imprime el id recibido
    echo "ID recibido: " . $id_usuario . "<br>";

    try {
        // elimina en la tabla usuarios_paquetes
        $stmt = $pdo->prepare("DELETE FROM usuario_paquetes WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        // elimina en la tabla usuarios
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        // si se elimina / si no 
        if ($stmt->execute()) {
            echo "Usuario eliminado correctamente.";
        } else {
            echo "Error al eliminar el usuario.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID no válido.";
}

// cuando pasen 2seg, redirige a el index
header("refresh:2;url=index.php");
exit();
?>
