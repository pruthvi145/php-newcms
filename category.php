<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>

<?php if(isset($_GET['cat_id'])): ?>
<?php 

	$cat_id = $_GET['cat_id'];
	$row = fetch_category($cat_id);
	$cat_title = $row['cat_title'];

?>

<!-- Page Content -->
<div class="container">

	<div class="row">
		
		<!-- Blog Entries Column -->
		<div class="col-md-8">
			<h1 class="page-header">Category <small>- <?php echo $cat_title; ?></small></h1>
			<?php $rows = fetch_category_posts($cat_id); ?>			
			<?php foreach($rows as $row): ?>
			<?php 
						
				$post_id = $row['post_id'];
				$post_cat_id = $row['post_cat_id'];
				$post_author = $row['post_author'];
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
					by <a href="index.php"><?php echo $post_author ?></a>
				</p>
				<p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
				<hr>
				<img height="300"  src="imgs/<?php echo $post_image ?>" alt="">
				<hr>
				<p style="overflow: hidden; height:40px"><?php echo $post_content ?></p>
				
				<a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

				<hr>
			<?php endforeach; ?>
			<?php if(!$rows): ?>
				<h2>No Post Found!</h2>
			<?php endif; ?>
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