<?php 
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="img/dplogo.png">
	<title>Digital Pages</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">
	
	<!--<link rel="stylesheet" href="css/custom.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="css/mycustomindex.css">

</head>
<body>
		 <!-- Navbar -->
		 <nav class="navbar navbar-expand-lg navbar-dark shadow fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="img/logo.png" alt="Logo" class="rounded-circle me-2" width="50"> 
      <span class="fw-bold text-light">Digital Pages</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
	<span class="navbar-toggler-icon" style="background-color: #3D5300; background-image: url('data:image/svg+xml;charset=UTF8,%3Csvg xmlns%3D%27http%3A//www.w3.org/2000/svg%27 viewBox%3D%270 0 30 30%27%3E%3Cpath stroke%3D%27white%27 stroke-width%3D%272%27 d%3D%27M4 7h22M4 15h22M4 23h22%27/%3E%3C/svg%3E');"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="index.php" class="nav-link active" aria-current="page">Store</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-light">Contact</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-light">About</a>
        </li>
        <li class="nav-item">
          <?php if (isset($_SESSION['user_id'])) { ?>
            <a href="admin.php" class="nav-link text-light">Admin</a>
          <?php } else { ?>
            <a href="login.php" class="nav-link text-light">Login</a>
          <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

		
  <header class="text-center text-light py-5">
  <h1 class="display-4 fw-bold">Welcome to Digital Pages</h1>
  <p class="lead">Discover, Read, and Download Your Favorite Books</p>
  
  <!-- Centered Search Form -->
  <form action="search.php" method="get" class="mt-4">
    <div class="d-flex justify-content-center">
      <div style="width: 50%; max-width: 600px;" class="input-group">
        <!-- Input Field -->
        <input 
          type="text" 
          name="key" 
          class="form-control rounded-pill" 
          placeholder="Search for books..." 
          aria-label="Search Book..." 
          aria-describedby="basic-addon2">
        
        <!-- Search Button with Font Awesome Search Icon -->
        <button 
          class="input-group-text btn btn-warning rounded-pill ms-2" 
          type="submit" 
          id="basic-addon2" 
          style="display: flex; align-items: center; justify-content: center;">
          <i class="fas fa-search" style="color: black;"></i>
        </button>
      </div>
    </div>
  </form>
</header>

<div class="container">
	<div class="d-flex justify-content-center pt-3">
			<?php if ($books == 0){ ?>
				<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
			    There is no book in the database
		       </div>
			<?php }else{ ?>
			<div class="pdf-list d-flex flex-wrap">
				<?php foreach ($books as $book) { ?>
				<div class="card m-1">
					<img src="<?=$book['cover']?>"
					     class="card-img-top">
					<div class="card-body">
						<h5 class="card-title">
							<?=$book['title']?>
						</h5>
						<p class="card-text">
							<i><b>By:
								<?php foreach($authors as $author){ 
									if ($author['id'] == $book['author_id']) {
										echo $author['name'];
										break;
									}
								?>

								<?php } ?>
							<br></b></i>
							<?=$book['description']?>
							<br><i><b>Category:
								<?php foreach($categories as $category){ 
									if ($category['id'] == $book['category_id']) {
										echo $category['name'];
										break;
									}
								?>

								<?php } ?>
							<br></b></i>
						</p>
                       <a href="<?=$book['file']?>"
                          class="btn btn-success">Open</a>

                        <a href="/<?=$book['file']?>"
                          class="btn btn-primary"
                          download="<?=$book['title']?>">Download</a>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="category">
			<!-- List of categories -->
			<div class="list-group">
				<?php if ($categories == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Category</a>
				   <?php foreach ($categories as $category ) {?>
				  
				   <a href="category.php?id=<?=$category['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$category['name']?></a>
				<?php } } ?>
			</div>

			<!-- List of authors -->
			<div class="list-group mt-5">
				<?php if ($authors == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Author</a>
				   <?php foreach ($authors as $author ) {?>
				  
				   <a href="author.php?id=<?=$author['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$author['name']?></a>
				<?php } } ?>
			</div>
		</div>
		</div>
		</div>

		<!-- Footer -->
		<footer class="text-light py-4">
		<div class="container text-center">
			<p class="mb-0">© 2024 Digital Pages. All rights reserved.</p>
			<div class="social-icons mt-3">
			<!-- Social Media Icons -->
			<a href="#" class="text-light me-3">
				<i class="fab fa-facebook-square"></i>
			</a>
			<a href="#" class="text-light me-3">
				<i class="fab fa-twitter-square"></i>
			</a>
			<a href="#" class="text-light me-3">
				<i class="fab fa-instagram"></i>
			</a>
			<a href="#" class="text-light">
				<i class="fab fa-linkedin"></i>
			</a>
			</div>
			<p class="mt-3"><a href="privacy-policy.html" class="text-light">Privacy Policy</a> | <a href="terms.html" class="text-light">Terms of Service</a></p>
		</div>
		</footer>
</body>
</html>
