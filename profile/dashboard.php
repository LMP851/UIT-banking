<?php
session_start();
if(isset($_SESSION['account_no'])){
$g11_account_no = $_SESSION['account_no'];
$g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");
$g11_resultb = mysqli_query($g11_con, "SELECT * FROM balance WHERE account_no = '$g11_account_no'");
$g11_resultr = mysqli_query($g11_con, "SELECT * FROM register WHERE account_no = '$g11_account_no'");
$g11_rowb = mysqli_fetch_array($g11_resultb,MYSQLI_ASSOC);
$g11_rowr = mysqli_fetch_array($g11_resultr,MYSQLI_ASSOC);
$g11_balance = $g11_rowb['balance'];
$g11_firstname = $g11_rowr['firstname'];
$g11_lastname = $g11_rowr['lastname'];
/*echo'
	<script type="text/javascript">
        sessionStorage.setItem("login", true);
        </script>';*/
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
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../asset/themify-icon/themify-icons/themify-icons.css">
</head>

<body>
  <div id="header">
    <div class="header-content">
      <div class="home-direct">
        <a href="">
          <img src="../asset/img/banner_0.png" alt="" height="60">
        </a>
      </div>
      <!-- <div class="direct-container">
            <a class="direct-link" href="dashboard.php"><i class="fa fa-fw fa-calculator "></i>Dashboard</a>
            <a class="direct-link" href="profile.php" class="active"><i
                    class="fa fa-fw fa-id-card-o "></i>Profile</a>
            <a class="direct-link" href="transfer.php"><i class="fa fa-fw fa-cogs "></i>Transfer</a>
            <a class="direct-link" href="transactions.php"><i class="fa fa-fw fa-file-text "></i>Transactions</a>
        </div> -->
      <div class="direct-container">
        <a class="direct-link " href="../login/login.php"><i class="fa fa-fw fa-sign-out "></i>Logout</a>
      </div>
    </div>
  </div>

  <div id="dashBoardContent">
    <div class="dashboard-container">
      <div class="dashboard-content">
        <div class="user-section">
          <div class="user-in4">
            <!-- echo ten nguoi dung -->
            <h4 class="name">Current account</h4>
            <!-- echo STK  -->
            <h3 class="account-id"><?php echo $g11_account_no ?></h3>
          </div>
          <div class="user-balance">
            <h4>Available balance</h4>
            <!-- echo số dư hiện tại, nhớ để cái VND lại-->
            <h3 class="available-balance"> <?php echo $g11_balance ?> VND</h3>
          </div>
        </div>
        <div class="service-section">
          <a class="service-box" href="./transfer.php">
              <i class="ti ti-arrows-horizontal service-icon"></i>
              <h3>transfer</h3>
          </a>
          <a href="./transactions.php" class="service-box">
            <i class="ti ti-layout-list-thumb service-icon"></i>
            <h3>transaction</h3>
          </a>
          <a href="./profile.php" class="service-box">
            <i class="ti ti-user service-icon"></i>
            <h3>
              Your Profile
            </h3>
          </a>
          <!-- <div class="service-box"></div> -->
        </div>
      </div>
    </div>
  </div>
</body>

</html>
