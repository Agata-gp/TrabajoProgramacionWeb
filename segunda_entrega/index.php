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
            <button>Ver descuentos</button>
        </article>

        <article>
            <h2>Productos destacados</h2>

            <section class="products">
                <article class="product-card">
                    <h3>EA FC 26</h3>
                    <p>Videojuego deportivo para consola y PC.</p>
                    <strong>29,99€</strong>
                    <button>Añadir al carrito</button>
                </article>

                <article class="product-card">
                    <h3>Minecraft</h3>
                    <p>Construye, explora y juega con tus amigos.</p>
                    <strong>19,99€</strong>
                    <button>Añadir al carrito</button>
                </article>

                <article class="product-card">
                    <h3>Tarjeta Steam 20€</h3>
                    <p>Recarga tu cuenta de Steam al instante.</p>
                    <strong>20,00€</strong>
                    <button>Añadir al carrito</button>
                </article>
            </section>
        </article>

        <article>
            <h2>Skins populares</h2>

            <section class="products">
                <article class="product-card">
                    <h3>Skin Valorant</h3>
                    <p>Pack exclusivo para personalizar tus armas.</p>
                    <strong>14,99€</strong>
                    <button>Comprar</button>
                </article>

                <article class="product-card">
                    <h3>Skin Fortnite</h3>
                    <p>Aspecto especial para tu personaje.</p>
                    <strong>9,99€</strong>
                    <button>Comprar</button>
                </article>

                <article class="product-card">
                    <h3>Caja misteriosa</h3>
                    <p>Consigue recompensas digitales aleatorias.</p>
                    <strong>4,99€</strong>
                    <button>Comprar</button>
                </article>
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
            <img src="imagenes/mickieGame.jpg" alt="Portada Micky Game">
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