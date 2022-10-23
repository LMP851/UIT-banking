<?php
session_start();
if(isset($_SESSION['account_no'],$_SESSION['receiver_account_no'])){
$g11_debit_account = $_SESSION['account_no'];
$g11_beneficiary_account = $_SESSION['receiver_account_no'];
unset($_SESSION['receiver_account_no']);
$g11_conn = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");
$g11_stmt = mysqli_prepare($g11_conn, "SELECT * FROM register WHERE account_no = ?");
mysqli_stmt_bind_param($g11_stmt, "s", $g11_beneficiary_account);
mysqli_stmt_execute($g11_stmt);
$g11_result_receiver = mysqli_stmt_get_result($g11_stmt);
$g11_receiver_row = mysqli_fetch_array($g11_result_receiver,MYSQLI_ASSOC);
$g11_beneficiary_name = $g11_receiver_row['firstname']." ".$g11_receiver_row['lastname'];
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$g11_amount = $_POST['amount'];
	$g11_content = $_POST['remark'];
}
date_default_timezone_set("Asia/Ho_Chi_Minh");
$g11_transaction_date = date("d/m/Y");
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
    <link rel="stylesheet" href="../asset/themify-icon/themify-icons/themify-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"> </script>
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
                document.getElementById("account_noo").setCustomValidity("");
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

        const modalBtn = document.getElementById("call-modal");
        const modalContainer = document.getElementById("js-modal-container");
        function showModal() {
            const modalContent = document.getElementById("js-modal");
            modalContent.classList.add('open');
            $.ajax({
    				url: "sendOTP.php",
    				type: "POST",
    				data: {sendOTP: 1},
    				dataType: "text",
    				success: function(data){
    				}
    			});
        }

        function RemoveModal() {
            const modalContent = document.getElementById("js-modal");
            modalContent.classList.remove('open');
            
        }

        function showAlert() {
            alert("hello");
        }
        
        modalContainer.addEventListener('click', function (event) {
            event.stopPropagation();
        });
        // modalBtn.addEventListener('click', alert("alo"))
        modalContent.addEventListener('click', RemoveModal());
	
	/*
	$(document).ready(function(){
    		$("#call-modal").click(function(){
    			$.ajax({
    				url: "sendOTP.php",
    				type: "POST",
    				data: {sendOTP: 1},
    				dataType: "text",
    				success: function(data){
    					alert("oke");
    				}
    			});
    		});
   	});
   	*/

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


    <div class="tranfer2 transfer transfer3-body">
        <div class="transfer3-content">
            <div class="tranfer2 tranfer transfer3-header">
                <h2>Transaction Confirmation</h2>
            </div>

            <form method="POST" onsubmit="" action="transfer4.php" class="form-section transfer2">
                <div class="tab inner-form transfer2 transfer">
                    <div class="transfer2 first transfer inner-block input-account">
                        <div class="transfer2 block-item block-column amount-unit transfer3">
                            <span class="transfer2 transfer unit">Debit account</span>
                        </div>
                        <div class="transfer2 block-item block-column user-account transfer3">
                            <input type="text" name="debit_account" value="<?php echo $g11_debit_account ?>" readonly="readonly"
                                class="transfer2 transfer question transfer3" id="debit_account" required
                                autocomplete="off" />
                        </div>
                    </div>

                    <div class="transfer2 first transfer inner-block input-account">
                        <div class="transfer2 block-item block-column amount-unit transfer3">
                            <span class="transfer2 transfer unit">Beneficiary account</span>
                        </div>
                        <div class="transfer2 block-item block-column user-account transfer3">
                            <input type="text" name="beneficiary_account" value="<?php echo $g11_beneficiary_account ?>" readonly="readonly"
                                class="transfer2 transfer question transfer3" id="beneficiary_account" required autocomplete="off" />
                        </div>
                    </div>


                    <div class="transfer2 first transfer inner-block input-account">
                        <div class="transfer2 block-item block-column amount-unit transfer3">
                            <span class="transfer2 transfer unit">Beneficiary name</span>
                        </div>
                        <div class="transfer2 block-item block-column user-account transfer3">
                            <input type="text" name="beneficiary_name" value="<?php echo $g11_beneficiary_name ?>" readonly="readonly"
                                class="transfer2 transfer question transfer3" id="beneficiary_name" required autocomplete="off" />
                        </div>
                    </div>

                    <div class="transfer2 first transfer inner-block input-account">
                        <div class="transfer2 block-item block-column amount-unit transfer3">
                            <span class="transfer2 transfer unit">Amount</span>
                        </div>
                        <div class="transfer2 block-item block-column user-account transfer3">
                            <input type="text" name="amount" value="<?php echo $g11_amount ?>" readonly="readonly"
                                class="transfer2 transfer question transfer3" id="amount" required autocomplete="off" />
                        </div>
                    </div>

                    <div class="transfer2 first transfer inner-block input-account">
                        <div class="transfer2 block-item block-column amount-unit transfer3">
                            <span class="transfer2 transfer unit">Transaction date</span>
                        </div>
                        <div class="transfer2 block-item block-column user-account transfer3">
                            <input type="text" name="transaction_date" value="<?php echo $g11_transaction_date ?>" readonly="readonly"
                                class="transfer2 transfer question transfer3" id="transaction_date" required autocomplete="off" />
                        </div>
                    </div>

                    <div class="transfer2 first transfer inner-block input-account">
                        <div class="transfer2 block-item block-column amount-unit transfer3">
                            <span class="transfer2 transfer unit">Content</span>
                        </div>
                        <div class="transfer2 block-item block-column user-account transfer3">
                            <input type="text" name="content" value="<?php echo $g11_content ?>" readonly="readonly"
                                class="transfer2 transfer question transfer3" id="content" required autocomplete="off" />
                        </div>
                    </div>

                    <div class="modal-content" id="js-modal">
                        <div class="modal-container" id="js-modal-container">
                            <div class="tranfer2 tranfer transfer3-header">
                                <div class="close-button">  
                                    <button onclick="RemoveModal()"><i class="ti ti ti-close"></i></button>
                                </div>
                                <h2>VERIFY</h2>
                            </div>
                            <div id='test-ajax'>
                            </div>
                            <div class="modal input-container">
                                <div class="modal transfer2 transfer inner-block input-account">
                                    <div class="modal transfer2 block-item block-column user-account">
                                        <input type="text" placeholder="Enter OTP code here" name="otp"
                                            class="transfer2 transfer question transfer3" id="otp" required
                                            autocomplete="off" />
                                    </div>
                                </div>
                                <input type="submit" value="SUBMIT" class="modal-submit-btn">
                            </div>
                        </div>
                    </div>

                    <input type="button" id="call-modal" onclick="showModal()" value="CONFIRM"
                        class="transfer3 transfer transfer3-submit">
                </div>

            </form>
        </div>
    </div>
</body>

</html>


