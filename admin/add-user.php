<?php
    //include config
    require_once('../includes/config.php');

    //if not logged in redirect to login page
    if($user->is_logged_in()){header('Location:login.php');} 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Admin - Add User</title>
</head>
<body>
	<div>
	    <?php include('menu.php');?>
	    <p><a href='users.php'>User Admin Index</a></p>

	    <h2>Add User</h2>
	    <?php
		
		 
	    ?>
	</div>
</body>
</html>
