<?php
if(isset($_SESSION['account_no'])){
	header("refresh:0;url=../profile/dashboard.php");
}
else{
	$g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");
	if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($g11_con, "SELECT * FROM register WHERE token='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($g11_con, "UPDATE register SET token='', status='1' WHERE token='{$_GET['verification']}'");
            
            if ($query) {
                echo"<script>alert('Account verification has been successfully completed.')</script>";
                header("refresh:0;url=../login/login.php");
                
            }
        } else {
            header("refresh:0;url=../index.php");
        }
    }
}
if (isset($_POST['submit'])) {
  $g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");
	$g11_id = $_POST['id'];
	$g11_password = $_POST['password'];
	$g11_secretSalt = "g11.uit.nt213.m21.antt";
	$g11_message = $g11_secretSalt.$g11_id;
	$g11_hashed = md5($g11_message);
	$g11_encryptionMethod = "AES-256-CBC"; 

	//To encrypt
	$g11_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_password);
	session_start();
	$g11_stmt = mysqli_prepare($g11_con, "SELECT * FROM login WHERE id=? && pwd=?");
	mysqli_stmt_bind_param($g11_stmt, "ss", $g11_id, $g11_crypt);
	mysqli_stmt_execute($g11_stmt);
	$g11_result = mysqli_stmt_get_result($g11_stmt);
	$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
	
  	$g11_stmt = mysqli_prepare($g11_con,"SELECT * FROM register WHERE email=?");
  	mysqli_stmt_bind_param($g11_stmt, "s", $g11_id);
  	mysqli_stmt_execute($g11_stmt);
  	$g11_result2 = mysqli_stmt_get_result($g11_stmt);
  	$g11_row2 = mysqli_fetch_array($g11_result2,MYSQLI_ASSOC);
	$g11_accno = $g11_row['account_no'];
	$g11_count = mysqli_num_rows($g11_result);
	if($g11_count==1)
	{
    if (empty($g11_row2['token']) && $g11_row2['status'] == 1 ) {
      $_SESSION['account_no'] = $g11_accno;
      header("refresh:0;url=../profile/dashboard.php");
    } else {
        echo"<script>alert('First verify your account and try again.')</script>";
    }
	}
	else
	{
		header("refresh:0;url=../login/login.php");
	}
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>UIT Bank</title>
    <link rel="icon" href="./asset/img/logo-uit.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/response.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div id="header">
    <div class="header-content">
      <a href="./index.php" class="page-logo"><img src="./asset/img/banner_0.png" height="60"></a>
      <div class="direct-container">
        <a href="./register/register.php" class="direct-link"><i class="fa fa-fw fa-sign-in "></i>Sign Up</a>
      </div>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>

  <div class="login form-body">
    <div class="login grid-column form-background">
      <div>
        <img src="./asset/img/Logo_UIT_Web_Transparent.png" alt="" height="400">
      </div>
    </div>

    <div class="grid-column form-container login">
      <div class="login form-content">
        <div class="login form-title">
          <img src="./asset/img/logo-uit.png" alt="" width="30" height="30">
          <h2>UIT Bank</h2>
        </div>

        <form method="post" class="login form-section" onsubmit="return checkAll()">
          <div class="login input-container">
            <!-- <input type="text" name="id" class="question" id="id" placeholder="User ID" required autocomplete="off" /> -->
            <input type="text" name="id" oninput="checkEmail()" placeholder="User ID" class="question" id="id" required
              autocomplete="off" style="margin: 1px 0" />
            <!-- <label for="id"><span>Your email</span></label> -->
            <div style="font-size:12px; text-align: end; color: red; height: 18px;" id="msgEmail"></div>
          </div>

          <div class="login input-container">
            <!-- <input type="password" name="password" class="question" id="password" placeholder="password" required
              autocomplete="off" /> -->
            <input type="password" name="password" oninput="checkPwd()" placeholder="Password" class="question"
              id="password" required autocomplete="off" style="margin:1px 0" />
            <div style="font-size:12px; text-align: end; color: red; height: 18px;" id="msgPwd"></div>
          </div>
          <input type="submit" name="submit" class="form-submit" value="Submit">
          <a href="./register/register.php" class="register-link" onmouseover="this.style.color = 'red'"
            onmouseleave="this.style.color = 'blue'">
            New User? Register here!
          </a>
          <a href="./profile/forgot-pwd.php" class="recover-password" onmouseleave="this.style.color = 'blue'"
            onmouseover="this.style.color = 'red'">Forget your password?</a>
        </form>
      </div>
    </div>
  </div>

  <script>
    var filter_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var filter_password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[.!@#\$%\^&\*]).{8,}$/;
    
    function checkEmail() {
      var email = document.getElementById("id").value;
      if (!filter_email.test(email)) {
        document.getElementById("msgEmail").innerHTML = "Invalid email address!";
        return false;
      }
      else {
        document.getElementById("msgEmail").innerHTML = "";
        return true;
      }
    }
    function checkPwd() {
      var pwd = document.getElementById("password").value;
      if (!filter_password.test(pwd)) {
        document.getElementById("msgPwd").innerHTML = "Invalid password!";
        return false;
      }
      else {
        document.getElementById("msgPwd").innerHTML = "";
        return true;
      }
    }
    function checkAll() {
      if (checkEmail() && checkPwd()) { return true; }
      else {
        alert("Please enter all information correctly!");
        return false;
      }
    }
  </script>
</body>

</html>
