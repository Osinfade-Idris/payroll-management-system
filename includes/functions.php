<?php
	//calling the config file
	include_once("includes/config.php"); 
	// adding new users code begins here
	if(isset($_POST['add_user'])){
		$fname = htmlspecialchars($_POST['firstname']);
		$lname = htmlspecialchars($_POST['lastname']);
		$username = htmlspecialchars($_POST['username']);
		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);
		$confirm_password = htmlspecialchars($_POST['confirm_pass']);
		$phone = htmlspecialchars($_POST['phone']);
		$address = htmlspecialchars($_POST['address']);
		//grabing user profile picture
		$file = $_FILES['image']['name'];
		$file_loc = $_FILES['image']['tmp_name'];
		$folder="profiles/"; 
		$new_file_name = strtolower($file);
		$final_file=str_replace(' ','-',$new_file_name);
		if($password != $confirm_password){
			echo "<script>alert('Your passwords do not match');</script>";
		}
		else{
			//moving the picture into new location and set file name to be $image.
			if(move_uploaded_file($file_loc,$folder.$final_file))
			{
				$image=$final_file;
			}
			$password = password_hash($password,PASSWORD_DEFAULT);
			$sql = "INSERT INTO users(FirstName,LastName,UserName,Email,Password,Phone,Address,Picture)
			values(:fname,:lname,:username,:email,:password,:phone,:address,:pic)";
			$query = $dbh->prepare($sql);
			$query->bindParam(':fname',$fname,PDO::PARAM_STR);
			$query->bindParam(':lname',$lname,PDO::PARAM_STR);
			$query->bindParam(':username',$username,PDO::PARAM_STR);
			$query->bindParam(':email',$email,PDO::PARAM_STR);
			$query->bindParam(':password',$password,PDO::PARAM_STR);
			$query->bindParam(':phone',$phone,PDO::PARAM_STR);
			$query->bindParam(':address',$address,PDO::PARAM_STR);
			$query->bindParam(':pic',$image,PDO::PARAM_STR);
			$query->execute();
			$lastInsert = $dbh->lastInsertId();
			if($lastInsert>0){
				move_uploaded_file($file_loc,$folder.$final_file);
				echo "<script>alert('New User Has Been Added');</script>";
				echo "<script>window.location.href='users.php';</script>";
			}else{
				echo "<script>alert('Something went wrong.');</script>";
			}


		}
	}
	//adding  users ends here 

	
	//adding of goal types stats here
	elseif(isset($_POST['add_goal_type'])){
		$type = htmlspecialchars($_POST['type']);
		$description = htmlspecialchars($_POST['description']);
		$status = htmlspecialchars($_POST['status']);
		$sql = "INSERT INTO `goal_type` ( `Type`, `Description`, `Status`) 
		VALUES (:type, :description, :status)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':type',$type,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);
		$query->execute();
		$lastinserted = $dbh->lastInsertId();
		if($lastinserted>0){
			echo "<script>alert('Goal Type Has Been Added');</script>";
			echo "<script>window.location.href='goal-type.php';</script>";
		}else{
			echo "<script>alert('Something Went Wrong.Re-check goal type may already exist');</script>";
		}
	}//goal type adding code ends here.


	//adding employees code starts from here
	elseif(isset($_POST['add_employee'])){
		$firstname = htmlspecialchars($_POST['firstname']);
		$lastname = htmlspecialchars($_POST['lastname']);
		$username = htmlspecialchars($_POST['username']);
		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);
		$confirm_password = htmlspecialchars($_POST['confirm_pass']);
		$employee_id = htmlspecialchars($_POST['employee_id']);
		$phone = htmlspecialchars($_POST['phone']);
		$department = htmlspecialchars($_POST['department']);
		$designation = htmlspecialchars($_POST['designation']);
		$salary = htmlspecialchars($_POST['salary']);
		//grabbing the picture
		$file = $_FILES['picture']['name'];
		$file_loc = $_FILES['picture']['tmp_name'];
		$folder="employees/"; 
		$new_file_name = strtolower($file);
		$final_file=str_replace(' ','-',$new_file_name);

		if(move_uploaded_file($file_loc,$folder.$final_file) && ($password == $confirm_password)){
			$image=$final_file;
			$password = password_hash($password,PASSWORD_DEFAULT);
		 }
		$sql = "INSERT INTO `employees` (`id`, `FirstName`, `LastName`, `UserName`, `Email`, `Password`, `Employee_Id`, `Phone`, `Department`, `Designation`, `Salary`, `Picture`, `DateTime`) 
		VALUES (NULL, :firstname, :lastname, :username, :email,:password, :id, :phone, :department, :designation, :salary, :pic, current_timestamp())";
			$query = $dbh->prepare($sql);
		$query->bindParam(':firstname',$firstname,PDO::PARAM_STR);
		$query->bindParam(':lastname',$lastname,PDO::PARAM_STR);
		$query->bindParam(':username',$username,PDO::PARAM_STR);
		$query->bindParam(':email',$email,PDO::PARAM_STR);
		$query->bindParam(':password',$password,PDO::PARAM_STR);
		$query->bindParam(':id',$employee_id,PDO::PARAM_STR);
		$query->bindParam(':phone',$phone,PDO::PARAM_STR);
		$query->bindParam(':department',$department,PDO::PARAM_STR);
		$query->bindParam(':designation',$designation,PDO::PARAM_STR);
		$query->bindParam(':salary',$salary,PDO::PARAM_STR);
		$query->bindParam(':pic',$image,PDO::PARAM_STR);
		$query->execute();
		$lastInsert = $dbh->lastInsertId();
		if($lastInsert>0){
			echo "<script>alert('Employee Has Been Added.');</script>";
			echo "<script>window.location.href='employees.php';</script>";
		}else{
			echo "<script>alert('Something Went Wrong');</script>";
		}	
		
	}//ading employees code eds here



?>
