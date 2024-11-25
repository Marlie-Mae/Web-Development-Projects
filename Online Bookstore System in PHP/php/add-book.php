<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    include "../db_conn.php";

    // Initialize variables for form data
    $title = $desc = $author_id = $category_id = "";
    $authors = $categories = [];

    // Fetch authors and categories from the database for the dropdowns
    try {
        // Fetch authors
        $stmt_authors = $conn->prepare("SELECT id, name FROM authors");
        $stmt_authors->execute();
        $authors = $stmt_authors->fetchAll(PDO::FETCH_ASSOC);

        // Fetch categories
        $stmt_categories = $conn->prepare("SELECT id, name FROM categories");
        $stmt_categories->execute();
        $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        header("Location: add-book.php?error=Failed to fetch authors or categories. " . $e->getMessage());
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['book_title'];
        $desc = $_POST['book_description'];
        $author_id = $_POST['book_author'];
        $category_id = $_POST['book_category'];

        // File uploads (Cover and Book File)
        $book_cover = $_FILES['book_cover']['name'];
        $book_cover_temp = $_FILES['book_cover']['tmp_name'];
        $book_file = $_FILES['file']['name'];
        $book_file_temp = $_FILES['file']['tmp_name'];

        // Define upload directories
        $cover_upload_dir = "uploads/cover/";
        $file_upload_dir = "uploads/file/";

        // Ensure directories exist
        if (!is_dir($cover_upload_dir)) {
            mkdir($cover_upload_dir, 0777, true);
        }
        if (!is_dir($file_upload_dir)) {
            mkdir($file_upload_dir, 0777, true);
        }

        // Set paths for uploaded files
        $cover_path = $cover_upload_dir . basename($book_cover);
        $file_path = $file_upload_dir . basename($book_file);

        if (move_uploaded_file($book_cover_temp, $cover_path) && move_uploaded_file($book_file_temp, $file_path)) {
            try {
                // Insert the book data into the database
                $query = "INSERT INTO books (title, description, author_id, category_id, cover, file) 
                          VALUES (:title, :description, :author_id, :category_id, :cover, :file)";
                
                $stmt = $conn->prepare($query);
                $stmt->execute([
                    ':title' => $title,
                    ':description' => $desc,
                    ':author_id' => $author_id,
                    ':category_id' => $category_id,
                    ':cover' => $cover_path,
                    ':file' => $file_path
                ]);

                header("Location: add-book.php?success=Book added successfully");
                exit;
            } catch (PDOException $e) {
                header("Location: add-book.php?error=Failed to add book. " . $e->getMessage());
                exit;
            }
        } else {
            header("Location: add-book.php?error=File upload failed. Try again.");
            exit;
        }
    }
} else {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Book</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="../admin.php">Admin</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" 
		             aria-current="page" 
		             href="../index.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link active" 
		             href="../add-book.php">Add Book</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="../add-category.php">Add Category</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="../add-author.php">Add Author</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href=".//logout.php">Logout</a>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
     <form action="php/add-book.php"
           method="post"
           enctype="multipart/form-data" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		Add New Book
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
		           Book Title
		           </label>
		    <input type="text" 
		           class="form-control"
		           value="<?=$title?>" 
		           name="book_title">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Description
		           </label>
		    <input type="text" 
		           class="form-control" 
		           value="<?=$desc?>"
		           name="book_description">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Author
		           </label>
		    <select name="book_author"
		            class="form-control">
		    	    <option value="0">
		    	    	Select author
		    	    </option>
		    	    <?php 
                    if ($authors == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($authors as $author) { 
		    	    	if ($author_id == $author['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$author['id']?>">
		    	    	  <?=$author['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$author['id']?>">
							<?=$author['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Category
		           </label>
		    <select name="book_category"
		            class="form-control">
		    	    <option value="0">
		    	    	Select category
		    	    </option>
		    	    <?php 
                    if ($categories == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($categories as $category) { 
		    	    	if ($category_id == $category['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$category['id']?>">
		    	    	  <?=$category['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$category['id']?>">
							<?=$category['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Cover
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="book_cover">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           File
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="file">
		</div>

	    <button type="submit" 
	            class="btn btn-primary">
	            Add Book</button>
     </form>
	</div>
</body>
</html>
