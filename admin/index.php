<?php
	//include config
	require '../includes/config.php';

	//if not logged in redirect to login page
	if ($user->is_logged_in()){header('Location: login.php');}
	
	//show message from edit page
	if (isset($_GET['delpost'])){
		
		$stmt = $db->prepare('delete from blog_posts where postID == :postID');
		$stmt->execute(array(':postID'=>$_GET['delpost']));

		header('Location: index.php?action=deleted');
		exit;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf8'>
	<title>Admin</title>
</head>
<body>
	<div>
		
		<?php include('menu.php');?>
		
		<?php 
		//show message from add/edit page
		if (isset($_GET['action'])){echo '<h3>Post'.$_GET['action'].'.</h3>';}
		?>

	<table>
	<tr>
  	<th>Title</th>
   	<th>Date</th>
   	<th>Action</th>
	</tr>
<?php
        try {

            $stmt = $db->query('select postID,postTitle,postDate From blog_posts order by postID desc');
            while($row= $stmt->fetch()){

                echo '<tr>';
                echo '<td>'.$row['postTitle'].'</td>';
                echo '<td>'.date('jS M Y',strtotime($row['postDate'])).'</td>';
?>
                <td>
                    <a href="edit_post.php?id=<?php echo $row['postID'];?>">Edit</a> |
                    <a href="javascript:delpost('<?php echo $row['postID']; ?>'),'<?php echo $row['postTitle'];?>'">Delete</a>
                </td>
                
          <?php echo '</tr>';
		}
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
?>
	</table>


	<p><a href='add_post.php'>Add Post</a></p>

	</div>

	<script language="JavaScript" type="text/javascript">
        	function delpost(id,title)
        	{
            	if (confirm("Are you sure you want to delete '"+title +"'")){
                	window.location.href='index.php?delpost=' + id;
           	 	}
       	 	}
	</script>

</body>
</html>





