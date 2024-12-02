<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="img/dplogo.png">
	<title>Add Author</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<!--<link rel="stylesheet" href="css/custom.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="css/mycustomadmin.css">
  <link rel="stylesheet" href="css/mycustomadd.css">
</head>
<body>
<!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark shadow fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="img/logo.png" alt="Logo" class="rounded-circle me-2" width="50"> 
        <span class="fw-bold text-light">Admin</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
         <span class="navbar-toggler-icon" style="background-color: #3D5300; background-image: url('data:image/svg+xml;charset=UTF8,%3Csvg xmlns%3D%27http%3A//www.w3.org/2000/svg%27 viewBox%3D%270 0 30 30%27%3E%3Cpath stroke%3D%27white%27 stroke-width%3D%272%27 d%3D%27M4 7h22M4 15h22M4 23h22%27/%3E%3C/svg%3E');"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="index.php" class="nav-link text-light" aria-current="page">Store</a>
          </li>
          <li class="nav-item">
            <a href="add-book.php" class="nav-link text-light">Add Book</a>
          </li>
          <li class="nav-item">
            <a href="add-category.php" class="nav-link text-light">Add Category</a>
          </li>
          <li class="nav-item">
            <a href="add-author.php" class="nav-link active">Add Author</a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link text-light">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

	<div class="container box">
     <form action="php/add-author.php"
           method="post" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		Add New Author
     	</h1>
     	<?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>
     	<div class="mb-3">
		    <label class="form-label">
		           	Author Name
		           </label>
		    <input type="text" 
		           class="form-control" 
		           name="author_name">
		</div>

	    <button type="submit" 
	            class="btn btn-primary">
	            Add Author</button>
     </form>
	</div>
</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
} ?>
