<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  session_start();
  if(isset($_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['email'], $_SESSION['password'])){
    $g11_fname = $_SESSION['firstname'];
    $g11_lname = $_SESSION['lastname'];
    $g11_email = $_SESSION['email'];
    $g11_password = $_SESSION['password'];
    $_SESSION['firstname'] = $g11_fname;
    $_SESSION['lastname'] = $g11_lname;
    $_SESSION['email'] = $g11_email;
    $_SESSION['password'] = $g11_password;
    $g11_connection = mysqli_connect("localhost", "nhom11", "Thanh@19522235", "bank");
    $g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","transactions");
    require '../vendor/autoload.php';
    if (!$g11_connection || !$g11_con) {
      die("Connection failed: " . mysqli_connect_error());
    }
    if(isset($_POST['submit'])){
      $g11_fname = $_SESSION['firstname'];
      $g11_lname = $_SESSION['lastname'];
      $g11_email = $_SESSION['email'];
      $g11_password = $_SESSION['password'];
      $g11_token = mysqli_real_escape_string($g11_connection, md5(rand()));
      $g11_phone = $_POST['phone'];
      $g11_acc_type = $_POST['acc_type'];
      $g11_birthday = $_POST['birthday'];
      $g11_person_id = $_POST['person_id'];
      $g11_gender = $_POST['gender'];
      $g11_address = $_POST['address'];
      $g11_district = $_POST['district'];
      $g11_city = $_POST['city'];
      $g11_country = $_POST['country'];
      $g11_nationality = $_POST['nationality'];
      $g11_account_no = rand(999999999,10000000000);
      while (1) {
        $g11_result = mysqli_query($g11_connection, "SELECT account_no FROM login WHERE account_no='$g11_account_no'");
        $g11_count = mysqli_num_rows($g11_result);
        if($g11_count==0)
        {
          break;
        }
        $g11_account_no = rand(999999999,10000000000);
      }
      $g11_date = date("d/m/Y");
      if (mysqli_num_rows(mysqli_query($g11_connection, "SELECT * FROM register WHERE email='{$g11_email}'")) > 0) {
        echo "<script> alert('{$g11_email} - This email address has been already exists.')</script>";
        header("refresh:0;url=register.php");
      } else {
      	/*
      	$g11_stmt = mysqli_prepare($g11_connection, "insert into login(id, pwd, account_no) values (?, ?, ?); insert into register(account_no, firstname, lastname, email, status, token, phone, acc_type, birthday, person_id, gender, address, district, city, country, nationality) values (?, ?,  ?,  ?, '0', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); insert into balance(account_no, balance) values (?, '10000');");
      	mysqli_stmt_bind_param($g11_stmt, "sssssssssssssssssss", $g11_email, $g11_password, $g11_account_no, $g11_account_no, $g11_fname, $g11_lname, $g11_email, $g11_token, $g11_phone, $g11_acc_type, $g11_birthday, $g11_person_id, $g11_gender, $g11_address, $g11_district, $g11_city, $g11_country, $g11_nationality, $g11_account_no);
      	$g11_s = mysqli_stmt_execute($g11_stmt);
      	*/
        $g11_s = mysqli_multi_query($g11_connection, "insert into login(id, pwd, account_no) values ('$g11_email',  '$g11_password', '$g11_account_no'); insert into register(account_no, firstname, lastname, email, status, token, phone, acc_type, birthday, person_id, gender, address, district, city, country, nationality) values ('$g11_account_no', '$g11_fname',  '$g11_lname',  '$g11_email', '0', '$g11_token', '$g11_phone',  '$g11_acc_type',  '$g11_birthday',  '$g11_person_id',  '$g11_gender',  '$g11_address',  '$g11_district',  '$g11_city',  '$g11_country',  '$g11_nationality'); insert into balance(account_no, balance) values ('$g11_account_no', '10000');");
        //$g11_c = mysqli_multi_query($g11_con, "create table `$g11_account_no`(`date` VARCHAR(20) NOT NULL ,`remark` VARCHAR(200) NOT NULL ,`debit` INT(6) NOT NULL ,`credit` INT(6) NOT NULL ,`balance` INT(8) NOT NULL); INSERT INTO `$g11_account_no` (date, remark, debit, credit, balance) VALUES('$g11_date', 'New Account', null, '1000', '1000');");
        
        $first_remark = "SD TK " . $g11_account_no . " +10000VND";
        
        $g11_c = mysqli_multi_query($g11_con, "create table `$g11_account_no`(`date` VARCHAR(20) NOT NULL ,`remark` VARCHAR(100) NOT NULL ,`message` VARCHAR(100) NOT NULL,`amount` VARCHAR(13) NOT NULL,`balance` INT(12) NOT NULL, `interactor` VARCHAR(20) NOT NULL); INSERT INTO `$g11_account_no` (date, remark, message, amount,  balance, interactor) VALUES('$g11_date', '$first_remark', 'Qua nap lan dau', '+10000',  10000, 'Admin')");
        
        if($g11_s && $g11_c) {
          /*$_SESSION['account_no'] = $g11_account_no;
          header("refresh:0;url=../login/login.php");*/
          echo "<div style='display: none;'>";          
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
              $mail->Subject = 'NO REPLY';
              $mail->Body    = 'Here is the verification link <b><a href="http://localhost/login/login.php/?verification='.$g11_token.'">http://localhost/login/login.php/?verification='.$g11_token.'</a></b>';

              $mail->send();
              echo 'Message has been sent';
          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }
          echo "</div>";
          echo "<script>alert('We have send a verification link on your email address.')</script)";
          header("refresh:0;url=../login/login.php");
          unset($_SESSION['firstname']);
          unset($_SESSION['lastname']);
          unset($_SESSION['email']);
          unset($_SESSION['password']);
        }
        else {
          echo"<script> alert('Something wrong went.')</script>";
        }
      }
    }
  }
  else{
    $message = "You do not have access to this page.";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("refresh:0;url=register.php");
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
    var filter_phone = /^[0-9]{10}$/;
    var filter_bday = /^(?:0[1-9]|[12]\d|3[01])([\/.-])(?:0[1-9]|1[012])\1(?:19|20)\d\d$/;
    var filter_pid = /^[0-9]{9}$|^[0-9]{12}$/;
    var filter_var = /^[A-Za-z\s]+$/;
    var filter_addr = /^[[A-Za-z\d\s,./]+$/;

    function myFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") {
        x.className += " responsive";
      } else {
        x.className = "topnav";
      }
    }

    function checkAll() {
      if (checkPhone() && checkPid() && checkAddr() && checkDistrict() && checkCity() && checkCountry() && checkNationality()) {
        alert("Congratulations, you have successfully registered an account!");
        return true;
      } else {
        alert("Please enter all information correctly!");
        return false;
      }
    }

    function checkPhone() {
      var phone = document.getElementById("phone").value;
      var get_phoneNumber = document.getElementById("phone")
      if (!filter_phone.test(phone)) {
        get_phoneNumber.setCustomValidity("Invalid mobile phone!");
        get_phoneNumber.reportValidity();
        return false;
      } else {
        get_phoneNumber.setCustomValidity("");
        return true;

      }
    }

    function checkPid() {
      var pid = document.getElementById("person_id").value;
      var get_pid = document.getElementById("person_id")
      if (!filter_pid.test(pid)) {
        get_pid.setCustomValidity("Invalid personal ID!");
        get_pid.reportValidity();
        return false;
      } else {
        get_pid.setCustomValidity("");
        return true;

      }
    }

    function checkAddr() {
      var addr = document.getElementById("address").value;
      var get_addr = document.getElementById("address")
      if (!filter_addr.test(addr)) {
        get_addr.setCustomValidity("Invalid address!");
        get_addr.reportValidity();
        return false;
      } else {
        get_addr.setCustomValidity("");
        return true;

      }
    }

    function checkDistrict() {
      var district = document.getElementById("district").value;
      var get_district = document.getElementById("district")
      if (!filter_var.test(district)) {
        get_district.setCustomValidity("Invalid input!");
        get_district.reportValidity();
        return false;
      } else {
        get_district.setCustomValidity("");
        return true;

      }
    }

    function checkCity() {
      var city = document.getElementById("city").value;
      var get_city = document.getElementById("city")
      if (!filter_var.test(city)) {
        get_city.setCustomValidity("Invalid input!");
        get_city.reportValidity();
        return false;
      } else {
        get_city.setCustomValidity("");
        return true;
      }
    }

    function checkCountry() {
      var country = document.getElementById("country").value;
      get_country = document.getElementById("country")
      if (!filter_var.test(country)) {
        get_country.setCustomValidity("Invalid input!");
        get_country.reportValidity();
        return false;
      } else {
        get_country.setCustomValidity("");
        return true;
      }
    }

    function checkNationality() {
      var nationality = document.getElementById("nationality").value;
      var get_nationality = document.getElementById("nationality")
      if (!filter_var.test(nationality)) {
        get_nationality.setCustomValidity("Invalid input!");
        get_nationality.reportValidity();
        return false;
      } else {
        get_nationality.setCustomValidity("");
        return true;

      }
    }
  </script>
