<?php
    //include config
    require_once('../includes/config.php');

    //if not logged in redirect to login page
    if(!$user->is_logged_in()){header('Location:login.php');} 
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
		
		if(isset($_POST['submit'])){
		
		    extract($_POST);

		    if($username ==''){
			$error[] = 'Please enter the username.';
		    }

		    if($password ==''){
			$error[] = 'Please enter the password';
		    }
			
		    if($passwordConfirm ==''){
			$error[] = 'Please enter the passwrodConfirm';
		    }
			
		    if($password != $passwordConfirm){
			$error[] = 'Passwords not match';
		    }
		
		    if($email == '' ){
			$error[] = 'Please enter the email';
		    }
			
		    //if no error 
		    if(!isset($error)){
			$username = trim($username);	
			$hashedpassword = password_hash($password,PASSWORD_DEFAULT);
			
			try{
			    
			    $stmt = $db->prepare('insert into blog_members(username,password,email) values (:username,:password,:email)');
			    $stmt->execute(array(
				':username'=>$username,
				':password'=>$hashedpassword,
				':email'=>$email));
			    
			     header('Location:users.php?action=added');
			     exit;
			} catch(PDOException $e){
			    echo $e->getMessage();
			}
			
		    }

		} 
		//if error
                if(isset($error)){
                    foreach($error as $error){
                        echo '<p class="error">'.$error.'</p>';
                    }
                }
	    ?>

	    <form action='' method='post'>
		<p><label>Username</label><br />
		<input type='text' name='username' value='<?php if(isset($error)){echo $_POST['username'];}else{echo '';} ?> '/></p>
		
		<p><label>Password</label><br />
		<input type='password' name='password' value='<?php if(isset($error)){echo $_POST['password'];}else{echo '';} ?>' /></p>

		<p><label>PasswordConfirm</label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){echo $_POST['passwordConfirm'];}else{echo '';}?>' /></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php if(isset($error)){echo $_POST['email'];}else {echo '';}?>' /></p>
		
		<p><input type='submit' name='submit' value='Add User'/></p>

	    </form>

	</div>
</body>
</html>
