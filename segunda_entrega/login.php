<?php
session_start();
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $usuario = $resultado->fetch_assoc();

        $_SESSION["login"] = true;
        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"];

        header("Location: index.php");
        exit();
    }

    $error = "Usuario o contraseña incorrectos";
}
?>

<?php require("cabecera.php"); ?>

<main>
    <h2>Iniciar sesión</h2>

    <?php if(isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>

    <form method="post">
        <input type="text" name="usuario" placeholder="Usuario" required>

        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Entrar</button>
    </form>
</main>

<?php require("footer.php"); ?>