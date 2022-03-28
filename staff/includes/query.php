<?php
session_start();
error_reporting(0);
include_once("includes/config.php");
if($_SESSION['userlogin']>0){
	header('location:index.php');
}elseif(isset($_POST['login'])){
	$_SESSION['userlogin'] = $_POST['username'];
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);

	
$userquery = mysqli_query ($conn,"SELECT UserName,Password from employees WHERE UserName = '$username'") or die ('cannot select employee');
$user_count=mysqli_num_rows($userquery);
if ($user_count>0){
	//// do nothing
	$userdata=mysqli_fetch_array($userquery);

	$user_id=$userdata['user_id'];
	$surname=$userdata['surname'];
	$othernames=$userdata['othernames'];
	$fullname=ucwords(("$surname $othernames"));
	$phone_number=$userdata['phone_number'];
	$email_address=$userdata['email_address'];
	$role_id=$userdata['role_id'];
	$password=$userdata['password'];
	
}else{
	?>
	<script>
	window.parent(location="../index.php");
	</script>


	$sql = "SELECT UserName,Password from employees where UserName=:username";
	$query = $dbh->prepare($sql);
	$query->bindParam(':username',$username,PDO::PARAM_STR);
	$query-> execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0){
		foreach ($results as $row) {
			$hashpass=$row->Password;
		}//verifying Password
		if (password_verify($password, $hashpass)) {
			$_SESSION['userlogin']=$_POST['username'];
			echo "<script>window.location.href= 'index.php'; </script>";
		}
		else {
			$wrongpassword='
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Oh Snapp!😕</strong> Alert <b class="alert-link">Password: </b>You entered wrong password.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>';
		}
	}
	//if username or email not found in database
	else{
		$wrongusername='
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Oh Snapp!🙃</strong> Alert <b class="alert-link">UserName: </b> You entered a wrong UserName.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>';
	}
}
?>
