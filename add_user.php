<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // coger los datos del formulario
    $nombre = $_POST['nombre'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $edad = $_POST['edad'] ?? null;
    $plan = $_POST['plan'] ?? null;
    $paquetes = $_POST['paquetes'] ?? []; // hace array de los paquetes seleccionados
    $duracion = $_POST['duracion'] ?? null;

    // validar datos basicos
    if (!$nombre || !$correo || !$edad || !$plan || !$duracion) {
        die("Error: Faltan datos obligatorios.");
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("Error: El correo electrónico no es válido.");
    }

    if (!is_numeric($edad) || $edad < 1) {
        die("Error: La edad debe ser un número positivo.");
    }

    if (!in_array($plan, [1, 2, 3])) {
        die("Error: El plan seleccionado no es válido.");
    }

    if (!in_array($duracion, ['Mensual', 'Anual'])) {
        die("Error: La duración seleccionada no es válida.");
    }

    // validar los paquetes 
    foreach ($paquetes as $paquete) {
        if (!in_array($paquete, [1, 2, 3])) {
            die("Error: Uno o más paquetes seleccionados no son válidos.");
        }
    }

    // las restricciones que ya hay en el javascript pero en este caso para el php (backend)
    // las otras son para el front, estas nos asegura que no se vulneren
    if ($edad < 18 && !in_array(3, $paquetes)) {
        die("Error: Los usuarios menores de 18 años solo pueden contratar el Pack Infantil.");
    }
   
    if ($plan == 1 && count($paquetes) > 1) {
        die("Error: Los usuarios del Plan Básico solo pueden seleccionar un paquete adicional.");
    }
    
    if (in_array(1, $paquetes) && $duracion != "Anual") {
        die("Error: El Pack Deporte solo puede ser contratado si la duración de la suscripción es de 1 año.");
    }

    // conexion con la base de datos
    require_once 'config.php';

    try {
        $pdo->beginTransaction();

        // ver si existe el correo
        $queryVerificarCorreo = "SELECT id_usuario FROM usuarios WHERE correo = ?";
        $stmtVerificarCorreo = $pdo->prepare($queryVerificarCorreo);
        $stmtVerificarCorreo->execute([$correo]);

        if ($stmtVerificarCorreo->fetch()) {
            die("Error: El correo electrónico ya está registrado.");
        }

        // para insertar el ususario
        $queryInsertar = "INSERT INTO usuarios (nombre, correo, edad, id_plan, duracion) VALUES (?, ?, ?, ?, ?)";
        $stmtInsertar = $pdo->prepare($queryInsertar);
        $stmtInsertar->execute([$nombre, $correo, $edad, $plan, $duracion]);

        $id_usuario = $pdo->lastInsertId();

        // y este para los paquetes 
        if (!empty($paquetes)) {
            $queryPaquete = "INSERT INTO usuario_paquetes (id_usuario, id_paquete) VALUES (?, ?)";
            $stmtPaquete = $pdo->prepare($queryPaquete);

            foreach ($paquetes as $id_paquete) {
                $stmtPaquete->execute([$id_usuario, $id_paquete]);
            }
        }

        $pdo->commit();

        // se redirige a la pagina principal 
        $_SESSION['mensaje'] = "Usuario añadido correctamente.";
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error al guardar los datos: " . $e->getMessage());
    }
} else {
    // si se accede mediante otro metodo que no sea el de post
    echo "Método HTTP no permitido.";
}
?>
