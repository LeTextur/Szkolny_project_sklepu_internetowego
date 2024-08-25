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
$idQuery = mysqli_query($conn,"SELECT `id` from `user` WHERE `login` = '$log'");
$id = mysqli_fetch_array($idQuery);
$cartQuery = mysqli_query($conn,"SELECT `koszyk`.* FROM `koszyk` LEFT JOIN user ON koszyk.id_user = user.id WHERE user.login = '$log';");

if(mysqli_num_rows($cartQuery) == 0) {
    $flag_redirect = true;
}

$cartData = mysqli_fetch_assoc($cartQuery);

$userQuery = mysqli_query($conn,"SELECT * from user where `login` = '$log'");
$user = mysqli_fetch_assoc($userQuery);

?>
<script>
    function Redirect() {

        window.location.replace("index.php");
    }

</script>

<div class="cart">
    <div class="container">
        <form action="" method="POST" onsubmit=" return validateForm()">
            <div class="row">
                <div class="col-9">
                    <div class="cart-products">
                        <fieldset>
                            <legend>Dane zamawiającego</legend>
                            <div class="input">
                                <label><span>Imię</span>
                                    <input type="text" name="name" value="<?= $user['first_name']?>" minlength="3" required>
                                </label>
                            </div>
                            <div class="input">
                                <label><span>Nazwisko</span>
                                    <input type="text" name="surname" value="<?= $user['last_name']?>" minlength="3" required>
                                </label>
                            </div>
                            <div class="input">
                                <label><span>Email</span>
                                    <input type="email" name="email" value="<?= $user['email']?>" minlength="3" required>
                                </label>
                            </div>
                            <div class="input">
                                <label><span>Nr telefonu</span>
                                    <input type="phone" name="tel" value = '+48' maxlength="14" required></input>
                                </label>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Adres dostawy</legend>
                            <div class="input">
                                <label><span>Ulica i numer</span>
                                    <input type="text" name="street" minlength="3" required></input>
                                </label>
                            </div>
                            <div class="input">
                                <label><span>Kod pocztowy</span>
                                    <input type="text" name="postcode" minlength="6" maxlength="6" required></input>
                                </label>
                            </div>
                            <div class="input">
                                <label><span>Miasto</span>
                                    <input type="text" name="city" minlength="3" required></input>
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="col-3">
                    <div class="cart-sidebar">
                    <fieldset class="delivery">
                            <legend>Metoda dostawy</legend>
                            <div class="input-radio">
                                <label>
                                    <input type="radio" name="dostawa" value="20" checked>
                                    <span>Kurier (20 pln)</span>
                                </label>
                            </div>
                            <div class="input-radio">
                                <label>
                                    <input type="radio" name="dostawa" value="30">
                                    <span>Kurier za pobraniem (30 pln)</span>
                                </label>
                            </div>
                            <div class="input-radio">
                                <label>
                                    <input type="radio" name="dostawa" value="0">
                                    <span>odbiór osobisty (0 pln)</span>
                                </label>
                            </div>
                        </fieldset>
                    
                        Łączna kwota: 
                        <div class="cart-subtotal"><span><?=$cartData['subtotal'] ?></span>  zł </div>
                    </div>
                        <div class="orderButton">
                            <input type="hidden" name="subtotal" value="<?=$cartData['subtotal'] ?>">
                            <button type="submit" class="cart-button-delivery"> Złóż zamówienie </a>
                        </div>
                </div>
            </div>
        </form>
        
    </div>
