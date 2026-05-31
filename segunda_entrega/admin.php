<?php
require('conexion.php');

// Solo admin puede acceder
if (!isset($_SESSION['login']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$mensaje = '';
$error = '';

// ==================== CREATE ====================
if (isset($_POST['crear'])) {
    $nombre      = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio      = (float)$_POST['precio'];
    $stock       = (int)$_POST['stock'];
    $categoria   = $_POST['categoria'];
    $imagen      = trim($_POST['imagen']);

    if ($nombre && $precio > 0) {
        $stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria, imagen) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $stock, $categoria, $imagen);
        $stmt->execute();
        $mensaje = "Producto «$nombre» creado correctamente.";
    } else {
        $error = "El nombre y el precio son obligatorios.";
    }
}

// ==================== UPDATE ====================
if (isset($_POST['actualizar'])) {
    $id          = (int)$_POST['id_producto'];
    $nombre      = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio      = (float)$_POST['precio'];
    $stock       = (int)$_POST['stock'];
    $categoria   = $_POST['categoria'];
    $imagen      = trim($_POST['imagen']);

    $stmt = $conexion->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria=?, imagen=? WHERE id_producto=?");
    $stmt->bind_param("ssdissi", $nombre, $descripcion, $precio, $stock, $categoria, $imagen, $id);
    $stmt->execute();
    $mensaje = "Producto actualizado correctamente.";
}

// ==================== DELETE ====================
if (isset($_POST['eliminar'])) {
    $id = (int)$_POST['id_producto'];
    // Eliminar de carritos primero
    $conexion->prepare("DELETE cp FROM carrito_productos cp JOIN carrito c ON cp.id_carrito = c.id_carrito WHERE cp.id_producto = ?")->execute();
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $mensaje = "Producto eliminado.";
}

// ==================== LEER TODOS ====================
$todos = $conexion->query("SELECT * FROM productos ORDER BY categoria, nombre");

// ==================== EDITAR: cargar datos de 1 producto ====================
$editando = null;
if (isset($_GET['editar'])) {
    $id_e = (int)$_GET['editar'];
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id_e);
    $stmt->execute();
    $editando = $stmt->get_result()->fetch_assoc();
}
?>

<?php include 'cabecera.php'; ?>

<article class="admin-panel">
    <h2 class="titulo">Panel de Administración — Productos</h2>

    <?php if ($mensaje): ?><p class="msg-ok"><?php echo $mensaje; ?></p><?php endif; ?>
    <?php if ($error):   ?><p class="msg-error"><?php echo $error; ?></p><?php endif; ?>

    <!-- FORMULARIO CREAR / EDITAR -->
    <section class="admin-form">
        <h3><?php echo $editando ? 'Editar producto' : 'Nuevo producto'; ?></h3>
        <form method="post">
            <?php if ($editando): ?>
                <input type="hidden" name="id_producto" value="<?php echo $editando['id_producto']; ?>">
            <?php endif; ?>

            <label>Nombre *
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($editando['nombre'] ?? ''); ?>" required>
            </label>

            <label>Descripción
                <textarea name="descripcion"><?php echo htmlspecialchars($editando['descripcion'] ?? ''); ?></textarea>
            </label>

            <label>Precio (€) *
                <input type="number" name="precio" step="0.01" min="0" value="<?php echo $editando['precio'] ?? ''; ?>" required>
            </label>

            <label>Stock
                <input type="number" name="stock" min="0" value="<?php echo $editando['stock'] ?? 0; ?>">
            </label>

            <label>Categoría
                <select name="categoria">
                    <?php
                    $cats = ['videojuegos','tarjetas','skins','otros'];
                    foreach ($cats as $cat):
                        $sel = (($editando['categoria'] ?? '') === $cat) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $cat; ?>" <?php echo $sel; ?>><?php echo ucfirst($cat); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>Imagen (ruta o URL)
                <input type="text" name="imagen" value="<?php echo htmlspecialchars($editando['imagen'] ?? ''); ?>">
            </label>

            <?php if ($editando): ?>
                <button type="submit" name="actualizar">Guardar cambios</button>
                <a href="admin.php"><button type="button">Cancelar</button></a>
            <?php else: ?>
                <button type="submit" name="crear">Crear producto</button>
            <?php endif; ?>
        </form>
    </section>

    <!-- TABLA DE PRODUCTOS -->
    <section class="admin-tabla">
        <h3>Todos los productos</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($p = $todos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $p['id_producto']; ?></td>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                        <td><?php echo number_format($p['precio'], 2); ?>€</td>
                        <td><?php echo $p['stock']; ?></td>
                        <td>
                            <a href="admin.php?editar=<?php echo $p['id_producto']; ?>">
                                <button>✏ Editar</button>
                            </a>
                            <form method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar este producto?')">
                                <input type="hidden" name="id_producto" value="<?php echo $p['id_producto']; ?>">
                                <button type="submit" name="eliminar" class="btn-eliminar">🗑 Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</article>

<?php include 'footer.php'; ?>
</body>
</html>
