<?php include "db.php" ?>
<?php

	function getRootURI(){
		return "http://localhost/php-newcms";
	}

#Categories - CRUD - start

	function fetch_all_categories(){
		global $connection;
		$query = "SELECT * FROM categories";
		$res = mysqli_query($connection, $query);
		if(!$res){
				die("ERROR: can't fetch all categories! <br>".$query."<br>".mysqli_error($connection));
			}
		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		} 
		return $rows;
	}
	
	function total_categories(){
		global $connection;
		$query = "SELECT * FROM categories";
		$res = mysqli_query($connection, $query);
		
		return mysqli_num_rows($res);
	}

	function fetch_category($cat_id){
		global $connection;
		$query = "SELECT * FROM categories ";
		$query .= "WHERE cat_id = $cat_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't fetch category! <br>".$query."<br>".mysqli_error($connection));
		}
		
		return mysqli_fetch_assoc($res);
	}

	function add_category($cat_title){
		global $connection;
		$query = "INSERT INTO categories (cat_title) ";
		$query .= "VALUES ('$cat_title')";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't add category! <br>".$query."<br>".mysqli_error($connection));
		}else{
				header('Location: categories.php');
			}
	}

	function delete_category($cat_id){
		global $connection;
		$query = "DELETE FROM categories ";
		$query .= "WHERE cat_id = $cat_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't delete category! <br>".$query."<br>".mysqli_error($connection));
		}else{
				header('Location: categories.php');
			}
	}

	function edit_category($cat_id, $new_cat_title){
			global $connection;
			$query = "UPDATE categories SET ";
			$query .= "cat_title = '$new_cat_title'";
			$query .= "WHERE cat_id = $cat_id";
			$res = mysqli_query($connection,$query);

			if(!$res){
				die("ERROR: can't update category! <br>".$query."<br>".mysqli_error($connection));
			}else{
				header('Location: categories.php');
			}
	}

	function clone_category($cat_id){
		global $connection;
		
		$row = fetch_category($cat_id);
		$cat_title = $row['cat_title'];	
		add_category($cat_title);
	}


#Categories - CRUD - end


#Posts - CRUD - start

	function fetch_all_posts(){
		global $connection;
		$query = "SELECT * FROM posts";
		$res = mysqli_query($connection, $query);

		if(!$res){
				die("ERROR: can't fetch all Posts! <br>".$query."<br>".mysqli_error($connection));
		}
		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		} 
		return $rows;
	}

	function total_posts(){
		global $connection;
		$query = "SELECT * FROM posts";
		$res = mysqli_query($connection, $query);
		
		return mysqli_num_rows($res);
	}

	function fetch_post($post_id){
		global $connection;
		
		$query = "SELECT * FROM posts ";
		$query .= "WHERE post_id = $post_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't fetch post! <br>".$query."<br>".mysqli_error($connection));
		}
		
		return mysqli_fetch_assoc($res);
	}

	function add_post($post_fields){
		global $connection;
		
		$post_cat_id = $post_fields['post_cat_id'];		
		$post_title = $post_fields['post_title'];
		$post_author = $post_fields['post_author'];			
		$post_date = date('d-m-y');
		$post_image = $post_fields['post_image'];
		$post_content = $post_fields['post_content'];
		$post_tags = $post_fields['post_tags'];
		$post_comment_count = 0;
		$post_status = $post_fields['post_status'];
		
		$query = "INSERT INTO posts(post_cat_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
		$query .= "VALUES($post_cat_id, '$post_title', '$post_author', $post_date, '$post_image', '$post_content', '$post_tags', $post_comment_count, '$post_status')";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't add post! <br>".$query."<br>".mysqli_error($connection));
		}
	}

	function delete_post($post_id){
		global $connection;
		$query = "DELETE FROM posts ";
		$query .= "WHERE post_id = $post_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't delete post! <br>".$query."<br>".mysqli_error($connection));
		}else{
				delete_post_comments($post_id);
				header('Location: posts.php');
			}
	}

	function edit_post($post_id, $post_fields){
			global $connection;
		
			$post_cat_id = $post_fields['post_cat_id'];		
			$post_title = $post_fields['post_title'];
			$post_author = $post_fields['post_author'];			
			$post_date = date('dd-mm-yyyy');
			$post_image = $post_fields['post_image'];
			$post_content = $post_fields['post_content'];
			$post_tags = $post_fields['post_tags'];
			$post_status = $post_fields['post_status'];
		
			$query = "UPDATE posts SET ";
			$query .= "post_cat_id = $post_cat_id, ";
			$query .= "post_title = '$post_title', ";
			$query .= "post_author = '$post_author', ";
			$query .= "post_date = $post_date, ";
			$query .= "post_content = '$post_content', ";
			$query .= "post_image = '$post_image', ";
			$query .= "post_tags = '$post_tags', ";
			$query .= "post_status = '$post_status' ";

			$query .= "WHERE post_id = $post_id";
			$res = mysqli_query($connection,$query);

			if(!$res){
				die("ERROR: can't update category! <br>".$query."<br>".mysqli_error($connection));
			}
	}

	function edit_post_field($post_id, $post_field, $post_field_value){
		global $connection;
		
		$query = "UPDATE posts SET ";
		$query .= "$post_field = $post_field_value ";
		$query .= "WHERE post_id = $post_id";
			$res = mysqli_query($connection,$query);

			if(!$res){
				die("ERROR: can't update post field! <br>".$query."<br>".mysqli_error($connection));
			}
	}

	function clone_post($post_id){
		global $connection;
		
		$row = fetch_post($post_id);
		add_post($row);
		header('Location: posts.php');
	}

	function fetch_category_posts($cat_id){
		global $connection;
		$query = "SELECT * FROM posts ";
		$query .= "WHERE post_cat_id = $cat_id";
		$res = mysqli_query($connection, $query);

		if(!$res){
				die("ERROR: can't fetch category Posts! <br>".$query."<br>".mysqli_error($connection));
		}
		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		} 
		return $rows;
	}

