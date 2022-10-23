<?php
session_start();
if(isset($_SESSION['account_no'])){
	$g11_account_no = $_SESSION['account_no'];
	$g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");
	$g11_result = mysqli_query($g11_con, "SELECT * FROM register WHERE account_no = '$g11_account_no'");
	$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
	$g11_firstname = $g11_row['firstname'];
	$g11_lastname = $g11_row['lastname'];
	$g11_email = $g11_row['email'];
	$g11_phone = $g11_row['phone'];
	$g11_gender = $g11_row['gender'];
	$g11_district = $g11_row['district'];
	$g11_birthday = $g11_row['birthday'];
	$g11_person_id = $g11_row['person_id'];
	$g11_gender = $g11_row['gender'];
	$g11_address = $g11_row['address'];
	$g11_city = $g11_row['city'];
	$g11_country = $g11_row['country'];
	$g11_nationality = $g11_row['nationality'];
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
    <div class="profile user-profile form-body">
        <div class="form-content profile user-profile">
            <div class="profile user-profile form-title">
                <img src="../asset/img/logo-uit.png" alt="" width="30" height="30">
                <h2>UIT Bank</h2>
            </div>

            <div class="profile user-profile profile-content">
                <div class="profile user-profile profile-column basical-profile">
                    <div class="avatar personal-profile">
                        <img src="../asset/img/logo-uit.png" alt="">
                    </div>
                    <div class="personal-profile">
                        <h2><?php echo $g11_firstname . " " . $g11_lastname ?></h2>
                        <p><?php echo $g11_email ?></p>
                    </div>
                </div>

                <div class="profile user-profile profile-column detail-profile">
                    <div class="profile profile-container  personal-in4">
                        <div class="profile user-profile inner-form">
                            <div class="profile user-profile profile-display">
                                <!-- <p> Account Number: 12345678 </p> -->
                                <p>Account Number: <?php echo $g11_account_no ?> </p>
                            </div>
                            <div class="profile user-profile profile-display">

                                <!-- <p>Phone number: 0123456789</p> -->
                                <p>Phone number: <?php echo $g11_phone ?></p>
                            </div>
                            <div class="profile user-profile profile-display">
                                <!-- <p>Personal ID: 1234589</p> -->
                                <p>Personal ID: <?php echo $g11_person_id ?></p>
                            </div>
                            <div class="profile user-profile profile-display">
                                <!-- <p>Date of birth: 01/01/1999</p> -->
                                <p>Date of birth: <?php echo $g11_birthday ?></p>
                            </div>
                            <div class="profile user-profile profile-display">
                                <!-- <p>Gender: Male</p> -->
                                <p>Gender: <?php echo $g11_gender ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="profile profile-container address-in4">
                        <div class="profile user-profile inner-form">
                            <div class="profile user-profile profile-display">
                                <!-- <p>Address: 09 xxxxxxx, Dĩ An, Bình Dương </p> -->
                                <p>Address: <?php echo $g11_address ?></p>
                            </div>
                            <div class="profile user-profile profile-display">
                                <!-- <p>District: Lorem ipsum</p> -->
                                <p>District: <?php echo $g11_district ?></p>
                            </div>
                            <div class="profile user-profile profile-display">
                                <!-- <p>City: Lorem, ipsum dolor.</p> -->
                                <p>City: <?php echo $g11_city ?></p>
                            </div>
                            <div class="profile user-profile profile-display">
                                <!-- <p>Country: Lorem, ipsum.</p> -->
                                <p>Country: <?php echo $g11_country ?></p>
                            </div>
                            <div class="profile user-profile profile-display">
                                <!-- <p>Nationality: Lorem, ipsum.</p> -->
                                <p>Nationality: <?php echo $g11_nationality ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="profile user-profile modify-btn">
                <!-- <a href="./editprofile.html"></a> -->
                <input type="button" name="changepwd" value="CHANGE PASSWORD" onclick="window.location.href='./password/password.php'">
                <input type="button" name="editprofile" value="EDIT PROFILE" onclick="window.location.href='./editprofile.php'">
            </div>
        </div>
    </div>

</body>

</html>
