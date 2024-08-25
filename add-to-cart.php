<?php session_start();
if(!isset($_SESSION['log'])) {
    header('location:login.php');
    return;
}

$log = $_SESSION['log'];
$id = $_POST['id'];

if(!isset($_POST) || empty($_POST['id'])) {
    header('location:index.php');
    return;
}

$conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');

$cart = getCart();


if (!$cart) {
    $idUser = mysqli_query($conn, "SELECT `id` FROM `user` WHERE `login` = '$log'");
    $idUserlog = mysqli_fetch_array($idUser);
    $insert = mysqli_query($conn,"INSERT INTO `koszyk`(`id_user`) VALUES ('$idUserlog[0]')");

    $cart = getCart();
}

$productQuery = mysqli_query($conn,"SELECT * FROM `products` WHERE `id` = '$id'");
$product = mysqli_fetch_array($productQuery);
$price = $product["price"];
$cartProductQuery = mysqli_query($conn,"SELECT * FROM `koszyk_products` WHERE `id_product` = $id AND `id_koszyk` = '$cart[0]'");
if (mysqli_num_rows($cartProductQuery) == 0) {
    $productInsert = mysqli_query($conn,"INSERT INTO `koszyk_products`(`id_koszyk`, `id_product`, `quantity`, `row_total`) VALUES ('$cart[0]','$id',1,'$price')");

} else {
    $cartProduct = mysqli_fetch_array($cartProductQuery);
    $qty = $cartProduct["quantity"];
    $rowTotal = $cartProduct["row_total"];
    $qty++;
    $rowTotal = round($price * $qty, 2);
    $productUpdate  = mysqli_query($conn,"UPDATE `koszyk_products` SET `quantity`='$qty',`row_total`='$rowTotal' WHERE `id` = '$cartProduct[0]'");
}

$cartSubtotalQuery = mysqli_query($conn,"SELECT SUM(koszyk_products.row_total) FROM `koszyk_products` where id_koszyk = '$cart[0]';");
$cartSubtotal = mysqli_fetch_array($cartSubtotalQuery);
$cartUpdate = mysqli_query($conn,"UPDATE `koszyk` SET `subtotal`='$cartSubtotal[0]'WHERE `id` = '$cart[0]'");
header("location:cart.php");

function getCart() {
    $log = $_SESSION['log'];
    $conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');
    $data = mysqli_query($conn,"SELECT `koszyk`.id FROM `koszyk` LEFT JOIN user ON koszyk.id_user = user.id WHERE user.login = '$log';");
    if (mysqli_num_rows($data) == 0) {
        return null;
    }

    return  mysqli_fetch_array($data);
}