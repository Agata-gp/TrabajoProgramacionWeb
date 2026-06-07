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

if ($accion === 'pagar') {
    $id_carrito_stmt = $conexion->prepare("SELECT id_carrito FROM carrito WHERE id_usuario = ? AND estado = 'activo' LIMIT 1");
    $id_carrito_stmt->bind_param("i", $id_usuario);
    $id_carrito_stmt->execute();
    $carrito_row = $id_carrito_stmt->get_result()->fetch_assoc();

    if (!$carrito_row) {
        header("Location: carrito.php");
        exit();
    }

    $id_carrito = $carrito_row['id_carrito'];

    $stmt_items = $conexion->prepare("SELECT cp.cantidad, p.id_producto, p.nombre, p.precio FROM carrito_productos cp JOIN productos p ON cp.id_producto = p.id_producto WHERE cp.id_carrito = ?");
    $stmt_items->bind_param("i", $id_carrito);
    $stmt_items->execute();
    $items = $stmt_items->get_result()->fetch_all(MYSQLI_ASSOC);

    if (empty($items)) {
        header("Location: carrito.php");
        exit();
    }

    $total = 0;
    foreach ($items as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    $conexion->begin_transaction();
    try {
        $ins_pedido = $conexion->prepare("INSERT INTO pedidos (id_usuario, total) VALUES (?, ?)");
        $ins_pedido->bind_param("id", $id_usuario, $total);
        $ins_pedido->execute();
        $id_pedido = $conexion->insert_id;

        $ins_linea = $conexion->prepare("INSERT INTO pedido_productos (id_pedido, id_producto, nombre_producto, precio_unitario, cantidad) VALUES (?, ?, ?, ?, ?)");
        foreach ($items as $item) {
            $ins_linea->bind_param("iisdi", $id_pedido, $item['id_producto'], $item['nombre'], $item['precio'], $item['cantidad']);
            $ins_linea->execute();
        }

        $cierra = $conexion->prepare("UPDATE carrito SET estado = 'completado' WHERE id_carrito = ?");
        $cierra->bind_param("i", $id_carrito);
        $cierra->execute();

        $conexion->commit();
        header("Location: factura.php?id=$id_pedido");
        exit();
    } catch (Exception $e) {
        $conexion->rollback();
        header("Location: carrito.php?error=Error+al+procesar+el+pago");
        exit();
    }
}

header("Location: index.php");
exit();