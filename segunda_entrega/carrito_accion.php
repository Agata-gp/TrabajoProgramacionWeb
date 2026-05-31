<?php
require('conexion.php');

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$accion = $_POST['accion'] ?? '';
$volver = $_POST['volver'] ?? 'index.php';

function obtenerCarrito($conexion, $id_usuario) {
    $stmt = $conexion->prepare("SELECT id_carrito FROM carrito WHERE id_usuario = ? AND estado = 'activo' LIMIT 1");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res) {
        return $res['id_carrito'];
    }

    $ins = $conexion->prepare("INSERT INTO carrito (id_usuario) VALUES (?)");
    $ins->bind_param("i", $id_usuario);
    $ins->execute();
    return $conexion->insert_id;
}

if ($accion === 'añadir') {
    $id_producto = (int)$_POST['id_producto'];
    $id_carrito = obtenerCarrito($conexion, $id_usuario);

    $check = $conexion->prepare("SELECT id_carrito_producto, cantidad FROM carrito_productos WHERE id_carrito = ? AND id_producto = ?");
    $check->bind_param("ii", $id_carrito, $id_producto);
    $check->execute();
    $existe = $check->get_result()->fetch_assoc();

    if ($existe) {
        $nueva = $existe['cantidad'] + 1;
        $upd = $conexion->prepare("UPDATE carrito_productos SET cantidad = ? WHERE id_carrito_producto = ?");
        $upd->bind_param("ii", $nueva, $existe['id_carrito_producto']);
        $upd->execute();
    } else {
        $ins = $conexion->prepare("INSERT INTO carrito_productos (id_carrito, id_producto, cantidad) VALUES (?, ?, 1)");
        $ins->bind_param("ii", $id_carrito, $id_producto);
        $ins->execute();
    }

    header("Location: $volver?msg=Producto+añadido+al+carrito");
    exit();
}

if ($accion === 'actualizar') {
    $id_carrito_producto = (int)$_POST['id_carrito_producto'];
    $cantidad = (int)$_POST['cantidad'];

    if ($cantidad <= 0) {
        $del = $conexion->prepare("DELETE FROM carrito_productos WHERE id_carrito_producto = ? AND id_carrito IN (SELECT id_carrito FROM carrito WHERE id_usuario = ?)");
        $del->bind_param("ii", $id_carrito_producto, $id_usuario);
        $del->execute();
    } else {
        $upd = $conexion->prepare("UPDATE carrito_productos cp JOIN carrito c ON cp.id_carrito = c.id_carrito SET cp.cantidad = ? WHERE cp.id_carrito_producto = ? AND c.id_usuario = ?");
        $upd->bind_param("iii", $cantidad, $id_carrito_producto, $id_usuario);
        $upd->execute();
    }

    header("Location: carrito.php");
    exit();
}

if ($accion === 'eliminar') {
    $id_carrito_producto = (int)$_POST['id_carrito_producto'];
    $del = $conexion->prepare("DELETE FROM carrito_productos WHERE id_carrito_producto = ? AND id_carrito IN (SELECT id_carrito FROM carrito WHERE id_usuario = ?)");
    $del->bind_param("ii", $id_carrito_producto, $id_usuario);
    $del->execute();

    header("Location: carrito.php");
    exit();
}

header("Location: index.php");
exit();
