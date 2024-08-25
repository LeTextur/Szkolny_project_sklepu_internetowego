<?php session_start();
if(!isset($_SESSION['log'])) {
    header('location:login.php');
    return;
}

// tutaj do usuwanie produktu

if (isset($_POST['deletion'])) {
    $log = $_SESSION['log'];
    $conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');
    $data = mysqli_query($conn,"SELECT `koszyk`.* FROM `koszyk` LEFT JOIN user ON koszyk.id_user = user.id WHERE user.login = '$log';");
    $idQuery = mysqli_query($conn,"SELECT `id` from user where `login` = '$log'");
    $id = mysqli_fetch_array($idQuery);
    
    $id_cart_query = mysqli_query($conn, "SELECT `id` FROM `koszyk` WHERE id_user = $id[0] ");
    $id_cart = mysqli_fetch_array($id_cart_query);
    $id_product = $_POST['id_product'];
    $deletion_query = mysqli_query($conn, "DELETE FROM `koszyk_products` WHERE `id_product` = $id_product AND `id_koszyk` = $id_cart[0]") ;
    
    $checkProductsQuery = mysqli_query($conn, "SELECT * FROM `koszyk_products` WHERE `id_koszyk` = $id_cart[0]");
    $num_rows = mysqli_num_rows($checkProductsQuery);
    var_dump($num_rows);
    if(mysqli_num_rows($checkProductsQuery) == 0) {
        $deletion_cart = mysqli_query($conn, "DELETE FROM `koszyk` WHERE `id` = $id_cart[0]");
        
    }
    header('location:cart.php');
}
