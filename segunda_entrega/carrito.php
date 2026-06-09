<?php
require('conexion.php');

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare("SELECT id_carrito FROM carrito WHERE id_usuario = ? AND estado = 'activo' LIMIT 1");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$carrito = $stmt->get_result()->fetch_assoc();

$productos_carrito = [];
$total_precio = 0;

if ($carrito) {
    $id_carrito = $carrito['id_carrito'];
    $sql = "SELECT cp.id_carrito_producto, cp.cantidad, p.id_producto, p.nombre, p.precio, p.imagen
            FROM carrito_productos cp
            JOIN productos p ON cp.id_producto = p.id_producto
            WHERE cp.id_carrito = ?";
    $stmt2 = $conexion->prepare($sql);
    $stmt2->bind_param("i", $id_carrito);
    $stmt2->execute();
    $res = $stmt2->get_result();
    while ($row = $res->fetch_assoc()) {
        $productos_carrito[] = $row;
        $total_precio += $row['precio'] * $row['cantidad'];
    }
}
?>

<?php include 'cabecera.php'; ?>
<article class="carrito-panel">
    <h2 class="titulo">Tu carrito</h2>

    <?php if (empty($productos_carrito)): ?>
        <p>Tu carrito está vacío. <a href="index.php">Seguir comprando</a></p>
    <?php else: ?>
        <table class="tabla-carrito">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos_carrito as $item): ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="" style="width:50px;height:auto;">
                            <?php echo htmlspecialchars($item['nombre']); ?>
                        </td>
                        <td><?php echo number_format($item['precio'], 2); ?>€</td>
                        <td>
                            <form method="post" action="carrito_accion.php" style="display:flex;gap:5px;align-items:center;">
                                <input type="hidden" name="accion" value="actualizar">
                                <input type="hidden" name="id_carrito_producto" value="<?php echo $item['id_carrito_producto']; ?>">
                                <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="0" style="width:60px;">
                                <button type="submit">✔</button>
                            </form>
                        </td>
                        <td><?php echo number_format($item['precio'] * $item['cantidad'], 2); ?>€</td>
                        <td>
                            <form method="post" action="carrito_accion.php">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_carrito_producto" value="<?php echo $item['id_carrito_producto']; ?>">
                                <button type="submit" class="btn-eliminar">🗑 Quitar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <section class="carrito-total">
            <p><strong>Total: <?php echo number_format($total_precio, 2); ?>€</strong></p>
            <a href="index.php"><button>Seguir comprando</button></a>
            <form method="post" action="carrito_accion.php">
                <input type="hidden" name="accion" value="pagar">
                <button type="submit">Proceder al pago</button>
            </form>
        </section>
    <?php endif; ?>
</article>
<?php include 'footer.php'; ?>
</body>
</html>