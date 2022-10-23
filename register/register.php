<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $g11_fname = $_POST['firstname'];
  $g11_lname = $_POST['lastname'];
  $g11_email = $_POST['email'];
  $g11_password = $_POST['password'];
  $g11_secretSalt = "g11.uit.nt213.m21.antt";
  $g11_message = $g11_secretSalt.$g11_email;
  $g11_hashed = md5($g11_message);
  $g11_encryptionMethod = "AES-256-CBC";

  //To encrypt
  $g11_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_password);
  session_start();
  $_SESSION['firstname'] = $g11_fname;
  $_SESSION['lastname'] = $g11_lname;
  $_SESSION['email'] = $g11_email;
  $_SESSION['password'] = $g11_crypt;
  header("refresh:0;url=register2.php");
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>UIT Bank</title>
  <link rel="icon" href="../asset/img/logo-uit.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/response.css">
  <link rel="stylesheet" href="../css/style.css">

  <script>
    var filter_name = /^[A-Za-z\s]+$/;
    var filter_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var filter_password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[!@#\$%\^&\*]).{8,}$/;

    function myFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") {
        x.className += " responsive";
      } else {
        x.className = "topnav";
      }
    }

    function checkAll() {
      if (validate() && checkfName() && checklName() && checkEmail() && checkPwd()) {
        return true;
      } else {
        alert("Please enter all information correctly!");
        return false;
      }
    }

    function validate() {
      var v1 = document.getElementById("password").value;
      var v2 = document.getElementById("password_confirmation").value;
      if (v1 != v2) {
        document.getElementById("msg").innerHTML = "Password do not match";
        return false;
      } else {
        document.getElementById("msg").innerHTML = "";
        return true;
      }
    }

    function checkfName() {
      var fname = document.getElementById("firstname").value;
      if (!filter_name.test(fname)) {
        document.getElementById("msgName1").innerHTML = "Username must have alphabet characters only";
        return false;
      } else {
        document.getElementById("msgName1").innerHTML = "";
        return true;

      }
    }

    function checklName() {
      var lname = document.getElementById("lastname").value;
      if (!filter_name.test(lname)) {
        document.getElementById("msgName2").innerHTML = "Username must have alphabet characters only";
        return false;
      } else {
        document.getElementById("msgName2").innerHTML = "";
        return true;
      }
    }

    function checkEmail() {
      var email = document.getElementById("email").value;
      if (!filter_email.test(email)) {
        document.getElementById("msgEmail").innerHTML = "Invalid email address!";
        return false;
      } else {
        document.getElementById("msgEmail").innerHTML = "";
        return true;
      }
    }

    function checkPwd() {
      var pwd = document.getElementById("password").value;
      if (!filter_password.test(pwd)) {
        document.getElementById("msgPwd").innerHTML = "Password must contain at least one number, one special character, one uppercase and lowercase letter, and at least 8 or more characters";
        return false;
      } else {
        document.getElementById("msgPwd").innerHTML = "";
        return true;
      }
    }
  </script>
</head>

<body>
  <div id="header">
    <div class="header-content">
      <a href="../index.php" class="page-logo"><img src="../asset/img/banner_0.png" height="60"></a>

      <div class="direct-container">
        <a href="../login/login.php" class="direct-link"><i class="fa fa-fw fa-sign-in "></i>LOGIN</a>
      </div>

      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>

  <div class="register1 form-body">
    <div class="register1 form-content">
      <div class="register1 form-title">
        <img src="../asset/img/logo-uit.png" alt="" width="30" height="30">
        <h2>UIT Bank</h2>
      </div>

      <form name="Register" class="register1 form-section" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <fieldset>
          <legend>Register</legend>
          <input type="text" name="firstname" class="question" oninput="checkfName()" id="firstname" required autocomplete="off">
          <label style="margin-bottom: 10px;" for="firstname"><span>First Name*</span></label>
          <div style="color: red;" id="msgName1"></div>

          <input type="text" name="lastname" class="question" oninput="checklName()" id="lastname" required autocomplete="off">
          <label style="margin-bottom: 10px;" for="lastname"><span>Last Name*</span></label>
          <div style="color: red;" id="msgName2"></div>


          <input type="text" name="email" class="question" oninput="checkEmail()" id="email" required autocomplete="off">
          <label style="margin-bottom: 10px;" for="email"><span>Email Address*</span></label>
          <div style="color: red;" id="msgEmail"></div>

          <input type="password" name="password" oninput="checkPwd()" class="question" id="password" required autocomplete="off">
          <label style="margin-bottom: 10px;" for="password">
            <span>Password*</span>
          </label>
          <div style="color: red;" id="msgPwd"></div>

          <input id="password_confirmation" class="question" type="password" oninput="validate()" name="password_confirmation" required autocomplete="off">
          <label style="margin-bottom: 10px;" for="password_confirmation">
            <span>Confirm Password*</span>
          </label>
          <div style="color: red;" id="msg"></div>

          <input class="register1 form-submit" id="register1-submit" type="submit" name="submit" value="Submit">
          <a class="register1 login-link" href="../login/login.php" onmouseover="this.style.color = 'red'" onmouseleave="this.style.color = 'blue'">
            Already had an account?
          </a>
        </fieldset>
      </form>
    </div>
  </div>
</body>

</html>
