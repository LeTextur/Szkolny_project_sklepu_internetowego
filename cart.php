<?php 

$pageTitle = 'Koszyk'; 
require_once('header.php') ;


if(!isset($_SESSION['log'])) {
    header('location:login.php');
    return;
}
$flag_redirect = false;
$log = $_SESSION['log'];

$conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');
$data = mysqli_query($conn,"SELECT `koszyk`.* FROM `koszyk` LEFT JOIN user ON koszyk.id_user = user.id WHERE user.login = '$log';");
$idQuery = mysqli_query($conn,"SELECT `id` from user where `login` = '$log'");
$id = mysqli_fetch_array($idQuery);
$productX = 1;

if(mysqli_num_rows($data) == 0) {
    $flag_redirect = true;
}

$fullDataQuery = mysqli_query($conn,"SELECT * FROM `koszyk` left join koszyk_products on koszyk_products.id_koszyk = koszyk.id left join products on koszyk_products.id_product = products.id WHERE koszyk.id_user = '$id[0]';");
$fullData = mysqli_fetch_all($fullDataQuery, MYSQLI_ASSOC);
?>
<script>
    function iconChange(i, n) {
        document.getElementById(n).src = i;
        
    }

    function Redirect() {

        window.location.replace("index.php");
    }

    function quantityChange() {

        document.getElementById("quantityButton").click();

    }

</script>

<div class="cart">
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="cart-products">
                    <?php foreach ($fullData as $product) : ?>
                        <div class="cart-product">
                            <div class="row">
                                <div class="col-3">
                                    <div class="product-image">
                                    <img src="<?=ROOT.'/'.$product['img']?>">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-details">
                                        <div class="product-name"><?= $product['name'] ?> </div>
                                        <div class="category"><?= $product['category'] ?></div>
                                        <div class="price"> <?= $product['price'] ?> zł </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="cart-info nav">
                                        <div class="container"> ilość szt:
                                            <div class="card-quantity"> 
                                                <form action="<?= ROOT ?>/changequantity.php" method="post">
                                                    <input type="hidden" value="<?= $product['id_product'] ?>" name="id_product">
                                                    <input type="number" value="<?= $product['quantity'] ?>" class="quantity" min="1" name="quantity" onchange="setTimeout(quantityChange, 100);">
                                                    <button type="submit" id="quantityButton" hidden></button>    
                                                </form>
                                                <form action="<?= ROOT ?>/product-cart-deletion.php" method="post">
                                                    <input type="hidden" value="<?= $product['id_product'] ?>" name="id_product">
                                                    <button type="submit" name="deletion" class="binIcon-btn"><img src="<?= ROOT ?>/assets/bin.png" alt='bin' onmouseover="iconChange('<?= ROOT ?>/assets/delete-bin.png', '<?= $productX ?>')" onmouseout="iconChange('<?= ROOT ?>/assets/bin.png', '<?= $productX ?>')" id="<?= $productX ?>" ></button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <div class="container"> całkowita cena: <div class="price card-row-total "> <?= $product['row_total'] ?> zł </div> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $productX++; endforeach ?>
                </div>
            </div>
            <div class="col-3">
                <div class="cart-sidebar">
                    Łączna kwota: 
                    <div class="cart-subtotal"> <?= $fullData[0]['subtotal'] ?> zł </div>    
                </div>
                    <div class="orderButton">
                        <a href="<?= ROOT ?>/zamowienie.php" class="cart-button-delivery"> Przejdź do dostawy </a>
                    </div>
            </div>
        </div>
        
    </div>
</div>
<p id="php"></p>


<?php require_once('footer.php') ?>
<?php if ($flag_redirect) : ?>
<script> 
    alert('koszyk jest pusty');
    Redirect()

</script>
<?php endif; 

?>


        
