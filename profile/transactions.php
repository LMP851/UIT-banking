<?php
session_start();
if(isset($_SESSION['account_no'])){
	$g11_account_no = $_SESSION['account_no'];
	$g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","transactions");
	$g11_result = mysqli_query($g11_con, "SELECT * FROM `$g11_account_no`");
}
else {
	$message = "You do not have access to this page.";
	echo "<script type='text/javascript'>alert('$message');</script>";
	header("refresh:0;url=../login/login.php");
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
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>
<style type="text/css">
  table { border: 1px solid black; border-collapse: collapse; }
  table td{border: 1px solid black;}
  table th{border: 1px solid black;}
</style>
</head>
<body>

<div id="header">
    <div class="header-content">
      <div class="home-direct">
        <a href="">
          <img src="../asset/img/banner_0.png" alt="" height="60">
        </a>
      </div>
      <div class="direct-container">
        <a class="direct-link" href="dashboard.php"><i class="fa fa-fw fa-calculator "></i>Dashboard</a>
        <a class="direct-link" href="profile.php" class="active"><i class="fa fa-fw fa-id-card-o "></i>Profile</a>
        <a class="direct-link" href="transfer.php"><i class="fa fa-fw fa-cogs "></i>Transfer</a>
        <a class="direct-link" href="transactions.php"><i class="fa fa-fw fa-file-text "></i>Transactions</a>
      </div>
      <div class="direct-container">
        <a class="direct-link " href="logout.php" style="float: right"><i class="fa fa-fw fa-sign-out "></i>Logout</a>
      </div>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>
<br><br>
<center>
  <div style="background-color: #4CAF50; height: 45px; width: 100%; color: white; "><h1>My Transaction</h1></div>
  <br><br>
  <table cellpadding="6" width="80%">
    <tr>
      <th align="center">Date</th>
      <th align="center">Remarks</th>
      <th align="center">Message</th>
      <th align="center">Amount</th>
      <th align="center">Account Balance</th>
      <th align="center">Interactor</th>
    </tr>
    <?php
      $g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
      while ($g11_row) {
          echo "<tr><td align=\"center\">".$g11_row['date']."</td><td align=\"center\">".$g11_row['remark']."</td><td align=\"center\">".$g11_row['message']."</td><td align=\"center\">".$g11_row['amount']."</td><td align=\"center\">".$g11_row['balance']."</td><td align=\"center\">".$g11_row['interactor']."</td></tr>";
        $g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
      }
    ?>
  </table>
</center>
</body>
</html>
