<?php
// session_start();
// $g11_account_nom = $_SESSION['account_no'];
if(isset($_POST['account_num']))
{
$g11_account_num = $_POST['account_num'];
$g11_con = mysqli_connect("localhost","nhom11","Thanh@19522235","bank");

// prepare statement
$g11_stmt = mysqli_prepare($g11_con, "SELECT * FROM register WHERE account_no = ?");
mysqli_stmt_bind_param($g11_stmt, "s", $g11_account_num);
mysqli_stmt_execute($g11_stmt);
$g11_result = mysqli_stmt_get_result($g11_stmt);
$g11_count = mysqli_num_rows($g11_result);
if($g11_count == 1)
{
	$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
	$g11_firstname = $g11_row['firstname'];
	$g11_lastname = $g11_row['lastname'];
	echo "$g11_firstname"." "."$g11_lastname";
}
else
{
	echo "Account does not exist!";
}
}
else
{
	echo "no";
}
?>
