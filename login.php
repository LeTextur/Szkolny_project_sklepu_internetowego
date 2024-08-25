<?php
$pageTitle = 'Logowanie';
require_once('header.php'); 

if(isset($_SESSION['log'])) {
    header('location:index.php');
    return;
}
?>
    <div class="container">
        <div class="form login">
            <form action="login.php" method="post" name="log" onsubmit="return validateForm()">
                Login <br>
                <input type="text" name="login" minlength="3"> 
                <br> 
                Hasło <br>
                <input type="password" name="password" minlength="8"> 
                <br>
                <button type="submit" class="btn btn-primary">Zaloguj się</button>
            </form>
        </div>
    </div>
    <?php
    if (!empty($_POST) &&  !empty($_POST['login']) && !empty($_POST['password'])) { 
        $error = null;
        $login = $_POST['login'];
        $password = $_POST['password'];
        $conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');
        $verifyLoginQuery = mysqli_query($conn,"SELECT id FROM user WHERE `login` = '$login'");
        if (mysqli_num_rows($verifyLoginQuery) == 1) {
            $hashedPassQuery = mysqli_query($conn,"SELECT `password` FROM user WHERE `login` = '$login'");
            $hashedPass = mysqli_fetch_array($hashedPassQuery);
            $verifyPass = password_verify($password, $hashedPass[0]);
            if ($verifyPass) {
                $_SESSION['log'] = $login;
                $error = "Zalogowano pomyślnie";
                header('location:index.php');
            } else $error = 'Nieprawidłowy login lub hasło';
        
        } else $error = 'Nieprawidłowy login lub hasło';
    
        mysqli_close($conn);
        echo "<script> alert('$error'); </script>";
    }
    
    require_once('footer.php') ?>

<script>
    function validateForm() {
        let log = document.querySelector("input[name='login']");
        let passA = document.querySelector("input[name='password']");

        const validRegexLogin = /^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{0,19}$/;
        const validRegexPass = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;

        if (!passA.value.match(validRegexPass)) {
            alert("Nieprawidłowe hasło");
            return false;
        }

        if (!log.value.match(validRegexLogin)){
            alert('Nieprawidłowy login');
            return false;
        }

        return true;
    }
</script>