</div>
<?php 
    if(!empty($_POST)) {
        $flag_status = true;
        $error = null;

        $postCode = $_POST["postcode"]; // +
        $city = $_POST["city"];
        $street = $_POST["street"];
        $delivery = null; // +
        $deliveryMethod = null; // +
        $firstName = $_POST["name"]; // +
        $lastName = $_POST["surname"]; // +
        $phone = $_POST["tel"]; // +
        $email = $_POST["email"]; // +
        
        $validRegexName =  "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/";
        $validRegexPhone = "/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/";
        $validRegexPostCode = "/^[0-9]{2,3}[-][0-9]{3}$/";
        
        if (!preg_match($validRegexName, $firstName)) {
            $flag_status=false;
            $error = 'Niepoprawne imię';
        }        
        
        if (!preg_match($validRegexName, $lastName)) {
            $flag_status = false;
            $error = 'Niepoprawne Nazwisko';
        }


        if (!preg_match($validRegexPostCode, $postCode)) {
            $flag_status = false;
            $error = 'Niepoprawny kod pocztowy';
        }


        if (!preg_match($validRegexPhone, $phone)) {
            $flag_status = false;
            $error = 'Niepoprawny telefon';
        }

        
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email)) {
            $flag_status=false;
            $error = 'Podaj poprawny adres e-mail';
        }
        
        // if () {
        //     $flag_status=false;
        //     $error = 'Nieprawidłowe Miasto lub Ulica';
        // }
        
        
        if($_POST["dostawa"] == 0) {
            $deliveryMethod = 'odbiór osobisty';
            $delivery = 0;
        }
        
        if($_POST["dostawa"] == 20) {
            $deliveryMethod = 'Kurier';
            $delivery = 20;
        }
        
        if($_POST["dostawa"] == 30) {
            $deliveryMethod = 'Kurier za pobraniem';
            $delivery = 30;
        }
        
        $grandTotal = $cartData["subtotal"] + $_POST["dostawa"];

        if($flag_status) {
            $error = 'dziękujemy za zakupy';
            $shopOrderInsert = mysqli_query($conn,"INSERT INTO `shop_order`(`postcode`, `city`, `street`, `delivery`, `grandtotal`, `delivery_method`, `first_name`, `last_name`, `phone`, `email`) VALUES ('$postCode','$city','$street','$delivery','$grandTotal','$deliveryMethod','$firstName','$lastName','$phone','$email')");
            $koszykDelete = mysqli_query($conn,"DELETE FROM koszyk WHERE `koszyk`.`id_user` = '$id[0]'");
            echo "<script> setTimeout(Redirect, 3000); </script>";
        }
        
    }

    
    
    
    
    if (isset($flag_status)) {
        echo "<script> alert('$error'); </script>";
    }
?> 


<script>
    const deliveryMethodEl = document.querySelectorAll('input[type=radio]');
    const sumElement = document.querySelector('.cart-subtotal span');
    const subtotalEl = document.querySelector('input[name=subtotal]');
    
    const firtRadio = document.querySelector('input[type=radio]');
    const value = Number(firtRadio.value);
    const subtotal = Number(subtotalEl.value);
    const finalPrice = subtotal + value;
    sumElement.textContent = finalPrice;
    
    deliveryMethodEl.forEach(function (radio) {
        radio.addEventListener('change', function () {
           const value = Number(radio.value);
           const subtotal = Number(subtotalEl.value);
           const finalPrice = subtotal + value;
           sumElement.textContent = finalPrice;
        });
    });

    const validRegexName =  /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/;
    const validRegexPhone = /^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/;
    const validRegexPostCode = /^[0-9]{2,3}[-][0-9]{3}$/;
    const validRegexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    function validateForm() {
        let name = document.querySelector("input[name='name']"); // +
        let lastName = document.querySelector("input[name='surname']"); // +
        let postCode = document.querySelector("input[name='postcode']"); // +
        let city = document.querySelector("input[name='city']"); //
        let street = document.querySelector("input[name='street']"); //
        let phone = document.querySelector("input[name='tel']"); // +
        let email = document.querySelector("input[name='email']"); // +

        if (!name.value.match(validRegexName) || !lastName.value.match(validRegexPass)) {
            alert("Nieprawidłowe Imię lub Nazwisko");
            return false;
        }

        if (!phone.value.match(validRegexPhone)) {
            alert('Nieprawidłowy telefon');
            return false;
        }

        if (!email.value.match(validRegexEmail)) {
            alert('Nieprawidłowy e-mail');
            return false;
        }

        if (!postCode.value.match(validRegexPostCode)){
            alert('Nieprawidłowy Kod pocztowy');
            return false;
        }

        return true;
    }

</script>




<?php require_once('footer.php') ?>
<?php if ($flag_redirect) : ?>
<script> 

    alert('koszyk jest pusty');
    Redirect()

</script>
<?php endif; ?> 