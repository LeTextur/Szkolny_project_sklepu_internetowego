<?php
session_start();
 $root = '/' . basename(dirname(__FILE__));
 define('ROOT', $root);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= ROOT ?>/fonts/font-connect.css">
    <link rel="stylesheet" href="<?= ROOT ?>/css/bootstrap-grid.css">
    <link rel="stylesheet" href="<?= ROOT ?>/style.css">
    <link rel="stylesheet" href="<?= ROOT ?>/form.css">
    <link rel="shortcut icon" href="<?= ROOT ?>/favicon.ico" type="image/x-icon">
    <title><?= isset($pageTitle) ? $pageTitle . ' | ' : '' ?>Sklep BlueTech</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col time-date">
                <time id="header-time"></time>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col logo">
            <a href="<?= ROOT ?>/index.php"><img src="<?= ROOT ?>/assets/logo.png" alt="logo"></a>
            </div>
            <div class="col">
            <div class="header-right">
                <div class="account">
                    <img src="<?= ROOT ?>/assets/8666688_user_x_icon.png" class="headericon icon">
                    <?php if (isset($_SESSION['log'])) : ?>
                        <a class="margin-2px" href="<?= ROOT ?>/logout.php">Wyloguj się</a>
                        <a href="<?= ROOT ?>/account.php"> Moje konto</a>
                     <?php else: ?>
                        <a class="margin-2px" href="<?= ROOT ?>/login.php">Zaloguj się</a>
                        <a href="<?= ROOT ?>/register.php">Załóż konto</a>
                     <?php endif ?>
                </div>
                <div class="basket">
                <a href="<?= ROOT ?>/cart.php"><img src="<?= ROOT ?>/assets/koszyk-icon.png" class="headericon icon">
                    <?php 
                        if (isset($_SESSION['log'])) {
                            $log = $_SESSION['log'];
                            $conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');
                            
                            $idQuery = mysqli_query($conn,"SELECT `id` FROM `user` WHERE `login` = '$log'");
                            $id = mysqli_fetch_array($idQuery);

                            $idKoszykQuery = mysqli_query($conn,"SELECT `id` FROM `koszyk` WHERE `id_user` = '$id[0]'");
                            $idKoszyk = mysqli_fetch_array($idKoszykQuery);
                            if ($idKoszyk == !null) {
                                $quantityQuery = mysqli_query($conn,"SELECT SUM(`quantity`) FROM `koszyk_products` Where `id_koszyk` = '$idKoszyk[0]'");
                                $quantity = mysqli_fetch_array($quantityQuery);

                                echo "Koszyk ($quantity[0])";
                            } else echo "koszyk (0)";

                            mysqli_close($conn);
                        
                        } else echo "koszyk (0)"; 

                            
                    ?>
                </a>
                
                
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="bar">
        <div class="container">
            <nav class="nav">
                <div class="navbuttons">
                    <a href="<?= ROOT ?>/kategoria/smartfony.php">Smartfony</a>
                    <a href="<?= ROOT ?>/kategoria/komputery.php">Komputery</a>
                    <a href="<?= ROOT ?>/kategoria/akcesoria.php">Akcesoria</a>
                </div>
                <div class="navconcact">    
                    <img src="<?= ROOT ?>/assets/phone-icon.png" class="icon">Telefon: (+48) 111 222 333
                </div>   
            </nav>
        </div>
    </div>