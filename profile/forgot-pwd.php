<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require '../vendor/autoload.php';
if(isset($_SESSION['account_no'])){
	header("refresh:0;url=../profile/dashboard.php");
}
else{
$g11_connection = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");

if (!$g11_connection) {
   die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $g11_email = $_POST['email'];
    $g11_token = mysqli_real_escape_string($g11_connection, md5(rand()));
        $g11_result = mysqli_query($g11_connection, "SELECT email FROM register WHERE email='$g11_email'");
        $g11_count = mysqli_num_rows($g11_result);    
    
    if ($g11_count > 0) {
        $query = mysqli_query($g11_connection, "UPDATE register SET token='{$g11_token}' WHERE email='{$g11_email}'");

        if ($query) {        
            echo "<div style='display: none;'>";
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = '19520223@gm.uit.edu.vn';                     //SMTP username
                $mail->Password   = '1614205866';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('19520223@gm.uit.edu.vn');
                $mail->addAddress($g11_email);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'no reply';
                $mail->Body    = 'Here is the verification link <b><a href="http://localhost/profile/change-pwd.php?reset='.$g11_token.'">http://localhost/profile/change-pwd.php?reset='.$g11_token.'</a></b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";        
            $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>$g11_email - This email address do not found.</div>";
    }
}
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
                <a class="direct-link " href="../login/login.php"><i class="fa fa-fw fa-sign-out "></i>Login</a>
            </div>
            <a href="javascript:void(0);" class="icon" onclick="">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>


    <div class="tranfer2 transfer transfer3-body">
        <div class="recover-pw transfer3-content">
            <h2>Recover password</h2>
            <form method="post" class="form-section transfer2">
                <h3>Email validation</h3>
                <p style="font-size: 14px;">Enter your registered email to get validation link!</p>
                <div class="recover-pw inner-form transfer2 transfer">
                    <div class="recover-pw input-container">
                        <div class="recover-pw transfer2 transfer inner-block input-account">
                            <div class="recover-pw transfer2 block-item block-column user-account">
                                <input type="email" placeholder="Enter your email here" name="email"
                                    classmy="recover-pw transfer2 transfer question transfer3 email" id="email" required
                                    autocomplete="off" />
                            </div>
                        </div>
                        <input type="submit" value="Confirm" class="recover-pw submit-btn"> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
