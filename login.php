<?php
include_once "resourse/session.php";
include_once "resourse/Database.php";
include_once "resourse/utilitis.php";

if(isset($_POST['loginBtn'])) {
	// array to hold errors
	$form_errors = array();

	// validate
	$required_fields = array('username', 'password');

	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));

	if (empty($form_errors)) {
		// collect form data
		$user = $_POST['username'];
		$password = $_POST['password'];
		// check if user exist in the database
		$sqlQuery = "SELECT * FROM users WHERE username = :username";
		$statement = $db->prepare($sqlQuery);
		$statement->execute(array(':username' => $user));

		while ($row = $statement->fetch()) {
			$id = $row['id'];
			$hashed_password = $row['password'];
			$username = $row['username'];
		}
			if(password_verify($password, $hashed_password="")) {
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $username;
				header('Location: index.php');
			}else{
				// header('Location: index.php');
				$result = "<p style='color: red; border: 1px solid #808080; padding: 10px;'>Invalid username or password</p>";
			}
	}else{
		if(count($form_errors) == 1) {
			$result = "<p style='color: red;'>There was one error in the form</p>";
		}else{
			$result = "<p style='color: red;'>There was ".count($form_errors)." errors in the form</p>";
		}
	}	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login page</title>
</head>
<body>

<h2>User Authentication System </h2>
<h3>Login form</h3>
<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form method="post" action="">
	<table>
		<tr><td>Username:</td><td><input type="text" name="username" value=""></td></tr>
		<tr><td>Password:</td><td><input type="password" name="password" value=""></td></tr>
		<tr><td></td><td><input type="submit" value="Signin" name="loginBtn"></td></tr>
	</table>
</form>
<p><a href="index.php">Back</a></p>

</body>
</html>