<?php
$pageTitle = 'Rejestracja';
if(isset($_SESSION['log'])) {
    header('location:index.php');
    exit();
}

$accCreate = null;
$validRegexName =  "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/";
$validRegexPass = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

// if (!empty($_POST)) {
//     $flag_status = true;
//     $error = null;

//     $login = $_POST['login'];
//     if(strlen($login) < 3) {
//         $flag_status = false;
//         $error = 'Login musi posiadać min. 3 znaki';
//     }

//     if (ctype_alnum($login)==false) {
//             $flag_status=false;
//             $error = 'Login nie może posiadać znaków specjalnych';
//     }


//         $email = $_POST['email'];
//         $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

//     if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email)) {
//             $flag_status=false;
//             $error = 'Podaj poprawny adres e-mail';
//     }


//         $pass1 = $_POST['password1'];
//         $pass2 = $_POST['password2'];

//     if ((strlen($pass1)<8)) {
//         $flag_status=false;
//         $error = 'Hasło musi posiadać min. 8 znaki';
//     }

//     if ($pass1!=$pass2) {
//         $flag_status=false;
//         $error = 'Podane hasła nie są identyczne';
//     }


//         $first_name = $_POST['first-name'];
//         $last_name = $_POST['last-name'];

//     if (!preg_match($validRegexName, $first_name)) {
//         $flag_status=false;
//         $error = 'Niepoprawne imię';
//     }        

//     if (!preg_match($validRegexName, $last_name)) {
//         $flag_status = false;
//         $error = 'Niepoprawne Nazwisko';
//     }

//     if ($flag_status) {
//         $conn = mysqli_connect('localhost', 'root', '', 'bluetech_shop');

//         $check_data = mysqli_query($conn,"SELECT id FROM user WHERE email = '$email' OR `login` = '$login'");
                 
//         $num_data = mysqli_num_rows($check_data);
//         if($num_data>0) {
//             $flag_status = false;
//             $error = "Istnieje już konto przypisane do tego adresu e-mail lub loginu";
//             } else {
//                 $hashedpass = password_hash($pass1, PASSWORD_DEFAULT);
//                 $insert = mysqli_query($conn,"INSERT INTO `user` (`id`, `login`, `password`, `first_name`, `last_name`, `email`) VALUES (NULL, '$login', '$hashedpass', '$first_name', '$last_name', '$email')");
//                 $accCreate = true;
//                 $error = 'Utworzono konto';
//             }

//             mysqli_close($conn);
//     }
// }

require_once('header.php') 
?>
    <div class="container">
        <div class="form register">
            <?php 
                if ($accCreate) {
                    echo 'Utworzono konto <br><br>';
                }
            ?>
            <form action="" method="post" name="reg" onsubmit="return validateForm()">
                Imię <br> 
                <input type="text" name="first-name" required minlength="3">
                <br>
                Nazwisko <br> 
                <input type="text" name="last-name" required minlength="3">
                <br>
                E-mail <br> 
                <input type="email" name="email" required minlength="3">
                <br>
                Login <br>
                <input type="text" name="login" required minlength="3"> 
                <br> 
                Hasło <br>
                <input type="password" name="password1" required minlength="8"> 
                <br>
                Powtórz Hasło <br>
                <input type="password" name="password2" required minlength="8"> 
                <br>
                <button type="submit" class="btn btn-primary">Zarejestruj się</button>
              </form>
        </div>
    </div>
<?php require_once('footer.php') ?>   
<script>
    function validateForm() {
        let fname = document.querySelector("input[name='first-name']");
        let lname = document.querySelector("input[name='last-name']");
        let log = document.querySelector("input[name='login']");
        let passA = document.querySelector("input[name='password1']");
        let passB = document.querySelector("input[name='password2']");
        let email = document.querySelector("input[name='email']");

        const validRegexLogin = /^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{0,19}$/;
        const validRegexName =  /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/;
        const validRegexPass = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
        const validRegexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email.value.match(validRegexEmail)) {
            alert("Niepoprawny E-mail");
            return false;
        }

        if (!passA.value.match(validRegexPass)) {
            alert("Hasło musi posiadać min. 8 znaków, jedną liczbę, dużą literę, małą literę oraz znak specjalny");
            return false;
        }

        if (!fname.value.match(validRegexName)) {
            alert("Niepoprawne imię");
            return false;
        }

        if (!lname.value.match(validRegexName)) {
            alert("Niepoprawne Nazwisko");
            return false;
        }

        if (passA.value != passB.value) {
            alert('hasła nie są te same');
            return false;
        }
        if (!log.value.match(validRegexLogin)){
            alert('Nieprawidłowy login');
            return false;
        }

        return true;
    }

</script>
<?php
if (isset($flag_status)) {
        echo "<script> alert('$error'); </script>";
    }
?>