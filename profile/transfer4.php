<?php 
session_start();
$g11_debit_account = $_SESSION['account_no'];
if(isset($_SESSION['account_no'])){
if (isset($_POST['otp']))
{
	$g11_otp = $_POST['otp'];
	$g11_conn = mysqli_connect("localhost","nhom11","Thanh@19522235","bank"); 
	$g11_stmt = mysqli_prepare($g11_conn, "SELECT * FROM register WHERE account_no = ?");
	mysqli_stmt_bind_param($g11_stmt, "s", $g11_debit_account);
	mysqli_stmt_execute($g11_stmt);
	$g11_query = mysqli_stmt_get_result($g11_stmt);
	$g11_otp_database = mysqli_fetch_array($g11_query, MYSQLI_ASSOC)['token'];
        
        $g11_stmt = mysqli_prepare($g11_conn, "SELECT * FROM balance WHERE account_no = ?");
	mysqli_stmt_bind_param($g11_stmt, "s", $g11_debit_account);
	mysqli_stmt_execute($g11_stmt);
	$g11_result_sender = mysqli_stmt_get_result($g11_stmt);  
        
	if(mysqli_fetch_array($g11_result_sender,MYSQLI_ASSOC)['balance'] <= $_POST['amount'])
	{
		echo"<script>alert('You don't have enough money! Such a poor guy!')</script>";
		header("refresh:0;url=../profile/transfer.php");
	}	
	if($g11_otp == $g11_otp_database)
	{
		$g11_debit_account = $_POST['debit_account'];
		$g11_beneficiary_account = $_POST['beneficiary_account'];
		$g11_beneficiary_name = $_POST['beneficiary_name'];
		$g11_amount = $_POST['amount'];
		$g11_transaction_date = $_POST['transaction_date'];
		$g11_content = $_POST['content'];
		$g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","bank"); 
		
		$g11_stmt = mysqli_prepare($g11_con, "SELECT * FROM balance WHERE account_no = ?");
		mysqli_stmt_bind_param($g11_stmt, "s", $g11_debit_account);
		mysqli_stmt_execute($g11_stmt);
		$g11_result_sender = mysqli_stmt_get_result($g11_stmt);  
		
		$g11_stmt = mysqli_prepare($g11_con, "SELECT * FROM balance WHERE account_no = ?");
		mysqli_stmt_bind_param($g11_stmt, "s", $g11_beneficiary_account);
		mysqli_stmt_execute($g11_stmt);
		$g11_result_receiver = mysqli_stmt_get_result($g11_stmt);
		
		$g11_sender_row = mysqli_fetch_array($g11_result_sender,MYSQLI_ASSOC);
		$g11_receiver_row = mysqli_fetch_array($g11_result_receiver,MYSQLI_ASSOC);
		
		$g11_new_balance_sender = $g11_sender_row['balance'] - $g11_amount;
		$g11_new_balance_receiver = $g11_receiver_row['balance'] + $g11_amount;
		
		$g11_stmt = mysqli_prepare($g11_con, "UPDATE balance SET balance=? WHERE account_no=?");
		mysqli_stmt_bind_param($g11_stmt, "ss", $g11_new_balance_sender, $g11_debit_account);
		mysqli_stmt_execute($g11_stmt);
		$g11_query = mysqli_stmt_get_result($g11_stmt);
		
		$g11_stmt = mysqli_prepare($g11_con, "UPDATE balance SET balance=? WHERE account_no=?");
		mysqli_stmt_bind_param($g11_stmt, "ss", $g11_new_balance_receiver, $g11_beneficiary_account);
		mysqli_stmt_execute($g11_stmt);
		$g11_query = mysqli_stmt_get_result($g11_stmt);

		$g11_stmt = mysqli_prepare($g11_con, "UPDATE register SET token='', status='1' WHERE account_no = ?");
		mysqli_stmt_bind_param($g11_stmt, "ss", $g11_debit_account);
		mysqli_stmt_execute($g11_stmt);
		$g11_query = mysqli_stmt_get_result($g11_stmt);
		
		$remark_receiver = "SD TK ".$g11_beneficiary_account." +".$g11_amount."VND";
    		$remark_sender = "SD TK ".$g11_debit_account." -".$g11_amount."VND";
    		$amount_receiver = "+".$g11_amount;
    		$amount_sender = "-".$g11_amount;
    		
    		$g11_conn_2 = mysqli_connect("localhost","nhom11","Thanh@19522235","transactions");
    		$g11_query_2 = mysqli_multi_query($g11_conn_2, "INSERT INTO `$g11_debit_account` (date, remark, message, amount, balance, interactor) VALUES('$g11_transaction_date', '$remark_sender','$g11_content', '$amount_sender','$g11_new_balance_sender','$g11_beneficiary_account'); INSERT INTO `$g11_beneficiary_account` (date, remark, message, amount, balance, interactor) VALUES('$g11_transaction_date', '$remark_receiver','$g11_content', '$amount_receiver','$g11_new_balance_receiver','$g11_debit_account');"); 
    		/*
    		$g11_stmt = mysqli_prepare($g11_conn_2, "INSERT INTO `?` (date, remark, message, amount, balance, interactor) VALUES('?', '?','?', '?','?','?')");
		mysqli_stmt_bind_param($g11_stmt, "sssssss", $g11_debit_account, $g11_transaction_date, $g11_remark_sender, $g11_content, $g11_amount_sender, $g11_new_balance_sender, $g11_beneficiary_account);
		mysqli_stmt_execute($g11_stmt);
		
		$g11_stmt = mysqli_prepare($g11_conn_2, "INSERT INTO `?` (date, remark, message, amount, balance, interactor) VALUES('?', '?','?', '?','?','?')");
		mysqli_stmt_bind_param($g11_stmt, "sssssss", $g11_beneficiary_account, $g11_transaction_date, $g11_remark_receiver, $g11_content, $g11_amount_receiver, $g11_new_balance_receiver, $g11_debit_account);
		mysqli_stmt_execute($g11_stmt);
		*/
	}
	else
	{
		echo"<script>alert('OTP incorrect. Trading session is terminated')</script>";
		header("refresh:0;url=../profile/transfer.php");
	}
}
}
else
{
	echo "<script>alert('Unknown fault. Trading session is terminated')</script>";
	header("refresh:0;url=../profile/transfer.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <title>UIT Bank</title>
        <link rel="icon" href="../asset/img/logo-uit.png" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/response.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../asset/themify-icon/themify-icons/themify-icons.css">
        <script>
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
            function checkAll() {
                if (checkAccount() && validate()) { return true; }
                else {
                    alert("Please enter all information correctly!");
                    return false;
                }
            }
    
            const modalBtn = document.getElementById("call-modal")
            const modalContainer = document.getElementById("js-modal-container")
            function showModal() {
                const modalContent = document.getElementById("js-modal")
                modalContent.classList.add('open')
            }
    
            function RemoveModal() {
                const modalContent = document.getElementById("js-modal")
                modalContent.classList.remove('open')
            }
    
            function showAlert() {
                alert("hello")
            }
            modalContainer.addEventListener('click', function (event) {
                event.stopPropagation()
            })
            // modalBtn.addEventListener('click', alert("alo"))
            modalContent.addEventListener('click', RemoveModal())
    
    
        </script>
    </head>
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
                <a class="direct-link" href="profile.php" class="active"><i
                        class="fa fa-fw fa-id-card-o "></i>Profile</a>
                <a class="direct-link" href="transfer.php"><i class="fa fa-fw fa-cogs "></i>Transfer</a>
                <a class="direct-link" href="transactions.php"><i class="fa fa-fw fa-file-text "></i>Transactions</a>
            </div>
            <div class="direct-container">
                <a class="direct-link " href="logout.php"><i class="fa fa-fw fa-sign-out "></i>Logout</a>
            </div>
            <a href="javascript:void(0);" class="icon" onclick="">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>

    <div class="receipt transfer form-body">
        <div class="receipt transfer receipt-container">
            <div class="receipt receipt-header">
                <h1 class="title">UIT BANK</h1>
                <h2 class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </svg></h2>
                  <h2 class="transfer-status">Successful transaction!</h2>
                  <h2 class="transfer-amount"><?php echo $g11_amount ?></h2>
                  <p class="time"><?php echo $g11_transaction_date ?></p>
            </div>
            <div class="receipt-section">
                <div class="receipt-content">
                    <div class="receipt detail1">
                        <span class="transfer2 receipt transfer unit"><?php echo $g11_debit_account ?></span>
                    </div>
                    <div class="receipt detail2">
                        <span class="transfer2 receipt transfer unit"></span>
                    </div>
                </div>
                <div class="receipt-content">
                    <div class="receipt detail1">
                        <span class="transfer2 receipt transfer unit">Beneficiary name</span>
                    </div>
                    <div class="receipt detail2">
                        <span class="transfer2 receipt transfer unit"><?php echo $g11_beneficiary_name ?></span>
                    </div>
                </div>
                <div class="receipt-content">
                    <div class="receipt detail1">
                        <span class="transfer2 receipt transfer unit">Transaction ID</span>
                    </div>
                    <div class="receipt detail2">
                        <span class="transfer2 receipt transfer unit">123456789</span>
                    </div>
                </div>
                <div class="receipt-content">
                    <div class="receipt detail1">
                        <span class="transfer2 receipt transfer unit">Content</span>
                    </div>
                    <div class="receipt detail2">
                        <span class="transfer2 receipt transfer unit"><?php echo $g11_content ?></span>
                    </div>
                </div>

                <div class="new-btn">
                    <button><a href="../profile/transfer.php">Initiate new transaction</a></button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

