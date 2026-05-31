<?php
require('conexion.php');

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre    = trim($_POST["usuario"]);
    $password = $_POST["password"];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE nombre = ? AND password = ?");
    $stmt->bind_param("ss", $nombre, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION["login"]      = true;
        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"]     = $usuario["nombre"];
        $_SESSION["rol"]        = $usuario["rol"];
        header("Location: index.php");
        exit();
    }

    $error = "Usuario o contraseña incorrectos.";
}
?>

<?php include 'cabecera.php'; ?>

<main>
    <h2>Iniciar sesión</h2>

    <?php if ($error): ?>
        <p class="msg-error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" class="form-login">
        <label>Usuario
            <input type="text" name="usuario" placeholder="Tu usuario" required>
        </label>
        <label>Contraseña
            <input type="password" name="password" placeholder="Contraseña" required>
        </label>
        <button type="submit">Entrar</button>
    </form>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
