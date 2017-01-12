<?php

    //include config
    require_once('../includes/config.php');

    //if not logged in redirect to login page
    if ($user->is_logged_in()){header('Location:login.php');}

    //show message from add/edit page
    if (isset($_GET['deluser'])){
	if ($_GET['deluser'] != '1'){
	    
	    $stmt = $db->prepare('delete from blog_members where memberID = :memberID');
	    $stmt->execute(array(':memberID'=>$_GET['deluser']));

            header('Location:users.php?action=deleted');
	    exit;
	}
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf8'>
	<title>Admin - Users</title>
	
</head>
<body>
	<div>
	<?php include ('menu.php');?>
	<?php
	    if (isset($_GET['action'])){
		echo '<h3>User '.$_GET['action'].'.</h3>';
	    } 
	?>
	<table>
	<tr>
	    <th>Username</th>
	    <th>Email</th>
	    <th>Action</th>
	</tr>
	<?php
	try{
	    $stmt = $db->query('select memberID,username,email from blog_members order by username');
	    while($row = $stmt->fetch()){
		
		echo '<tr>';
		echo '<td>'.$row['username'].'</td>';
		echo '<td>'.$row['email'].'</td>';
		?>
		
		<td>
		    <a href="edit-user.php?id=<?php echo $row['memberID'];?>">Edit</a>
		    <?php if($row["memberID"] != 1){?>
			|<a href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo $row['username'];?>')">Delete</a>
		    <?php } ?>
		</td>
	    <?php 
		echo '</tr>';
	    }
	} catch(PDOException $e){
		echo $e->getMessage();
	}
	?>
	</div>
	<script language="JavaScript" type="text/javascript">
		function deluser(id, name)
		{
		    if (confirm("Are you sure you want to delete '" + title + "'")){
			window.location.href = 'user.php?deluser='+id;
		    }
		}
	</script>
</body>
</html>
