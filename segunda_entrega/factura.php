<?php
require('conexion.php');

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$id_pedido  = (int)($_GET['id'] ?? 0);
$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare(
    "SELECT p.id_pedido, p.fecha, p.total, p.estado, u.nombre, u.email
     FROM pedidos p
     JOIN usuarios u ON p.id_usuario = u.id_usuario
     WHERE p.id_pedido = ?
       AND (p.id_usuario = ? OR ? = 'admin')"
);
$rol = $_SESSION['rol'] ?? 'cliente';
$stmt->bind_param("iis", $id_pedido, $id_usuario, $rol);
$stmt->execute();
$pedido = $stmt->get_result()->fetch_assoc();

if (!$pedido) {
    header("Location: index.php");
    exit();
}

$stmt2 = $conexion->prepare(
    "SELECT nombre_producto, precio_unitario, cantidad,
            (precio_unitario * cantidad) AS subtotal
     FROM pedido_productos WHERE id_pedido = ?"
);
$stmt2->bind_param("i", $id_pedido);
$stmt2->execute();
$lineas = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<?php include 'cabecera.php'; ?>

<article class="factura-panel">
    <section class="factura-cabecera">
        <div class="factura-logo">
            <h2>CyberLoot</h2>
            <p>Videojuegos, skins y contenido digital instantáneo</p>
            <p>inventado@gmail.com · +1 234 567 890</p>
        </div>
        <div class="factura-meta">
            <h3>FACTURA</h3>
            <p><strong>Nº:</strong> <?php echo str_pad($pedido['id_pedido'], 6, '0', STR_PAD_LEFT); ?></p>
            <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></p>
            <p><strong>Estado:</strong>
                <span class="estado-<?php echo $pedido['estado']; ?>">
                    <?php echo ucfirst($pedido['estado']); ?>
                </span>
            </p>
        </div>
    </section>

    <section class="factura-cliente">
        <h4>Facturado a:</h4>
        <p><?php echo htmlspecialchars($pedido['nombre']); ?></p>
        <p><?php echo htmlspecialchars($pedido['email']); ?></p>
    </section>

    <table class="factura-tabla">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio unit.</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lineas as $linea): ?>
            <tr>
                <td><?php echo htmlspecialchars($linea['nombre_producto']); ?></td>
                <td><?php echo number_format($linea['precio_unitario'], 2); ?> €</td>
                <td><?php echo $linea['cantidad']; ?></td>
                <td><?php echo number_format($linea['subtotal'], 2); ?> €</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>TOTAL</strong></td>
                <td><strong><?php echo number_format($pedido['total'], 2); ?> €</strong></td>
            </tr>
        </tfoot>
    </table>

    <section class="factura-acciones no-print">
        <button onclick="window.print()">Imprimir / Guardar PDF</button>
        <a href="mis_pedidos.php"><button>Mis pedidos</button></a>
        <a href="index.php"><button>Inicio</button></a>
    </section>

    <p class="factura-pie">Gracias por tu compra en CyberLoot. Este documento sirve como justificante de pago.</p>
</article>

<?php include 'footer.php'; ?>
</body>
</html>