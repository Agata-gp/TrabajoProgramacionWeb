<?php
require('conexion.php');
include 'cabecera.php';

$texto = $_GET['buscar'] ?? '';

$sql = "SELECT * FROM productos 
        WHERE nombre LIKE ? 
        OR descripcion LIKE ?
        OR categoria LIKE ?";

$stmt = $conexion->prepare($sql);

$busqueda = "%$texto%";

$stmt->bind_param("sss", $busqueda, $busqueda, $busqueda);
$stmt->execute();

$productos = $stmt->get_result();
?>

<section>
    <h2>Resultados para "<?php echo htmlspecialchars($texto); ?>"</h2>

    <section class="products">
        <?php while ($producto = $productos->fetch_assoc()): ?>
            <article class="product-card">
                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <strong class="precio-oferta"><?php echo number_format($producto['precio'], 2); ?>€</strong>
                <p class="stock">Stock: <?php echo $producto['stock']; ?></p>

                <?php if ($producto['stock'] > 0): ?>
                    <?php if (isset($_SESSION['login'])): ?>
                        <form method="post" action="carrito_accion.php">
                            <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                            <input type="hidden" name="accion" value="añadir">
                            <input type="hidden" name="volver" value="buscar.php">
                            <button type="submit">Añadir al carrito</button>
                        </form>
                    <?php else: ?>
                        <a href="login.php"><button>Inicia sesión para comprar</button></a>
                    <?php endif; ?>
                <?php else: ?>
                    <button disabled>Sin stock</button>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </section>
</section>

<?php include 'footer.php'; ?>
</body>
</html>