</head>

<body>
  <div id="header">
    <div class="header-content">
      <a href="../index.php" class="page-logo"><img src="../asset/img/banner_0.png" height="60"></a>
      <div class="direct-container">
        <a href="../login/login.php" class="direct-link"><i class="fa fa-fw fa-sign-in "></i>LOGIN</a>
      </div>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>


  <div class="register2 user-profile form-body">
    <div class="register2 user-profile form-content">
      <div class="register2 user-profile form-title">
        <img src="../asset/img/logo-uit.png" alt="" width="30" height="30">
        <h2>UIT Bank</h2>
      </div>

      <form class="register2 user-profile form-section" method="post" onsubmit="return checkAll()">
        <fieldset>
          <legend>Register</legend>
          <div class="register2 user-profile inner-form first-block">
            <div class="register2 user-profile block-item">
              <select class="question" id="acc_type" name="acc_type" required autocomplete="off">
                <option selected disabled>Your Account Type</option>
                <option value="saving">Saving Account</option>
                <option value="current">Currrent Account</option>
              </select>
              <label for="acc_type"></label>
            </div>
          </div>


          <div class="register2 user-profile personal-in4 inner-form second-block">
            <div class="register2 user-profile first inner-block">
              <div class="register2 user-profile block-item block-column">
                <input type="text" name="person_id" oninput="checkPid()" class="question" id="person_id" required autocomplete="off" />
                <label for="person_id"><span>Personal ID</span></label>
              </div>

              <div class="register2 user-profile block-item block-column">
                <input type="text" name="phone" oninput="checkPhone()" class="question" id="phone" required autocomplete="off" />
                <label for="phone"><span>Mobile Number*</span></label>
              </div>
            </div>

            <div class="register2 user-profile second inner-block">
              <div class="register2 user-profile block-item block-column">
                <input type="date" name="birthday" class="question" id="birthday" min="1920-01-01" max="2004-12-31" required autocomplete="off" />
                <label for="birthday"><span>Date of birth*</span></label>
              </div>

              <div class="register2 user-profile block-item block-column">
                <select name="gender" id="gender" class="gender  question" required autocomplete="off">
                  <option value="" selected disabled>Choose your gender</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>
                  <option value="3">Others</option>
                </select>
                <label class="gender-label" for="gender"><span>Gender</span></label>
              </div>
            </div>
          </div>

          <div class="register2 user-profile inner-form">
            <div class="register2 user-profile block-item">
              <input type="text" name="address" oninput="checkAddr()" class="question" id="address" required autocomplete="off" />
              <label for="address"><span>Address*</span></label>
            </div>

            <div class="register2 user-profile inner-block">
              <div class="register2 user-profile block-item block-column">
                <input type="text" name="district" oninput="checkDistrict()" class="question" id="district" required autocomplete="off" />
                <label for="district"><span>District*</span></label>
              </div>

              <div class="register2 user-profile block-item block-column">
                <input type="text" name="city" oninput="checkCity()" class="question" id="city" required autocomplete="off" />
                <label for="city"><span>City*</span></label>
              </div>
            </div>

            <div class="register2 user-profile inner-block">
              <div class="register2 user-profile block-item block-column">
                <input type="text" name="country" oninput="checkCountry()" class="question" id="country" required autocomplete="off" />
                <label for="country"><span>Country*</span></label>
              </div>
              <div class="register2 user-profile block-item block-column">
                <input type="text" name="nationality" oninput="checkNationality()" class="question" id="nationality" required autocomplete="off" />
                <label for="nationality"><span>Nationality*</span></label>
              </div>
            </div>
          </div>

          <input class="register2 user-profile form-submit" type="submit" name="submit" value="REGISTER">

        </fieldset>
      </form>
    </div>
  </div>
</body>

</html>
