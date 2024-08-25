<?php 
$pageTitle = 'Moje konto';
require_once('header.php');
if(!isset($_SESSION['log'])) {
    header('location:index.php');
    return;
}

$log = $_SESSION['log'];
$conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');
$data = mysqli_query($conn,"SELECT `login`,`first_name`,`last_name`,`email`, `id` FROM `user` WHERE `login` = '$log'");
?>

<div class="container">
    <div class="row">
        <div class="col data">
            <p> Informacje o twoim koncie: </p>
            
            <?php while ($row = mysqli_fetch_row($data)) {
                echo "
                Imię: $row[1] <br>
                Nazwisko: $row[2] <br><br>
                Login: $row[0] <br>
                E-mail: $row[3] <br>
                ";
                $old_login = $row[0]; 
                $old_firstName = $row[1];
                $old_lastName = $row[2];
                $old_email = $row[3];
                $id = $row[4];    
            }

            mysqli_close( $conn ); ?>
            <br>
            <div class="navbuttons">
                <a href="<?= ROOT ?>/changePassword.php">Zmień hasło</a>
            </div> 
        </div>
        <div class="col change-data">
            <form action="" class="formbuttons" method="POST" onsubmit="return validateForm()">
                Imię <br>
                <input type="text" name='first-name'> <br>
                Nazwisko <br>
                <input type="text" name='last-name'> <br>
                Login <br>
                <input type="text" name='login'> <br>
                E-mail <br>
                <input type="email" name='email'> <br><br>
                <button type="submit"> Zmień Dane </button>
                <input type="hidden" value="<?= $old_login ?>" id="logOld">
                <input type="hidden" value="<?= $old_firstName ?>" id="firstOld">
                <input type="hidden" value="<?= $old_lastName ?>" id="lastOld">
                <input type="hidden" value="<?= $old_email ?>" id="emailOld">
            </form>
        </div>
    </div>
</div>


<?php
    $checkEmptyFlag = true;
    foreach ($_POST as $value) {
        if (!empty($value)) {
            $checkEmptyFlag = false;
            break;
        }
    }

    if ($checkEmptyFlag && !empty($_POST)) {
    echo "<script> alert('Formularz jest pusty'); </script>";
    require_once('footer.php');
    exit;
    }

    if (!$checkEmptyFlag) {
        foreach($_POST as $value) {
        $flag_status = true;
        $error = null;
        $conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');

        $validRegexName =  "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/";

        if (isset($_POST['login'])) {
            $login = $_POST['login'];
            if ($login == '') {
                $data = mysqli_query($conn,"SELECT `login` FROM `user` WHERE `id` = '$id'");
                $array = mysqli_fetch_array($data);
                $login = $array[0];
            }

            if (strlen($login) < 3) {
                $flag_status = false;
                $error = 'Login musi posiadać min. 3 znaki';
                mysqli_close($conn);
                break;
            }
        
            if (ctype_alnum($login)==false) {
                    $flag_status=false;
                    $error = 'Login nie może posiadać znaków specjalnych';
                    mysqli_close($conn);
                    break;
            } else {
                    $update = mysqli_query($conn,"UPDATE `user` SET `login`='$login' WHERE `id` = '$id'");
                    $_SESSION['log'] = $login;
                }
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if ($email == '') {
                $data = mysqli_query($conn,"SELECT `email` FROM `user` WHERE `id` = '$id'");
                $array = mysqli_fetch_array($data);
                $email = $array[0];
            }

            $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
            if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email)) {
                $flag_status=false;
                $error = 'Podaj poprawny adres e-mail';
                mysqli_close($conn);
                break;
            } else {
                    $update = mysqli_query($conn,"UPDATE `user` SET `email`='$email' WHERE `id` = '$id'");
                }
        }

        if (isset($_POST['first-name'])) {
            $first_name = $_POST['first-name'];
            if ($first_name == '') {
                $data = mysqli_query($conn,"SELECT `first_name` FROM `user` WHERE `id` = '$id'");
                $array = mysqli_fetch_array($data);
                $first_name = $array[0];
            }

            if (!preg_match($validRegexName, $first_name)) {
                $flag_status=false;
                $error = 'Niepoprawne imię';
                mysqli_close($conn);
                break;
            } else {
                $update = mysqli_query($conn,"UPDATE `user` SET `first_name`='$first_name' WHERE `id` = '$id'");
            }       
        }

        if (isset($_POST['last-name'])) {
            $last_name = $_POST['last-name'];
            if ($last_name == '') {
                $data = mysqli_query($conn,"SELECT `last_name` FROM `user` WHERE `id` = '$id'");
                $array = mysqli_fetch_array($data);
                $last_name = $array[0];
            }
                        
            if (!preg_match($validRegexName, $last_name)) {
                $flag_status = false;
                $error = 'Niepoprawne Nazwisko';
                mysqli_close($conn);
                break;
            } else {
                    $update = mysqli_query($conn,"UPDATE `user` SET `last_name`='$last_name' WHERE `id` = '$id'");
                }
            }
    
            $error = 'Zmieniono dane';   
        }
    }
    if (isset($flag_status)) {
            echo "<script> alert('$error'); </script>";
            header("Refresh:0");
        
        
        } ?>
        <?php require_once('footer.php'); ?>
<script>
    function validateForm() {
        let fname = document.querySelector("input[name='first-name']");
        let lname = document.querySelector("input[name='last-name']");
        let log = document.querySelector("input[name='login']");
        let email = document.querySelector("input[name='email']");
        let array = [fname.value, lname.value, log.value, email.value];

        let fnameOld = document.getElementById("firstOld").value;
        let lnameOld = document.getElementById("lastOld").value;
        let logOld = document.getElementById("logOld").value;
        let emailOld = document.getElementById("emailOld").value;

        const validRegexLogin = /^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{3,19}$/;
        const validRegexName =  /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/;
        const validRegexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        let checkEmptyFlag = true;

            if (fname.value == '' && lname.value == '' && log.value == '' && email.value == ''){
                checkEmptyFlag = false;
                alert('Formularz jest pusty');
                return false
            } else {

                if(email.value  == ''){
                    email.value  = emailOld;
                    
                }

                if(fname.value == ''){
                    fname.value  = fnameOld;
                }

                if(lname.value == ''){
                    lname.value  = lnameOld;
                }

                if(log.value == ''){
                    log.value = logOld;
                }

            }
            if (!email.value.match(validRegexEmail)) {
                alert("Nieprawidłowy E-mail");
                return false;
            }

            if (!fname.value.match(validRegexName)) {
                alert("Nieprawidłowe imię");
                return false;
            }

            if (!lname.value.match(validRegexName)) {
                alert("Nieprawidłowe Nazwisko");
                return false;
            }

            if (!log.value.match(validRegexLogin)){
                alert('Nieprawidłowy login');
                return false;
            }
    };
        
</script>
