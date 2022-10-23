<?php
session_start();
if(isset($_SESSION['account_no'])){
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type=text/javascript>
    
    var filter_account = /^[0-9]{10}$/;
    function myFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") {
        x.className += " responsive";
      } else {
        x.className = "topnav";
      }
    }
    function validate() {
      var v = document.getElementById("amount").value;
      if (isNaN(v)) {
        document.getElementById("msg").innerHTML = "Should be a Number";
      }
      else {
        document.getElementById("msg").innerHTML = "";
      }
    }
    function checkAccount() {
      var account = document.getElementById("account_noo").value;
      if (!filter_account.test(account)) {
        document.getElementById("account_noo").setCustomValidity("Invalid account number!");
        document.getElementById("account_noo").reportValidity();
        return false;
      }
      else {
        document.getElementById("account_noo").setCustomValidity("")
        return true;
      }
    }
    
    function checkExist() {
    	var exist = document.getElementsByTagName("h3").textContent;
    	if (exist === "") {
    		alert("Please press Check to check account existing or not");
    		return false;
    	}
    	if (exist === "Account does not exist!") {
    		alert("Please enter information correctly!");
    		return false;
    	}
    	return true;
    }
    
    function checkAll() {
      if (checkAccount() && validate()) { return true; }
      else {
        alert("Please enter all information correctly!");
        return false;
      }
      if(document.getElementById('findName').clicked == false)
	{
   		alert("You should check your account name before continuing!");
   		return false;
	}
	else {
		return true;
	}
    }
    
    $(document).ready(function(){
    	$("#findName").click(function(){
    		var account_num = $("#account_noo").val();
    		var message = null;
    		var flag = 0;
    		$.ajax({
    			url: "check.php",
    			type: "POST",
    			data: {account_num: account_num},
    			dataType: "text",
    			success: function(data){
    				$("h3").html(data);
    				message = data;
    				if( message =="Account does not exist!" || message =="no" || message ==""){
    					$("#Next").prop('disabled', true); // disable button
    					flag = 0;
    				}
    				else {
    					$("#Next").prop('disabled', false); // enable button
    					flag = 1;
    				}    			
    			}
    		});
    	});
   });
   function disable() {
   	if( !flag == 1){
       document.getElementById("Next").disabled = true;
       }
       else {
       document.getElementById("Next").disabled = false;
       flag = 0;
       }       
   }
 
</script>
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
        <a class="direct-link " href="logout.php"><i class="fa fa-fw fa-sign-out "></i>Logout</a>
      </div>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>

  <div class="transfer1 form-body">
    <div class="transfer1 transfer form-content">
      <div class="register2 user-profile form-title">
        <img src="../asset/img/logo-uit.png" alt="" width="30" height="30">
        <h2>UIT Bank</h2>
      </div>
<!-- begin -->

<!-- end -->

      <form method="POST" action="transfer2.php" onsubmit ="return checkExist()" class="form-section transfer1" id="check">
        <div class="tab inner-form transfer1 transfer">
          <div class="transfer1 transfer inner-block input-account">
            <div class="transfer1 block-item block-column user-account">
              <input type="text" name="account_noo" placeholder=" " oninput="checkAccount()" class="transfer1 transfer question"
                id="account_noo" required autocomplete="off" />
              <label for="account_noo"><span>Account Number</span></label>
            </div>
            
            <!-- CHECK -->
            <div class="transfer1 block-item block-column">
              <input type="button" value="Check" name="findName" class="transfer1 transfer input-btn" id="findName">
            </div>
          </div>

          <!-- Display ten tài khoản nhận tiền -->
          <div class="transfer1 block-item block-column account-name">
            <h3 class="account-name-display"></h3>
          </div>
          <!-- NEXT -->
          <div class="transfer1 block-item block-column next-btn">
            <input type="submit" value="Next" onclick="disable()" name="Next" class="transfer1 transfer input-next-btn input-btn" id="Next">
          </div>
        </div>

      </form>
    </div>
  </div>
</body>
</html>

