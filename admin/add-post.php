<?php
    //include config
    require_once ('../includes/config.php');

    //if not logged in redirect to login page
    if ($user->is_logged_in()){header('Location: index.php');}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf8'>
	<title>Blog - Add Post</title>
</head>
<body>
	<div>
	<?php include('menu.php'); ?>
	<?php
	
	//if form has been submitted process it
	if(isset($_POST['submit'])){
	    
	    $_POST = array_map('stripslashes',$_POST);
	    
	    //collect from data
	    extract($_POST);
	    
	    //very basic validation
	    if ($postTitle ==''){
		$error[] = 'Please enter the title';
	    } 
	   
	    if ($postDesc ==''){
		$error[] = 'Please enter the description';
	    }

	    if ($postCont ==''){
		$error[] = 'Please enter the content';
	    }
	}
	
	//if no error
	if (!isset($error)){
	    
	    try {
		
		//insert into database
		$stmt = $db->prepare('insert into blog_posts (postTitle,postDesc,postCont,postDate) values (:postTitle,:postDesc,:postCont,:postDate)');
		$stmt->execute(array(
			':postTitle'=>$postTitle,
			':postDesc'=>$postDesc,
			':postCont'=>$postCont,
			':postDate'=>date('Y-m-d H:i:s')));
		
		//redirect to index
		header('Location: index.php?action=added');
		exit;
	    } catch(PDOException $e) {
		echo $e->getMessage();
	    }
	}
	
	//if has error
	if(isset($error)){
	   foreach($error as $error){
		echo '<p class="error">'.$error.'</p>';
	   }

	}
	?>
	<form action='' method='post'>
	    <p><label>Title</label><br />
	    <input type='text' name='postTitle' value='<?php if(isset($error)){echo $_POST['postTitle'];} ?>' /></p>
	    
	    <p><label>Description</label><br />
	    <textarea  name='postDesc' cols='60' rows='10'><?php if(isset($error)){echo $_POST['postDESC'];} ?></textarea></p>

	    <p><label>Content</label><br />
	    <textarea  name='postCont' cols='60' rows='10'><?php if(isset($error)){echo $_POST['postCont'];}?></textarea></p>

	    <p><input type='submit' name='submit' value='submit' /></p>
	</form>
	</div>
</body>
</html>


