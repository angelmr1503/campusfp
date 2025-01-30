<?php
// conexion con la bd
include('get_user.php');

// obtenemos el id
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // select de los datos del usuario 
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // si no se encuentra
    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit;
    }

    // select de los paquetes del usuario 
    $stmtPaquetes = $pdo->prepare("SELECT id_paquete FROM usuario_paquetes WHERE id_usuario = ?");
    $stmtPaquetes->execute([$id_usuario]);
    $paquetesSeleccionados = $stmtPaquetes->fetchAll(PDO::FETCH_COLUMN);

    // todos los paquetes disponibles
    $stmtTodosPaquetes = $pdo->query("SELECT * FROM paquetes");
    $todosPaquetes = $stmtTodosPaquetes->fetchAll(PDO::FETCH_ASSOC);

    // si no se recibe el id
} else {
    echo "No se ha recibido el ID del usuario.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Editar Usuario</h1>
    </header>
    <!--formulario editar -->
    <section>
        <form action="update_user.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($usuario['edad']); ?>" required>

            <label for="plan">Plan:</label>
            <select name="id_plan" id="plan">
                <option value="1" <?php echo $usuario['id_plan'] == 1 ? 'selected' : ''; ?>>Básico</option>
                <option value="2" <?php echo $usuario['id_plan'] == 2 ? 'selected' : ''; ?>>Estándar</option>
                <option value="3" <?php echo $usuario['id_plan'] == 3 ? 'selected' : ''; ?>>Premium</option>
            </select>

            <label for="paquetes">Paquetes Adicionales:</label>
            <?php foreach ($todosPaquetes as $paquete): ?>
                <div>
                    <input type="checkbox" 
                           id="paquete-<?php echo $paquete['id_paquete']; ?>" 
                           name="paquetes[]" 
                           value="<?php echo $paquete['id_paquete']; ?>" 
                           <?php echo in_array($paquete['id_paquete'], $paquetesSeleccionados) ? 'checked' : ''; ?>>
                    <label for="paquete-<?php echo $paquete['id_paquete']; ?>">
                        <?php echo htmlspecialchars($paquete['nombre']); ?> - <?php echo htmlspecialchars($paquete['precio']); ?>€
                    </label>
                </div>
            <?php endforeach; ?>

            <label for="duracion">Duración de la Suscripción:</label>
            <select name="duracion" id="duracion">
                <option value="mensual" <?php echo $usuario['duracion'] == 'mensual' ? 'selected' : ''; ?>>Mensual</option>
                <option value="anual" <?php echo $usuario['duracion'] == 'anual' ? 'selected' : ''; ?>>Anual</option>
            </select>
            
            <button type="submit">Guardar Cambios</button>
        </form>
    </section>
</body>
<script> 
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("form").addEventListener("submit", function (event) {
            //obtiene los valores del formulario
            let edad = parseInt(document.getElementById("edad").value);
            let plan = parseInt(document.getElementById("plan").value);
            let duracion = document.getElementById("duracion").value;
            let paquetesSeleccionados = document.querySelectorAll("input[name='paquetes[]']:checked");
            let paqueteDeporte = document.getElementById("paquete-1").checked;
            let paqueteInfantil = document.getElementById("paquete-3").checked;

            // (((las restricciones practicamente copiadas igual que en el add_user)))
            // la primera restriccion: los menores de 18a solo pueden contratar el infantil
            if (edad < 18) {
                if (paquetesSeleccionados.length > 1 || !paqueteInfantil) {
                    alert("Los usuarios menores de 18 años solo pueden contratar el Pack Infantil.");
                    event.preventDefault();
                    return false;
                }
            }
            // la segunda restriccion: plan basico solo puede elegir un paquete
            if (plan === 1 && paquetesSeleccionados.length > 1) {
                alert("El Plan Básico solo permite seleccionar un paquete adicional.");
                event.preventDefault();
                return false;
            }
            // tercera restriccion: plan estandar solo puede elegir dos paquetes
            if (plan === 2 && paquetesSeleccionados.length > 2) {
                alert("El Plan Estándar solo permite seleccionar hasta dos paquetes adicionales.");
                event.preventDefault();
                return false;
            }
            // cuarta restriccion: pack deporte solo con sub anual
            if (paqueteDeporte && duracion !== "anual") {
                alert("El Pack Deporte solo puede contratarse con una suscripción anual.");
                event.preventDefault();
                return false;
            }
        });
    });
</script>
</html>
