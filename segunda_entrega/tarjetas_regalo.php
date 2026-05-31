<?php
require('conexion.php');

$categoria = 'tarjetas';
$sql = "SELECT * FROM productos WHERE categoria = ? ORDER BY precio ASC";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $categoria);
$stmt->execute();
$productos = $stmt->get_result();
?>

<?php include 'cabecera.php'; ?>

<main>
    <h2>Tarjetas Regalo</h2>

    <?php if (isset($_GET['msg'])): ?>
        <p class="msg-ok"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>

    <section class="products">
        <?php while ($producto = $productos->fetch_assoc()): ?>
            <article class="product-card">
                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <strong><?php echo number_format($producto['precio'], 2); ?>€</strong>

                <?php if (isset($_SESSION['login'])): ?>
                    <form method="post" action="carrito_accion.php">
                        <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                        <input type="hidden" name="accion" value="añadir">
                        <input type="hidden" name="volver" value="tarjetasRegalo.php">
                        <button type="submit">Añadir al carrito</button>
                    </form>
                <?php else: ?>
                    <a href="login.php"><button>Inicia sesión para comprar</button></a>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
