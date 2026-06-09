<?php
require('conexion.php');

$categoria = 'videojuegos';

$sql = "SELECT * FROM productos WHERE categoria = ? ORDER BY nombre ASC";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $categoria);
$stmt->execute();

$productos = $stmt->get_result();
?>

<?php include 'cabecera.php'; ?>

<h2 class="titulo">Videojuegos</h2>

<?php if (isset($_GET['msg'])): ?>
    <p class="msg-ok"><?php echo htmlspecialchars($_GET['msg']); ?></p>
<?php endif; ?>

<section class="products">

    <?php while ($producto = $productos->fetch_assoc()): ?>

        <article class="product-card">

            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>"
                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>">

            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>

            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>

            <strong>
                <?php echo number_format($producto['precio'], 2); ?>€
            </strong>

            <p class="stock">
                Stock: <?php echo $producto['stock']; ?>
            </p>

            <?php if ($producto['stock'] > 0): ?>

                <?php if (isset($_SESSION['login'])): ?>

                    <form method="post" action="carrito_accion.php">

                        <input type="hidden"
                               name="id_producto"
                               value="<?php echo $producto['id_producto']; ?>">

                        <input type="hidden"
                               name="accion"
                               value="añadir">

                        <input type="hidden"
                               name="volver"
                               value="videojuegos.php">

                        <button type="submit">
                            Añadir al carrito
                        </button>

                    </form>

                <?php else: ?>

                    <a href="login.php">
                        <button type="button">
                            Inicia sesión para comprar
                        </button>
                    </a>

                <?php endif; ?>

            <?php else: ?>

                <button type="button" disabled>
                    Sin stock
                </button>

            <?php endif; ?>

        </article>

    <?php endwhile; ?>

</section>

<?php include 'footer.php'; ?>
</body>
</html>