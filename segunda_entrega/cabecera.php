<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CyberLoot</title>

    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="javascript.js"></script>

</head>
<body>

<header>
    <section>
        <h1>CyberLoot</h1>
        <p class="slogan">Videojuegos, skins y contenido digital instantáneo</p>
    </section>

    <canvas id="logo" width="200" height="200"></canvas>
</header>

<nav>
    <form class="search-bar" action="#" method="get">
        <input type="text" name="buscar" placeholder="Buscar productos">
        <button type="submit">Buscar</button>
    </form>

    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="videojuegos.php">Videojuegos</a></li>
        <li><a href="tarjetas.php">Tarjetas Regalo</a></li>
        <li><a href="skins.php">Skins</a></li>
        <li><a href="ofertas.php">Ofertas</a></li>
        <li><a href="carrito.php">Carrito</a></li>
        <li><?php if(isset($_SESSION['login'])) { ?>
                <a href="perfil.php"><i class="fa-solid fa-user"></i></a>
            <?php } else { ?>
                <a href="login.php"><i class="fa-solid fa-user"></i></a>
            <?php } ?>
        </li>
    </ul>
</nav>