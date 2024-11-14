<?php
include('../config/config.php');

// News edit
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

        // Update the title, content, author, and category in the news record
        mysqli_query($conn, "UPDATE news SET 
            title = '$newTitle', 
            content = '$newContent',
            author = '$newAuthor',
            category = '$newCategory'
            WHERE news_id = $news_id");

        // Process image upload if a new image is provided
        if ($_FILES['new_image']['error'] !== 4) {
            $imageName = $_FILES['new_image']['name'];
            $tmpName = $_FILES['new_image']['tmp_name'];

            $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            if (in_array($imageExtension, $allowedExtensions) && $_FILES['new_image']['size'] <= 2000000) {
                $newImageName = uniqid() . '.' . $imageExtension;
                move_uploaded_file($tmpName, 'img/' . $newImageName);

                // Update the image URL in the database
                mysqli_query($conn, "UPDATE news SET image_url = '$newImageName' WHERE news_id = $news_id");
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
    <style>
        body {
            background-color: #f7f9fc;
            font-family: Arial, sans-serif;
        }
        .main-container {
            max-width: 600px;
            margin: 90px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .main-container h2 {
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }
        .form-label {
            font-weight: 600;
            color: #555;
        }
        .btn-submit {
            background-color: #28a745;
            color: #fff;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <h2 class="text-center">Edit News</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="newsTitle" class="form-label">Title:</label>
                <input type="text" class="form-control" id="newsTitle" name="new_title" value="<?php echo htmlspecialchars($record['title']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="newsContent" class="form-label">Content:</label>
                <textarea class="form-control" id="newsContent" name="new_content" rows="5" required><?php echo htmlspecialchars($record['content']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="newsAuthor" class="form-label">Author:</label>
                <input type="text" class="form-control" id="newsAuthor" name="new_author" value="<?php echo htmlspecialchars($record['author']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="newsCategory" class="form-label">Category:</label>
                <select class="form-control" id="newsCategory" name="new_category" required>
                    <option value="General" <?php if ($record['category'] == 'General') echo 'selected'; ?>>General</option>
                    <option value="Featured" <?php if ($record['category'] == 'Featured') echo 'selected'; ?>>Featured</option>
                    <option value="Pending" <?php if ($record['category'] == 'Pending') echo 'selected'; ?>>Pending</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="formImage" class="form-label">New Image (JPG, JPEG, PNG):</label>
                <input class="form-control" type="file" id="formImage" name="new_image" accept=".jpg, .jpeg, .png">
            </div>
            <button type="submit" class="btn btn-submit w-100">Save Changes</button>
        </form>
    </div>
</body>
</html>
    