<?php
session_start();
if(isset($_SESSION['account_no'])){
$g11_account_num_sender = $_SESSION['account_no'];
$g11_conn = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");

//prepare statement
$g11_stmt = mysqli_prepare($g11_conn, "SELECT * FROM balance WHERE account_no = ?");
mysqli_stmt_bind_param($g11_stmt, "s", $g11_account_num_sender);
mysqli_stmt_execute($g11_stmt);
$g11_result_sender_1 = mysqli_stmt_get_result($g11_stmt);
$g11_sender_row_1 = mysqli_fetch_array($g11_result_sender_1,MYSQLI_ASSOC);
$g11_sender_balance = $g11_sender_row_1['balance'];

$g11_stmt = mysqli_prepare($g11_conn, "SELECT * FROM register WHERE account_no = ?");
mysqli_stmt_bind_param($g11_stmt, "s", $g11_account_num_sender);
mysqli_stmt_execute($g11_stmt);
$g11_result_sender_2 = mysqli_stmt_get_result($g11_stmt);
$g11_sender_row_2 = mysqli_fetch_array($g11_result_sender_2,MYSQLI_ASSOC);
$g11_sender_fullname = $g11_sender_row_2['firstname']." ".$g11_sender_row_2['lastname'];

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$g11_account_num_receiver = $_POST['account_noo'];
	$g11_stmt = mysqli_prepare($g11_conn, "SELECT * FROM register WHERE account_no = ?");
	mysqli_stmt_bind_param($g11_stmt, "s", $g11_account_num_receiver);
	mysqli_stmt_execute($g11_stmt);
	$g11_result_receiver_2 = mysqli_stmt_get_result($g11_stmt);
	$g11_receiver_row_2 = mysqli_fetch_array($g11_result_receiver_2,MYSQLI_ASSOC);
	$g11_receiver_fullname = $g11_receiver_row_2['firstname']." ".$g11_receiver_row_2['lastname'];
	$_SESSION['receiver_account_no'] = $g11_account_num_receiver;
}
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
        /*
        function checkAccount() {
            var account = document.getElementById("amount").value;
            if (!filter_account.test(account)) {
                document.getElementById("amount").setCustomValidity("Invalid account number!");
                document.getElementById("amount").reportValidity();
                return false;
            }
            else {
                document.getElementById("amount").setCustomValidity("")
                return true;
            }
        }
        */
        
        function checkAll() {
            if (validate()) { return true; }
            else {
                alert("Please enter all information correctly!");
                return false;
            }
        }

        // const modal = document.querySelector('.modal-body')
        // const NextBtn = document.querySelector('#Next')
        // const modelContent = document.querySelector('.modal-content')
        // function showBuyTicket () {
        //     modal.classList.add('open')
        // }

        // function RemoveBuyTicket () {
        //     modal.classList.remove('open')
        // }
        // // NextBtn.addEventListener("click",showBuyTicket)
        // modal.addEventListener('click', RemoveBuyTicket)

        // modelContainer.addEventListener('click', function(event) {
        //     event.stopPropagation()
        // })
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
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>


    <div class="transfer2 form-body">
        <div class="transfer2 arrow-container">
            <div class="transfer2 cover">
                <div class="transfer2 sender infor-container">
                    <div class="sender content">
                        <h3><?php echo $g11_sender_fullname ?></h3>
                        <h4><?php echo $g11_sender_balance ?></h4>
                    </div>
                </div>
                <div class="transfer2 receiver infor-container">
                    <div class="receiver content">
                    	<h3><?php echo $g11_receiver_fullname ?></h3>
                        <h4><?php echo $g11_account_num_receiver ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="transfer2 transfer form-content">
            <div class="register2 user-profile form-title">
                <img src="../asset/img/logo-uit.png" alt="" width="30" height="30">
                <h2>UIT Bank</h2>
            </div>

            <form method="POST" onsubmit="" action="transfer3.php" class="form-section transfer2">
                <div class="tab inner-form transfer2 transfer">
                    <div class="transfer2 first transfer inner-block input-account">
                        <div class="transfer2 block-item block-column user-account">
                            <input type="text" name="amount" placeholder=" " oninput="checkAccount()"
                                class="transfer2 transfer question" id="amount" required autocomplete="off" />
                            <label for="amount"><span>Amount</span></label>
                        </div>
                        <div class="transfer2 block-item block-column amount-unit">
                            <span class="transfer2 transfer unit">VND</span>
                        </div>
                    </div>


                    <!-- Echo vào cái value -->
                    <div class="transfer2 transfer second inner-block input-account">
                        <div class="transfer2 block-item block-column user-account">
                            <input type="text" min="1" max="250" name="remark" oninput=""
                                class="transfer2 transfer question remark" value="<?php echo $g11_sender_fullname." chuyen tien." ?>" id="remark"
                                required autocomplete="off" />
                            <label for="remark"><span>Transaction remark</span></label>
                        </div>

                    </div>

                    <div class="transfer2 block-item block-column next-btn">
                        <input type="submit" value="Next" name="Next"
                            class="transfer2 transfer input-next-btn input-btn" id="Next">
                    </div>
                </div>

            </form>

            
        </div>

        <!-- <div class="tranfer2 transfer modal-body">
            <div class="modal-content">
                <div class="tranfer2 tranfer modal-header">
                    <h3>Transaction Confirmation</h3>
                </div>

                <form method="POST" onsubmit="" action="" class="form-section transfer2">
                    <div class="tab inner-form transfer2 transfer">
                        <div class="transfer2 first transfer inner-block input-account">
                            <div class="transfer2 block-item block-column amount-unit modal">
                                <span class="transfer2 transfer unit">Debit account</span>
                            </div>
                            <div class="transfer2 block-item block-column user-account modal">
                                <input type="text" name="amount" value="" class="transfer2 transfer question"
                                    id="debit-account" required autocomplete="off" />
                            </div>
                        </div>

                        <div class="transfer2 first transfer inner-block input-account">
                            <div class="transfer2 block-item block-column amount-unit modal">
                                <span class="transfer2 transfer unit">Beneficiary account</span>
                            </div>
                            <div class="transfer2 block-item block-column user-account modal">
                                <input type="text" name="amount" class="transfer2 transfer question" id="amount"
                                    required autocomplete="off" />
                            </div>
                        </div>


                        <div class="transfer2 first transfer inner-block input-account">
                            <div class="transfer2 block-item block-column amount-unit modal">
                                <span class="transfer2 transfer unit">Beneficiary name</span>
                            </div>
                            <div class="transfer2 block-item block-column user-account modal">
                                <input type="text" name="amount" class="transfer2 transfer question" id="amount"
                                    required autocomplete="off" />
                            </div>
                        </div>

                        <div class="transfer2 first transfer inner-block input-account">
                            <div class="transfer2 block-item block-column amount-unit modal">
                                <span class="transfer2 transfer unit">Amount</span>
                            </div>
                            <div class="transfer2 block-item block-column user-account modal">
                                <input type="text" name="amount" class="transfer2 transfer question" id="amount"
                                    required autocomplete="off" />
                            </div>
                        </div>

                        <div class="transfer2 first transfer inner-block input-account">
                            <div class="transfer2 block-item block-column amount-unit modal">
                                <span class="transfer2 transfer unit">Transaction date</span>
                            </div>
                            <div class="transfer2 block-item block-column user-account modal">
                                <input type="text" name="amount" class="transfer2 transfer question" id="amount"
                                    required autocomplete="off" />
                            </div>
                        </div>

                        <div class="transfer2 first transfer inner-block input-account">
                            <div class="transfer2 block-item block-column amount-unit modal">
                                <span class="transfer2 transfer unit">Content</span>
                            </div>
                            <div class="transfer2 block-item block-column user-account modal">
                                <input type="text" name="amount" class="transfer2 transfer question" id="amount"
                                    required autocomplete="off" />
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div> -->
    </div>


</body>

</html>    	 
