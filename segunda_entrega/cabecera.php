<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CyberLoot</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_ofertas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="javascript.js" defer></script>
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
    <form class="search-bar" action="buscar.php" method="get">
        <input type="text" name="buscar" placeholder="Buscar productos">
        <button type="submit">Buscar</button>
    </form>

    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="videojuegos.php">Videojuegos</a></li>
        <li><a href="tarjetas_regalo.php">Tarjetas Regalo</a></li>
        <li><a href="skins.php">Skins</a></li>
        <li><a href="ofertas.php">Ofertas</a></li>
        <li>
            <a href="carrito.php">
                <i class="fa-solid fa-cart-shopping"></i>
                <?php
                if (isset($_SESSION['id_usuario'])) {
                    $uid = $_SESSION['id_usuario'];
                    $q = $conexion->prepare("SELECT SUM(cp.cantidad) as total FROM carrito c JOIN carrito_productos cp ON c.id_carrito = cp.id_carrito WHERE c.id_usuario = ? AND c.estado = 'activo'");
                    $q->bind_param("i", $uid);
                    $q->execute();
                    $r = $q->get_result()->fetch_assoc();
                    $total = $r['total'] ?? 0;
                    if ($total > 0) echo "<span class='badge'>$total</span>";
                }
                ?>
            </a>
        </li>
        <li>
            <?php if (isset($_SESSION['login'])) { ?>
                <a href="perfil.php"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($_SESSION['nombre']); ?></a>
                <?php if ($_SESSION['rol'] === 'admin') { ?>
                    <a href="admin.php" style="color:#ff0;"><i class="fa-solid fa-screwdriver-wrench"></i> Admin</a>
                <?php } ?>
            <?php } else { ?>
                <a href="login.php"><i class="fa-solid fa-user"></i></a>
            <?php } ?>
        </li>
    </ul>
</nav>
