<?php 
session_start();
$log = $_SESSION['log'];

$root = '/' . basename(dirname(__FILE__));
define('ROOT', $root);

if(!isset($_SESSION['log'])) {
    header('location:index.php');
    return; 
}
$flag_redirect = false;
$pageTitle = 'Zmiana hasła';
$validRegexPass = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

if (!empty($_POST)) {
    $flag_status = true;
    $error = null;

        $pass = $_POST['pass'];
        $pass1 = $_POST['passN'];
        $pass2 = $_POST['passN2'];

    if ((strlen($pass1)<8)) {
        $flag_status=false;
        $error = 'Hasło musi posiadać min. 8 znaków';
    }

    if (!preg_match($validRegexPass, $pass1)) {
        $flag_status = false;
        $error = 'Nieprawidłowe hasło';
    }

    if ($pass1!=$pass2) {
        $flag_status=false;
        $error = 'Podane hasła nie są identyczne';
    }

    $conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');
    if ($flag_status) {
        $hashedPassQuery = mysqli_query($conn,"SELECT `password` FROM user WHERE `login` = '$log'");
        $hashedPass = mysqli_fetch_array($hashedPassQuery);
        $verifyPass = password_verify($pass, $hashedPass[0]);
        if ($verifyPass) {
                $hashedPass2 = password_hash($pass2, PASSWORD_DEFAULT);
                $update = mysqli_query($conn,"UPDATE `user` SET `password`='$hashedPass2' WHERE `login` = '$log'");
                $error = "zmieniono hasło";
                mysqli_close($conn);
                $flag_redirect = true;
        } else $error = "Nieprawidłowe Stare hasło.";
            
    }
    
}

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
            <div class="logo chpassLogo">
                <div class="col">
                    <a href="<?= ROOT ?>/index.php"><img src="<?= ROOT ?>/assets/logo.png" alt="logo"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="bar PassBarChange">
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h4>Hasło powinno Zawierać:</h4><br>
                <ul>
                    <li>
                        <div id="chpass1" class="redFont"> 8 znaków, </div>
                    </li>
                    <li>
                        <div id="chpass2" class="redFont"> Jedną liczbę, </div>
                    </li>
                    <li>
                        <div id="chpass3" class="redFont"> Jedną dużą literę, </div>
                    </li>
                    <li>
                        <div id="chpass4" class="redFont"> Jedną małą literę, </div>
                    </li>
                    <li>
                        <div id="chpass5" class="redFont"> Jeden znak specjalny. </div>
                    </li>
                </ul>
            </div>
            <div class="col PassTextCenterChange">
                <h4>Formularz do zmiany hasła</h4>
                <form action="" method="POST" class="formbuttons" onsubmit="return validateForm()">
                    Stare hasło <br>
                    <input type="password" name="pass" minlength="8" required><br>
                    Podaj nowe hasło <br>
                    <input type="password" name="passN" id="newPass" minlength="8" required onkeyup="validateStyle()"><br>
                    Powtórz nowe hasło <br>
                    <input type="password" name="passN2" minlength="8" required><br><br>
                    <button type="submit"> Zmień Hasło </button>
                </form>
            </div>
        </div>
    </div>
    <?php require_once('footer.php') ?>
    <script>
    function validateForm() {
        let pass = document.querySelector("input[name='pass']");
        let passA = document.querySelector("input[name='passN']");
        let passB = document.querySelector("input[name='passN2']");

        const validRegexPass = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/

        if (!passA.value.match(validRegexPass)) {
            alert("Hasło musi posiadać min. 8 znaków, jedną liczbę, dużą literę, małą literę oraz znak specjalny");
            return false;
        }

        if (passA.value != passB.value) {
            alert('hasła nie są te same');
            return false;
        }

        return true;
    }




    function validateStyle() {
        let passA = document.querySelector("input[name='passN']").value;

        if (passA.length >= 8) {
            document.getElementById("chpass1").style.color = "green";
        } else document.getElementById("chpass1").style.color = "red";


        if (passA.match(/\d/)) {
            document.getElementById("chpass2").style.color = "green";
        } else document.getElementById("chpass2").style.color = "red";
        
        if (passA.match(/[A-Z]/)) {
            document.getElementById("chpass3").style.color = "green";
        } else document.getElementById("chpass3").style.color = "red";

        if (passA.match(/[a-z]/)) {
            document.getElementById("chpass4").style.color = "green";
        } else document.getElementById("chpass4").style.color = "red";

        if (passA.match(/[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/)) {
            document.getElementById('chpass5').style.color = "green";
        } else document.getElementById("chpass5").style.color = "red";
    }
    </script>
</body>
<script>
function Redirect() {

    window.location.replace("logout.php");
}
</script>
<?php if ($flag_redirect) : ?>
<script>
    alert("<?= $error ?>" + ", Następuje wylogowywanie");

    setTimeout(Redirect, 5000);
</script>
<?php endif; 

if (!$flag_redirect) : ?>
<script>
    alert("<?= $error ?>");
</script>
<?php endif; ?>