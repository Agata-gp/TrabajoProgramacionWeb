<?php
require('conexion.php');

$sql = "SELECT * FROM productos WHERE precio < 15 ORDER BY precio ASC";
$resultado = $conexion->query($sql);
?>

<?php include 'cabecera.php'; ?>

    <h2 class="titulo">Ofertas</h2>
    <p id="oferta">Productos por menos de 15€</p>


    <?php if (isset($_GET['msg'])): ?>
        <p class="msg-ok"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>

    <section class="products">
        <?php while ($producto = $resultado->fetch_assoc()): ?>
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
                            <input type="hidden" name="volver" value="ofertas.php">
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

<?php include 'footer.php'; ?>
</body>
</html>