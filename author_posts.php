<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>

<?php if(isset($_GET['u_id'])): ?>
<?php 

	$u_id = $_GET['u_id'];
	$post_author_row = fetch_user($u_id);
	$post_author = $post_author_row['user_firstname']." ".$post_author_row['user_lastname'];

?>

<!-- Page Content -->
<div class="container">

	<div class="row">
		
		<!-- Blog Entries Column -->
		<div class="col-md-8">
			<h1 class="page-header">Author <small>- <?php echo $post_author; ?></small></h1>
			<?php $rows = fetch_author_posts($u_id); ?>	
			<?php if(empty($rows)): ?>
				<h3 class="alert alert-info" role="alert">No Post found!</h3>
			<?php endif; ?>		
			<?php foreach($rows as $row): ?>
			<?php 
						
				$post_id = $row['post_id'];
				$post_cat_id = $row['post_cat_id'];
				$post_author_id = $row['post_author_id'];
				$post_author_row = fetch_user($post_author_id);
				$post_author = $post_author_row['user_firstname']." ".$post_author_row['user_lastname'];
							$post_title = $row['post_title'];
						
				$post_image = $row['post_image'];
				$post_tags = $row['post_tags'];
				$post_comment_count = $row['post_comment_count'];
				$post_date = $row['post_date'];
				$post_content = $row['post_content'];
					
				?>
				<!-- First Blog Post -->
				<h2>
					<a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
				</h2>
				<p class="lead">
					by <a href="author_posts.php?u_id=<?php echo $post_author_id ?>"><?php echo $post_author ?></a>
				</p>
				<p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
				<hr>
				<a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive"  src="imgs/<?php echo $post_image ?>" alt=""></a>
				<hr>
				<p><?php echo substr($post_content, 0, 100) ?>...</p>
				<hr>
			<?php endforeach; ?>
		</div>

		<!-- Blog Sidebar Widgets Column -->
		<?php include "includes/sidebar.php" ?>

	</div>
	<!-- /.row -->

	<hr>

	<!-- Footer -->
<?php include "includes/footer.php" ?>
<?php else: ?>
<?php header('Location: index.php'); ?>
<?php endif; ?>