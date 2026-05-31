<?php
require('conexion.php');

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$mensaje = '';


if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}


if (isset($_POST['editar'])) {
    $nuevo_nombre = trim($_POST['nombre']);
    if ($nuevo_nombre !== '') {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ? WHERE id_usuario = ?");
        $stmt->bind_param("si", $nuevo_nombre, $id_usuario);
        $stmt->execute();
        $_SESSION['nombre'] = $nuevo_nombre;
        $mensaje = 'Perfil actualizado correctamente.';
    }
}


$stmt = $conexion->prepare("SELECT nombre, email, rol FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
?>

<?php include 'cabecera.php'; ?>

<main>
    <h2>Perfil de <?php echo htmlspecialchars($usuario['nombre']); ?></h2>

    <?php if ($mensaje): ?>
        <p class="msg-ok"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <section class="perfil-info">
        <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        <p><strong>Rol:</strong> <?php echo htmlspecialchars($usuario['rol']); ?></p>
    </section>

    <section class="perfil-editar">
        <h3>Editar nombre</h3>
        <form method="post">
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            <button type="submit" name="editar">Guardar cambios</button>
        </form>
    </section>

    <section class="perfil-acciones">
        <a href="carrito.php"><button>Ver mi carrito</button></a>
        <?php if ($usuario['rol'] === 'admin'): ?>
            <a href="admin.php"><button>Panel de administración</button></a>
        <?php endif; ?>
        <form method="post" style="display:inline;">
            <button type="submit" name="logout" class="btn-eliminar">Cerrar sesión</button>
        </form>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
