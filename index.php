<?php
// conexion a la base de datos y la consulta
include('get_user.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>STREAMWEB</h1>
    </header>

    <!-- primer "div" para añadir usuario -->
    <section>
        <h2>Gestión de Usuarios</h2>
        <a href="add_user.html">
            <button>Añadir Usuario</button>
        </a>
    </section>

    <!-- la lista con los usuarios -->
    <section>
        <h2>Usuarios Registrados</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Edad</th>
                <th>Plan</th>
                <th>Duración</th>
                <th>Paquetes</th>
                <th>Costo Mensual</th>
            </tr>

            <!-- para mostrar los usuarios dinamicamente -->
            <?php if (isset($usuarios) && !empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <?php
                    $preciosPlanes = [1 => 9.99, 2 => 13.99, 3 => 17.99];
                    $preciosPaquetes = [1 => 6.99, 2 => 7.99, 3 => 4.99];

                    // calculo del costo mensual
                    $costoPlan = $preciosPlanes[$usuario['id_plan']] ?? 0;
                    $costoPaquetes = 0;
                    if (!empty($usuario['paquetes'])) {
                        foreach ($usuario['paquetes'] as $paquete) {
                            // nos aseguramos de que el paquete exista en los precios
                            $costoPaquetes += $preciosPaquetes[array_search($paquete, ['Deporte', 'Cine', 'Infantil']) + 1] ?? 0;
                        }
                    }
                    $costoTotal = $costoPlan + $costoPaquetes;
                    ?>
                    <tr data-user-id="<?php echo $usuario['id_usuario']; ?>">
                        <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['edad']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['id_plan']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['duracion']); ?></td>
                        <td><?php echo htmlspecialchars(implode(', ', $usuario['paquetes'])); ?></td>
                        <td><?php echo number_format($costoTotal, 2) . '€'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No se encontraron usuarios</td>
                </tr>
            <?php endif; ?>
        </table>

        <!-- seccion oculta, con editar y eliminar -->
        <div id="acciones" style="display: none; margin-top: 20px;">
            <h3>Acciones</h3>
            <div class="botones">
                <a id="editarUsuario" href="#"><button>Editar Usuario</button></a>
                <a id="eliminarUsuario" href="#"><button>Eliminar Usuario</button></a>
            </div>
        </div>
    </section>

    <!-- script para manejar la selección de usuarios -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filas = document.querySelectorAll("table tr[data-user-id]");
            const acciones = document.getElementById("acciones");
            const editarUsuario = document.getElementById("editarUsuario");
            const eliminarUsuario = document.getElementById("eliminarUsuario");

            let usuarioSeleccionado = null;

            // para el efecto de clic
            filas.forEach(fila => {
                fila.addEventListener("click", function () {
                    // quitar la clase para el efecto
                    filas.forEach(f => f.classList.remove("seleccionado"));

                    // agregarla a la que este clickeada
                    fila.classList.add("seleccionado");

                    // coger el id
                    usuarioSeleccionado = fila.getAttribute("data-user-id");

                    // y mostrar las opciones
                    acciones.style.display = "block";

                    // ruta de los botones
                    editarUsuario.href = `edit_user.php?id=${usuarioSeleccionado}`;
                    eliminarUsuario.href = `delete_user.php?id=${usuarioSeleccionado}`;
                });
            });

            // eliminar el efecto al hacer clic fuera
            document.addEventListener("click", function (event) {
                if (!event.target.closest("table") && !event.target.closest("#acciones")) {
                    filas.forEach(f => f.classList.remove("seleccionado"));
                    acciones.style.display = "none";
                    usuarioSeleccionado = null;
                }
            });
        });
    </script>
</body>
</html>