function search_post($search){
	
	global $connection;
	$query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";	
	$query .= "OR post_title LIKE '%$search%' ";	
	$res = mysqli_query($connection, $query);
	
	if(!$res){
		die("Query failed".mysqli_error($connection));
	}
	
	$rows = array();
	while($row = mysqli_fetch_assoc($res)){
		$rows[] = $row;
	} 
	return $rows;			
}


#posts - CRUD - end


#comments - CRUD - start

	function fetch_all_comments(){
		global $connection;
		$query = "SELECT * FROM comments";
		$res = mysqli_query($connection, $query);

		if(!$res){
				die("ERROR: can't fetch all comments! <br>".$query."<br>".mysqli_error($connection));
		}
		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		} 
		return $rows;
	}

	function total_comments(){
		global $connection;
		$query = "SELECT * FROM comments";
		$res = mysqli_query($connection, $query);
		
		return mysqli_num_rows($res);
	}

	function fetch_comment($comment_id){
		global $connection;
		
		$query = "SELECT * FROM comments ";
		$query .= "WHERE comment_id = $comment_id";
		$res = mysqli_query($connection,$query);
		if(!$res){
			die("ERROR: can't fetch comment! <br>".$query."<br>".mysqli_error($connection));
		}
		return mysqli_fetch_assoc($res);
	}

	function add_comment($comment_fields){
		global $connection;
		
		$comment_post_id = $comment_fields['comment_post_id'];		
		$comment_author = $comment_fields['comment_author'];			
		$comment_email = $comment_fields['comment_email'];			
		$comment_content = $comment_fields['comment_content'];			
		$comment_status = $comment_fields['comment_status'];			
		$comment_date =  date('d-m-y');

		$post_comments_rows = fetch_post_all_comments($comment_post_id);
		$n = sizeof($post_comments_rows);
		
		$query = "INSERT INTO comments(comment_post_id,comment_author, comment_email, comment_content, comment_status, comment_date) ";
		$query .= "VALUES($comment_post_id,'$comment_author', '$comment_email', '$comment_content', '$comment_status', $comment_date)";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't add comment! <br>".$query."<br>".mysqli_error($connection));
		}else{
			edit_post_field($comment_post_id, 'post_comment_count', $n+1);	
		}
	}

	function delete_comment($comment_id){
		global $connection;
		
		$row = fetch_comment($comment_id);
		$comment_post_id = $row['comment_post_id'];
		$post_comments_rows = fetch_post_all_comments($comment_post_id);
		$n = sizeof($post_comments_rows);

		$query = "DELETE FROM comments ";
		$query .= "WHERE comment_id = $comment_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't delete comment! <br>".$query."<br>".mysqli_error($connection));
		}else{
			edit_post_field($comment_post_id, 'post_comment_count', $n-1);
			header('Location: comments.php');
		}
	}


	function approve_comment($comment_id, $status){
			global $connection;
				
			$comment_status = ($status =='approve') ? 'approved' : 'unapproved';			
		
			$query = "UPDATE comments SET ";
			$query .= "comment_status = '$comment_status' ";
			$query .= "WHERE comment_id = $comment_id";
		
			$res = mysqli_query($connection,$query);

			if(!$res){
				die("ERROR: can't update Comment! <br>".$query."<br>".mysqli_error($connection));
			}else{
				header('Location: comments.php');
			}
	}

	function fetch_post_approved_comments($post_id){
		global $connection;
		
		$query = "SELECT * FROM comments ";
		$query .= "WHERE comment_post_id = $post_id && comment_status = 'approved'";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't fetch post comments! <br>".$query."<br>".mysqli_error($connection));
		}
		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		} 
		return $rows;
	}
	function fetch_post_all_comments($post_id){
		global $connection;
		
		$query = "SELECT * FROM comments ";
		$query .= "WHERE comment_post_id = $post_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't fetch post comments! <br>".$query."<br>".mysqli_error($connection));
		}
		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		} 
		return $rows;
	}

