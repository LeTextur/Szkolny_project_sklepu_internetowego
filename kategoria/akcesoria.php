<?php 
        $pageTitle = 'Akcesoria';
        require_once('../header.php');
?>
 <div class="container">
        <div class="row">
            <div class="col products">
                <?php 
                    $conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');
                    $data = mysqli_query($conn,"SELECT `name`,`category`,`price`,`img`, `id` FROM `products` WHERE `category` = 'Akcesoria';");
                    require_once('../produkty.php');
                    ?>
            </div>
        </div>
    </div>
<?php 
        require_once('../footer.php');
    ?>