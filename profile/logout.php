<?php
  session_start();
  session_unset();
  session_destroy();
  header("refresh:0;url=../login/login.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>UIT Bank</title>
    <link rel="icon" href="../asset/img/logo-uit.png" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/response.css">

<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="../img/lg.png" height="44" width="204.8">
  <a href="../index.php" class="active"><i class="fa fa-fw fa-home "></i>Home</a>
  <a href="../login/login.php" style="float: right"><i class="fa fa-fw fa-sign-in "></i>Login</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<br><br>
  <center>
    <h1>Thank you for banking with UIT Bank</h1>
    <hr>
    <p>You have been logged out of Internet Banking services of UIT Bank</p>
    <p>Please close this window for security reasons</p>
  </center>
</body>
</html>
