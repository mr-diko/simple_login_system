<?php 
include_once "resourse/Database.php";
include_once "resourse/utilitis.php";

if ( isset($_POST['signupBtn']) ) {
	// Initialize an array to store any error message from the form
	$form_errors = array();

	// Form validation
	$required_fields = array('email', 'username', 'password');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));

	$fields_to_check_length = array('username' => 4, 'password' => 6);
	$form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

	$form_errors = array_merge($form_errors, check_email($_POST));

	if( empty($form_errors) ) {
		$email = $_POST['email'];
		$password = password_hash( $_POST['password'], PASSWORD_DEFAULT );
		$username = $_POST['username'];

		try{
			$sqlInsert = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
			$statement = $db->prepare($sqlInsert);
			$statement->execute( array(':username' => $username, ':password' => $password, ':email' => $email) );

			if ($statement->rowCount() == 1) {
				$result = "<p style='padding: 20px; color: green;' >Registration successful</p>";
			}
		}catch(PDOException $ex){
			$result = "<p style='padding: 20px; color:red;' >Registration failed: {$ex->getMessage()}</p>";
		}
	}else{
		if(count($form_errors) == 1) {
			$result = "<p style='color: red;'>There was 1 error in the form <br>";
		}else{
			$result = "<p style='color: red;'> There was " . count($form_errors) . " errors in the form <br>";
		}
	}

	
}
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register page</title>
</head>
<body>

<h2>User Authentication System </h2>
<h3>Registration form</h3>
<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form method="post" action="">
	<table>
		<tr>
			<td>Email:</td>
			<td><input type="text" value="" name="email"></td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" value="" name="username"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" value="" name="password"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Signup" name="signupBtn"></td>
		</tr>
	</table>
</form>
<p><a href="index.php">Back</a></p>

</body>
</html>