<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>
<body>
    <?php include 'cabecera.php'; ?>
    <main>
        <section>
            <h2>Perfil del Usuario</h2>
            <p>Bienvenido, <?php echo $_SESSION['username']; ?>!</p>
            <p>Este es tu perfil de usuario. Aquí puedes ver tus compras, editar tu información personal y gestionar tus preferencias.</p>
            <button>Editar Perfil</button>
            <button>Cerrar Sesión</button>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>