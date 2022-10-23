
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if(isset($_SESSION['account_no'])){
	require '../vendor/autoload.php';
if (isset($_POST['sendOTP']))
{
	$g11_debit_account = $_SESSION['account_no'];
	$g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");
	$g11_stmt = mysqli_prepare($g11_con, "SELECT * FROM register WHERE account_no = ?");
	mysqli_stmt_bind_param($g11_stmt, "s", $g11_debit_account);
	mysqli_stmt_execute($g11_stmt);
	$g11_result = mysqli_stmt_get_result($g11_stmt);
	$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
        $g11_count = mysqli_num_rows($g11_result);
	$g11_email = $g11_row['email'];
	$g11_otp = mysqli_real_escape_string($g11_con,mt_rand(100000,999999));

	if ($g11_count > 0) {
	$g11_stmt = mysqli_prepare($g11_con, "UPDATE register SET token=? WHERE email=?");
	mysqli_stmt_bind_param($g11_stmt, "ss", $g11_otp, $g11_email);
	$query = mysqli_stmt_execute($g11_stmt);
        
	if ($query) {   
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
                $mail->Subject = 'OTP CODE - NO REPLY';
                $mail->Body    = 'This is your otp code <b>'.$g11_otp.'</b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";        
            echo "<script>alert(We've sent a OTP code on your email address.)</script>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>$g11_email - This email address do not found.</div>";
    }
}
}
}
else {
	$message = "You do not have access to this page.";
	echo "<script type='text/javascript'>alert('$message');</script>";
	header("refresh:0;url=../login/login.php");
}
?>
