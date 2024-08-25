<?php session_start();

$log = $_SESSION['log'];
$conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');

$idQuery = mysqli_query($conn, "SELECT `id` from `user` WHERE `login` = '$log'");
$id = mysqli_fetch_array($idQuery);


    $id_product = $_POST['id_product'];
    $quantity = $_POST['quantity'];

    $id_cart_query = mysqli_query($conn, "SELECT `id` FROM `koszyk` WHERE id_user = $id[0] ");
    $id_cart = mysqli_fetch_array($id_cart_query);

    $productQuery = mysqli_query($conn,"SELECT * FROM `products` WHERE `id` = '$id_product'");
    $product = mysqli_fetch_array($productQuery);
    $price = $product["price"];
    $rowTotal = round($price * $quantity, 2);
    $quantityChangeQuery = mysqli_query($conn, "UPDATE `koszyk_products` SET `quantity`= $quantity, `row_total` = $rowTotal WHERE `id_product` = $id_product AND `id_koszyk` = $id_cart[0]");

    $cartSubtotalQuery = mysqli_query($conn,"SELECT SUM(koszyk_products.row_total) FROM `koszyk_products` where `id_koszyk` = '$id_cart[0]';");
    $cartSubtotal = mysqli_fetch_array($cartSubtotalQuery);
    $cartUpdate = mysqli_query($conn,"UPDATE `koszyk` SET `subtotal`='$cartSubtotal[0]'WHERE `id` = '$id_cart[0]'");


    header('location:cart.php');