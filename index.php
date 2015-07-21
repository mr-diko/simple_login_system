<?php include_once 'resourse/session.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Homepage</title>
</head>
<body>

<h2>User Authentication System </h2>
<hr>
<?php if(!isset($_SESSION['username'])): ?>
<p>You are currently not signin <a href="login.php">login</a> Not yet a member? <a href="signup.php">Signup</a></p>
<?php else : ?>
<p>You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username'] ."." ?> <a href="logout.php">Logout</a></p>
<?php endif ?>
</body>
</html>