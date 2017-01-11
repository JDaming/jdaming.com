<?php require('includes/config.php');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf8">
	<title>Blog</title>
</head>
<body>
	
	<div>
		<h1>Blog</h1>
		<hr />
		<?php
		    try {
                
                	$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate from blog_posts order by postID desc');
                	while ($row = $stmt->fetch()){
                            echo '<div>';
                            echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
                            echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                            echo '<p>'.$row[postDesc].'</p>';
                            echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';
                            echo '</div>';
               		 }
       	 	    } catch(PDOException $e) {
                	echo $e->getMessage();
       		    }
		?>
	</div>
	
</body>
</html>


