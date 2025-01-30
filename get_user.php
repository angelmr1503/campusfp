<?php
// get_user.php
include 'config.php'; // conexion con la bd

try {
    // select para obtener los usuarios
    $stmtUsuarios = $pdo->query("SELECT * FROM usuarios");
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuarios as $key => $usuario) {
        // y los paquetes de cada usuario
        $stmtPaquetes = $pdo->prepare(
            "SELECT p.nombre 
             FROM usuario_paquetes up
             INNER JOIN paquetes p ON up.id_paquete = p.id_paquete
             WHERE up.id_usuario = ?"
        );
        $stmtPaquetes->execute([$usuario['id_usuario']]);
        $usuarios[$key]['paquetes'] = $stmtPaquetes->fetchAll(PDO::FETCH_COLUMN); // Almacena los nombres de los paquetes
    }
    // cualquier otra cosa, error
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

?>
