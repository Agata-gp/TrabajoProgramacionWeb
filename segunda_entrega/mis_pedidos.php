<?php
require('conexion.php');

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare(
    "SELECT id_pedido, fecha, total, estado
     FROM pedidos WHERE id_usuario = ? ORDER BY fecha DESC"
);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$pedidos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<?php include 'cabecera.php'; ?>

<article class="admin-panel">
    <h2 class="titulo">📋 Mis pedidos</h2>

    <?php if (empty($pedidos)): ?>
        <p style="text-align:center;margin-top:30px;">Aún no has realizado ningún pedido. <a href="index.php" style="color:#39FF88;">Empieza a comprar</a></p>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;background:#0b1220;border-radius:18px;overflow:hidden;">
        <thead>
            <tr>
                <th style="background:#050814;color:#39FF88;padding:16px;">Nº Pedido</th>
                <th style="background:#050814;color:#39FF88;padding:16px;">Fecha</th>
                <th style="background:#050814;color:#39FF88;padding:16px;">Total</th>
                <th style="background:#050814;color:#39FF88;padding:16px;">Estado</th>
                <th style="background:#050814;color:#39FF88;padding:16px;">Factura</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $p): ?>
            <tr style="border-bottom:1px solid rgba(0,212,255,0.22);text-align:center;">
                <td style="padding:14px;">#<?php echo str_pad($p['id_pedido'], 6, '0', STR_PAD_LEFT); ?></td>
                <td style="padding:14px;"><?php echo date('d/m/Y H:i', strtotime($p['fecha'])); ?></td>
                <td style="padding:14px;"><?php echo number_format($p['total'], 2); ?> €</td>
                <td style="padding:14px;">
                    <span class="estado-<?php echo $p['estado']; ?>"><?php echo ucfirst($p['estado']); ?></span>
                </td>
                <td style="padding:14px;">
                    <a href="factura.php?id=<?php echo $p['id_pedido']; ?>">
                        <button>🧾 Ver factura</button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <section style="text-align:center;margin-top:30px;">
        <a href="perfil.php"><button>← Volver al perfil</button></a>
    </section>
</article>

<?php include 'footer.php'; ?>
</body>
</html>