<?php
	$stmt = $db->prepare('select postID,postTitle,postCont,postDate from blog_posts where postID = :postID');
	$stmt->execute(array('posttID'=>$_GET['id']));
	$row = $stmt->fetch();

	if ($row['postID'] == ''){
		header('Location:./');
		exit;
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf8'>
	<title>Blog -- <?php echo $row['postTitle'];?></title>
</head>
<body>
	<div>
		<h1>Blog</h1>
		<hr />
		<p><a href="./">Blog Index</a></p>
		<?php
			echo '<div>';
            		echo '<h1>'.$row['postTitle'].'</h1>';
            		echo '<p>Posted on'.date("jS M Y",strtotime($row['postDate'])).'</p>';
            		echo '<p>'.$row['postCont'].'</p>';
        		echo '</div>';
		?>
	</div>
</body>
</html>
