<?php

$msg = "";

$g11_connection = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($g11_connection, "SELECT * FROM register WHERE token='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
          $g11_result = mysqli_query($g11_connection, "SELECT * FROM register WHERE token = '{$_GET['reset']}'");
	  $g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
	  	  $g11_email = $g11_row['email'];
            $g11_secretSalt = "g11.uit.nt213.m21.antt";
	    $g11_message = $g11_secretSalt.$g11_email;
            $g11_hashed = md5($g11_message);
            $g11_encryptionMethod = "AES-256-CBC"; 

//To encrypt
	    $g11_password = $_POST['password'];
            $g11_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_password);
            $g11_confirm_password = $_POST['confirm-password'];
	    $g11_confirm_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_confirm_password);
            if ($g11_crypt === $g11_confirm_crypt) {
                $query = mysqli_multi_query($g11_connection, "UPDATE login SET pwd='{$g11_crypt}'; UPDATE register SET token='' WHERE token='{$_GET['reset']}'");

                if ($query) {
                    header("refresh:0;url=../login/login.php");
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Reset Link do not match.</div>";
    }
} else {
    header("Location: forgot-pwd.php");
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>UIT Bank</title>
    <link rel="icon" href="../asset/img/logo-uit.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../asset/themify-icon/themify-icons/themify-icons.css">
    <script>
        var filter_password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[.!@#\$%\^&\*]).{8,}$/;
        function validate() {
            var v1 = document.getElementById("new-password").value;
            var v2 = document.getElementById("new_password_confirmation").value;
            if (v1 != v2) {
                document.getElementById("new_password_confirmation").setCustomValidity("Password does not match!");
                document.getElementById("new_password_confirmation").reportValidity();
                return false;
            }
            else {
                document.getElementById("new_password_confirmation").setCustomValidity("");
                return true;
            }
        }
        function checkPwd() {
            var pwd = document.getElementById("new-password").value;
            if (!filter_password.test(pwd)) {
                document.getElementById("new-password").setCustomValidity("Password must contain at least one number, one special character, one uppercase and lowercase letter, and at least 8 or more characters")
                document.getElementById("new-password").reportValidity()
                return false;
            }
            else {
                document.getElementById("new-password").setCustomValidity("")
                return true;
            }
        }
        function checkAll() {
            if (checkPwd() && validate()) { return true; }
            else {
                alert("Please enter all information correctly!");
                return false;
            }
        }
    </script>
</head>

<body>
    <div id="header">
        <div class="header-content">
            <a href="../index.html" class="page-logo"><img src="../asset/img/banner_0.png" height="60"></a>
            <div class="direct-container">
                <a href="../login/login.html" class="direct-link"><i class="fa fa-fw fa-sign-in "></i>LOGIN</a>
            </div>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>

    <div class="change-pw-container">
        <div class="changePw-content">
            <div class="register1 form-title">
                <img src="../asset/img/logo-uit.png" alt="" width="30" height="30">
                <h2>UIT Bank</h2>
            </div>
            <div class="changePW-section">
                <h2 class="title">Change your password</h2>
                <div class="changePW-innerSection">
                    <div class="changePW-form">
                        <form action="" onsubmit="return checkAll()" method="post">
                            <div style="color: red;" id="msgPwd"></div>
                            <input type="password" class="question pw" name="new-password" oninput="checkPwd()"
                                id="new-password" placeholder=" " required>
                            <label for="new-password"><span>Enter Your New Password</span></label>
                            
                            <input type="password" class="question pw" name="confirm-password" 
                            oninput="validate()" id="new_password_confirmation" placeholder=" "
                             required>
                            <label for="new_password_confirmation"><span>Confirm Password</span></label>

                            <button name="submit" class="btn" type="submit">CHANGE PASSWORD</button>
                            <div style="color: red;" id="msg"></div>
                        </form>
                    </div>
                    <div class="PW-condition">
                        <h3 class="condition-title">Password must contains:</h3>
                        <ul>
                            <li class="pw-conditional">Atleast 1 uppercase letter (A-Z) </li>
                            <li class="pw-conditional">Atleast 1 number</li>
                            <li class="pw-conditional">Atleast 8 character</li>
                            <li class="pw-conditional">Atleast 1 special character (.!@#$%^&*)</li>
                        </ul>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
