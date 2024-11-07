<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include('../config/config.php');

// Handle form submission for adding news
if (isset($_POST['upload_news'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Image upload logic
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $tmpName = $_FILES['image']['tmp_name'];

        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate image extension
        if (!in_array($imageExtension, $validImageExtensions)) {
            echo "<script>Swal.fire('Error!', 'Invalid image extension!', 'error').then(function() {window.location = 'index.php?active=news';});</script>";
            exit();
        }

        // Validate image size (e.g., max 10MB)
        if ($fileSize > 10000000) {
            echo "<script>Swal.fire('Error!', 'Image size is too large!', 'error').then(function() {window.location = 'index.php?active=news';});</script>";
            exit();
        }

        // Generate a unique image name and move the file to the target directory
        $newImageName = uniqid() . '.' . $imageExtension;
        $uploadPath = 'img/' . $newImageName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            // Determine publish date based on category
            $published_date = ($category != 'Pending') ? 'NOW()' : 'NULL';

            // Insert news details into the database
            $query = "INSERT INTO news (title, content, author, image_url, category, created_at, published_date) 
                      VALUES ('$title', '$content', '$author', '$newImageName', '$category', NOW(), $published_date)";
                      
            if (mysqli_query($conn, $query)) {
                echo "<script>Swal.fire('Success!', 'News uploaded successfully!', 'success').then(function() {window.location = 'index.php?active=news';});</script>";
            } else {
                echo "<script>Swal.fire('Error!', 'Failed to upload news.', 'error').then(function() {window.location = 'index.php?active=news';});</script>";
            }
        } else {
            echo "<script>Swal.fire('Error!', 'Failed to upload image.', 'error').then(function() {window.location = 'index.php?active=news';});</script>";
        }
    } else {
        echo "<script>Swal.fire('Error!', 'Please select an image to upload.', 'error').then(function() {window.location = 'index.php?active=news';});</script>";
    }
}

// Retrieve all news articles from the database
$query = "SELECT * FROM news";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Manage News</h2>

    <!-- Add News Form -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title">Add New News</h5>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" name="author" id="author" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="General">General</option>
                        <option value="Featured">Featured</option>
                        <option value="Pending">Pending</option> <!-- User-submitted, pending approval -->
                    </select>
                </div>
                <button type="submit" name="upload_news" class="btn btn-primary">Add News</button>
            </form>
        </div>
    </div>

    <!-- News List Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">News List</h5>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Image</th> <!-- New column for the image -->
                        <th>Author</th>
                        <th>Category</th>
                        <th>Published Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['news_id']; ?></td>
                                <td><?= $row['title']; ?></td>
                                <td><?= htmlspecialchars(substr($row['content'], 0, 25) . '...'); ?></td>
                                <td>
                                    <?php if (!empty($row['image_url'])): ?>
                                        <img src="img/<?= $row['image_url']; ?>" alt="News Image" width="100"> <!-- Display image -->
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td><?= $row['author']; ?></td>
                                <td><?= $row['category']; ?></td>
                                <td><?= $row['published_date'] ? $row['published_date'] : 'Not Published'; ?></td>
                                <td>
                                    <form action="crud.php" method="post">

                                        <input type="hidden" name="id" value="<?= $row['news_id']; ?>">
                                        
                                        <!-- Publish Button (for pending news) -->
                                        <?php if ($row['category'] == 'Pending'): ?>
                                            <button type="submit" name="publish_news" class="btn btn-sm btn-outline-success mt-2">Publish</button>
                                        <?php endif; ?>
                                        
                                        <!-- Edit Button -->
                                        <button type="submit" class="btn btn-sm btn-outline-primary mt-2" name="news_edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Read Button -->
                                        <button type="submit" class="btn btn-sm btn-outline-info mt-2" name="news_read">
                                            <i class="bi bi-eye"></i> Read
                                        </button>

                                        <!-- Delete Button with SweetAlert -->
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="confirmDeleteNews(<?= $row['news_id']; ?>)">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No news available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDeleteNews(newsId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'crud.php';

            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = newsId;
            form.appendChild(inputId);

            const inputDelete = document.createElement('input');
            inputDelete.type = 'hidden';
            inputDelete.name = 'news_delete';
            form.appendChild(inputDelete);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

<?php
$conn->close();
?>
