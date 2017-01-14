<?php
    //include config
    require_once('../includes/config.php');

    //if not logged in redirect to login page
    if(!$user->is_logged_in()){header('Location:login.php');} 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf8'>
	<title>Admin - Edit Post</title>
</head>
<body>
	<div>
	<?php include ('menu.php');?>
	<?php
	    try {
		$stmt = $db->prepare('select postID, postTitle, postDesc, postCont from blog_posts where postID = :postID');
		$stmt->execute(array(':postID'=>$_GET['id']));
		$row = $stmt->fetch();
	    } catch(PDOException $e){
		echo $e->getMessage();
	    }
	
	    if(isset($_POST['submit'])){
		
		$_POST = array_map('stripslashes',$_POST);
		
		//collect form data
		extract($_POST);
		
		//very basic validation
		if ($postID == ''){
		    $error[] = 'This post is missing a valid id!.';
		}
		if ($postTitle == ''){
		    $error[] = 'Please enter the title';
		}
		if ($postDesc == ''){
		    $error[] = 'Please enter the description';
		}
		if ($postCont == ''){
		    $error[] = 'Pleassse  enter the content';
		}
		
		//if no error
		if (!isset($error)){
		    try {
			$stmt = $db->prepare('update blog_posts set postTitle=:postTitle,postDesc=:postDesc,postCont=:postCont where postID=:postID');
			$stmt->execute(array(
				':postTitle'=>$postTitle,
				':postDesc'=>$postDesc,
				':postCont'=>$postCont,
				':postID'=>$postID));
			header('Location:index.php?action=updated');
			exit;
		    } catch(PDOException $e){
			echo $e->getMessage();
		    }
		}
		
		//if error
		if (isset($error)){
		    foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		    }
		}
	    }
	?>
	
	<form action='' method='post'>
		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>' >
		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php echo $row['postTitle']; ?>' /></p>
		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php echo $row['postDesc'];?></textarea></p>
		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php echo $row['postCont'];?></textarea></p>
		
		<p><input type='submit' name='submit' value='Update'</p>

	</form>	

	</div>
</body>
</html>