function delete_post_comments($post_id){
		global $connection;
		
		$query = "DELETE FROM comments ";
		$query .= "WHERE comment_post_id = $post_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't fetch post comments! <br>".$query."<br>".mysqli_error($connection));
		}
	}

#Comments - CRUD - e


#users - CRUD - start

	function fetch_all_users(){
		global $connection;
		$query = "SELECT * FROM users";
		$res = mysqli_query($connection, $query);

		if(!$res){
				die("ERROR: can't fetch all users! <br>".$query."<br>".mysqli_error($connection));
		}
		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		} 
		return $rows;
	}

	function total_users(){
		global $connection;
		$query = "SELECT * FROM users";
		$res = mysqli_query($connection, $query);
		
		return mysqli_num_rows($res);
	}

	function fetch_user($user_id){
		global $connection;
		
		$query = "SELECT * FROM users ";
		$query .= "WHERE user_id = $user_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't fetch user! <br>".$query."<br>".mysqli_error($connection));
		}
		
		return mysqli_fetch_assoc($res);
	}

	function add_user($user_fields){
		global $connection;
		
		$username = $user_fields['username'];
		$user_password= $user_fields['user_password'];
		$user_firstname = $user_fields['user_firstname'];
		$user_lastname = $user_fields['user_lastname'];
		$user_email = $user_fields['user_email'];
		$user_image = $user_fields['user_image'];
		$user_role= $user_fields['user_role'];
		//$radSalt = $user_fields['randSalt'];
		$randSalt = "passenc";

		$query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_image, user_role, randSalt) ";
		$query .= "VALUES('$username', '$user_password', '$user_firstname', '$user_lastname', '$user_email', '$user_image', '$user_role', '$randSalt')";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't add user! <br>".$query."<br>".mysqli_error($connection));
		}
	}

	function delete_user($user_id){
		global $connection;
		$query = "DELETE FROM users ";
		$query .= "WHERE user_id = $user_id";
		$res = mysqli_query($connection,$query);
		
		if(!$res){
			die("ERROR: can't delete user! <br>".$query."<br>".mysqli_error($connection));
		}else{
				header('Location: users.php');
			}
	}

	function edit_user($user_id, $user_fields){
			global $connection;
		
			$username = $user_fields['username'];
			$user_password= $user_fields['user_password'];
			$user_firstname = $user_fields['user_firstname'];
			$user_lastname = $user_fields['user_lastname'];
			$user_email = $user_fields['user_email'];
			$user_image = $user_fields['user_image'];
			$user_role= $user_fields['user_role'];
			//$radSalt = $user_fields['randSalt'];
			$randSalt = "passenc";
		
			$query = "UPDATE users SET ";
			$query .= "username = '$username', ";
			$query .= "user_password = '$user_password', ";
			$query .= "user_firstname = '$user_firstname', ";
			$query .= "user_lastname = '$user_lastname', ";
			$query .= "user_email = '$user_email', ";
			$query .= "user_image = '$user_image', ";
			$query .= "user_role = '$user_role', ";
			$query .= "randSalt = '$randSalt' ";

			$query .= "WHERE user_id = $user_id";
			$res = mysqli_query($connection,$query);

			if(!$res){
				die("ERROR: can't update user! <br>".$query."<br>".mysqli_error($connection));
			}
	}
	function clone_user($user_id){
		global $connection;

		$row = fetch_user($user_id);
		add_user($row);
		header('Location: users.php');
	}

function fetch_admin_users(){
	global $connection;
		$query = "SELECT * FROM users ";
		$query .= "WHERE user_role = 'admin'";
		$res = mysqli_query($connection, $query);

		if(!$res){
				die("ERROR: can't fetch admins! <br>".$query."<br>".mysqli_error($connection));
		}
		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		} 
		return $rows;
}


#users - CRUD - end

function count_rows($tablename, $condition = '', $value = ''){
	global $connection;
	$query = "SELECT * FROM $tablename";
	
	if(!empty($condition) && !empty($value)){
		$query .= " WHERE $condition = '$value'";
	}
	$res = mysqli_query($connection, $query);
	if(!$res){
		die("ERROR: Can't count rows from $tablename.<br>".$query."<br>".mysqli_error($connection));
	}
	return mysqli_num_rows($res);
	
}
