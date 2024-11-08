<?php
include('../config/config.php');

// News post
if (isset($_GET['news_id'])) {
    $news_id = $_GET['news_id'];

    // Fetch the record based on the provided id
    $result = mysqli_query($conn, "SELECT * FROM news WHERE news_id = $news_id");
    $record = mysqli_fetch_assoc($result);

    if (!$record) {
        echo "Record not found.";
        exit();
    }
}

// Process the form submission for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process the submitted data
    $newTitle = mysqli_real_escape_string($conn, $_POST['new_title']);
    $newContent = mysqli_real_escape_string($conn, $_POST['new_content']);
    $newAuthor = mysqli_real_escape_string($conn, $_POST['new_author']);
    $newCategory = mysqli_real_escape_string($conn, $_POST['new_category']);

    // Check if the news id is set
    if (isset($_GET['news_id'])) {
        $news_id = $_GET['news_id'];

        // Update the news record in the database
        mysqli_query($conn, "UPDATE news SET 
            title = '$newTitle', 
            content = '$newContent', 
            author = '$newAuthor', 
            category = '$newCategory' 
            WHERE news_id = $news_id");

        // Process image upload if a new image is provided
        if ($_FILES['new_image']['error'] !== 4) {
            $fileName = $_FILES['new_image']['name'];
            $fileSize = $_FILES['new_image']['size'];
            $tmpName = $_FILES['new_image']['tmp_name'];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if (in_array($imageExtension, $validImageExtension) && $fileSize <= 1000000) {
                $newImageName = uniqid() . '.' . $imageExtension;
                move_uploaded_file($tmpName, 'img/' . $newImageName);

                // Update the image URL in the database
                mysqli_query($conn, "UPDATE news SET image_url = '$newImageName' WHERE news_id = $news_id");
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid Image. Please upload a valid image file (jpg, jpeg, or png) with size up to 1MB.',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'index.php?active=news';
                    });
                </script>";
                exit();
            }
        }
    }

    // Redirect after successful update
    header("Location: index.php?active=news");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="middle mt-5">
        <div class="container-fluid w-50" style="margin-top: 90px;">
            <div class="col-md-6 container-fluid text-center">
                <div class="container-fluid">
                    <h2>Edit News</h2>
                </div>
            </div>
        </div>
        <div class="container-sm d-flex align-items-center mt-5 border rounded-5 p-3 bg-white shadow box-area p-5">
            <!-- Edit Form -->
            <form action="" method="post" enctype="multipart/form-data" class="w-100 g-3">
                <div class="mb-3">
                    <label for="newsTitle" class="form-label">News Title:</label>
                    <input type="text" class="form-control" id="newsTitle" name="new_title" value="<?php echo $record['title']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="newsContent" class="form-label">Content:</label>
                    <textarea class="form-control" id="newsContent" name="new_content" rows="5" required><?php echo $record['content']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="newsAuthor" class="form-label">Author:</label>
                    <input type="text" class="form-control" id="newsAuthor" name="new_author" value="<?php echo $record['author']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="newsCategory" class="form-label">Category:</label>
                    <select class="form-select" id="newsCategory" name="new_category" required>
                        <option value="General" <?php if ($record['category'] == 'General') echo 'selected'; ?>>General</option>
                        <option value="Featured" <?php if ($record['category'] == 'Featured') echo 'selected'; ?>>Featured</option>
                        <option value="Pending" <?php if ($record['category'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">New Image:</label>
                    <input class="form-control" type="file" id="formFile" name="new_image" accept=".jpg, .jpeg, .png">
                </div>
                <button type="submit" class="btn w-100 btn-md btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>
    