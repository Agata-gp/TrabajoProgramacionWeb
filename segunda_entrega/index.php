<?php require 'conexion.php'; 
$productosDestacados = $conexion->query("
    SELECT * 
    FROM productos 
    WHERE categoria = 'videojuegos'
    LIMIT 3
");

$skinsPopulares = $conexion->query("
    SELECT * 
    FROM productos 
    WHERE categoria = 'skins'
    LIMIT 3
");
?>
<?php require 'cabecera.php'; ?>


<section id="main-section">

    <aside id="enlaces">
        <h2>Enlaces de interés</h2>

        <ul>
            <li><a href="https://store.steampowered.com/" target="_blank">Steam</a></li>
            <li><a href="https://store.epicgames.com/" target="_blank">Epic Games</a></li>
            <li><a href="https://www.playstation.com/" target="_blank">PlayStation Store</a></li>
            <li><a href="https://www.xbox.com/" target="_blank">Xbox Store</a></li>
            <li><a href="https://www.nintendo.com/" target="_blank">Nintendo eShop</a></li>
            <li><a href="#">Soporte técnico</a></li>
            <li><a href="#">FAQ</a></li>
        </ul>
    </aside>

    <section id="middle-section">

        <article class="card">
            <h2 class="card-title">Semana Gamer</h2>
            <p class="card-text">Descuentos en videojuegos digitales, tarjetas regalo, skins y suscripciones.</p>
            <a href="ofertas.php"><button>Ver descuentos</button></a>
        </article>

        <article>
            <h2>Productos destacados</h2>

            <section class="products">
                <?php while ($producto = $productosDestacados->fetch_assoc()): ?>
                    <article class="product-card">
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <strong><?php echo number_format($producto['precio'], 2); ?>€</strong>

                        <?php if (isset($_SESSION['login'])): ?>
                            <form method="post" action="carrito_accion.php">
                                <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                <input type="hidden" name="accion" value="añadir">
                                <input type="hidden" name="volver" value="index.php">
                                <button type="submit">Añadir al carrito</button>
                            </form>
                        <?php else: ?>
                            <a href="login.php"><button>Inicia sesión para comprar</button></a>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </section>

        </article>

        <article>
            <h2>Skins populares</h2>

                <section class="products">
                    <?php while ($skin = $skinsPopulares->fetch_assoc()): ?>
                        <article class="product-card">
                            <img src="<?php echo htmlspecialchars($skin['imagen']); ?>" alt="<?php echo htmlspecialchars($skin['nombre']); ?>">
                            <h3><?php echo htmlspecialchars($skin['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($skin['descripcion']); ?></p>
                            <strong><?php echo number_format($skin['precio'], 2); ?>€</strong>

                            <?php if (isset($_SESSION['login'])): ?>
                                <form method="post" action="carrito_accion.php">
                                    <input type="hidden" name="id_producto" value="<?php echo $skin['id_producto']; ?>">
                                    <input type="hidden" name="accion" value="añadir">
                                    <input type="hidden" name="volver" value="index.php">
                                    <button type="submit">Añadir al carrito</button>
                                </form>
                            <?php else: ?>
                                <a href="login.php"><button>Inicia sesión para comprar</button></a>
                            <?php endif; ?>
                        </article>
                    <?php endwhile; ?>
                </section>
        </article>

    </section>

    <aside>
        <section id="mapa-lateral">
            <h2>Tu tienda más cercana</h2>
            <p id="mensaje-tienda">Buscando tienda cercana...</p>

            <iframe
                id="mapa-google"
                width="100%"
                height="220"
                loading="lazy">
            </iframe>
        </section>
    </aside>

</section>

<section id="calendario-estrenos">
    <header class="calendario-header">
        <h2>Calendario <span>de estrenos</span></h2>
    </header>

    <section class="lista-estrenos">
        <article class="estreno">
            <img src="imagenes/bioshock.jpg" alt="Portada Bioshock">
            <p><strong>28</strong> <span>Abril</span></p>
        </article>

        <article class="estreno">
            <img src="imagenes/marioGalaxy.jpg" alt="Portada Mario Galaxy">
            <p><strong>28</strong> <span>Abril</span></p>
        </article>

        <article class="estreno">
            <img src="imagenes/doom.jpg" alt="Portada Doom">
            <p><strong>29</strong> <span>Abril</span></p>
        </article>

        <article class="estreno">
            <img src="imagenes/mickeyGame.jpg" alt="Portada Mickey Game">
            <p><strong>30</strong> <span>Abril</span></p>
        </article>

        <article class="estreno">
            <img src="imagenes/farcry.jpg" alt="Portada Far Cry">
            <p><strong>30</strong> <span>Abril</span></p>
        </article>
    </section>
</section>

<section id="opiniones">
    <h2>Opiniones de clientes</h2>

    <section class="opiniones">
        <article class="review-card">
            <h3>Ana Martínez</h3>
            <p class="stars">★★★★★</p>
            <p>Entrega inmediata y precios muy buenos. Volveré a comprar seguro.</p>
        </article>

        <article class="review-card">
            <h3>Carlos Pérez</h3>
            <p class="stars">★★★★☆</p>
            <p>Gran variedad de juegos y tarjetas regalo. Todo perfecto.</p>
        </article>

        <article class="review-card">
            <h3>Lucía Gómez</h3>
            <p class="stars">★★★★★</p>
            <p>Compré una skin y la recibí al instante. Muy recomendable.</p>
        </article>

        <article class="review-card">
            <h3>David Ruiz</h3>
            <p class="stars">★★★★☆</p>
            <p>Buena atención al cliente y ofertas interesantes cada semana.</p>
        </article>
    </section>
</section>

<section id="redes">
    <h2>Síguenos en redes sociales</h2>

    <ul>
        <li><a href="#" aria-label="Instagram"><i class="fa-brands fa-square-instagram"></i></a></li>
        <li><a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a></li>
        <li><a href="#" aria-label="Facebook"><i class="fa-brands fa-square-facebook"></i></a></li>
        <li><a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a></li>
    </ul>
</section>

<?php include 'footer.php'; ?>

</body>
</html>