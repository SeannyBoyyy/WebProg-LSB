<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include('../config/config.php');

// Handle form submission for adding programs
if (isset($_POST['upload_program'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
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
            echo "<script>Swal.fire('Error!', 'Invalid image extension!', 'error').then(function() {window.location = 'index.php?active=programs';});</script>";
            exit();
        }

        // Validate image size (e.g., max 10MB)
        if ($fileSize > 10000000) {
            echo "<script>Swal.fire('Error!', 'Image size is too large!', 'error').then(function() {window.location = 'index.php?active=programs';});</script>";
            exit();
        }

        // Generate a unique image name and move the file to the target directory
        $newImageName = uniqid() . '.' . $imageExtension;
        $uploadPath = 'img/' . $newImageName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            // Insert program details into the database
            $query = "INSERT INTO programs (title, description, image_url, category, created_at) 
                      VALUES ('$title', '$description', '$newImageName', '$category', NOW())";
            if (mysqli_query($conn, $query)) {
                echo "<script>Swal.fire('Success!', 'Program uploaded successfully!', 'success').then(function() {window.location = 'index.php?active=programs';});</script>";
            } else {
                echo "<script>Swal.fire('Error!', 'Failed to upload program.', 'error').then(function() {window.location = 'index.php?active=programs';});</script>";
            }
        } else {
            echo "<script>Swal.fire('Error!', 'Failed to upload image.', 'error').then(function() {window.location = 'index.php?active=programs';});</script>";
        }
    } else {
        echo "<script>Swal.fire('Error!', 'Please select an image to upload.', 'error').then(function() {window.location = 'index.php?active=programs';});</script>";
    }
}

// Retrieve programs by category
$seniorHighQuery = "SELECT * FROM programs WHERE category = 'Senior High'";
$seniorHighResult = mysqli_query($conn, $seniorHighQuery);

$collegeQuery = "SELECT * FROM programs WHERE category = 'College'";
$collegeResult = mysqli_query($conn, $collegeQuery);
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Manage Programs</h2>

    <!-- Add Program Form -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title">Add New Program</h5>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="Senior High">Senior High</option>
                        <option value="College">College</option>
                    </select>
                </div>
                <button type="submit" name="upload_program" class="btn btn-primary">Add Program</button>
            </form>
        </div>
    </div>

    <!-- Senior High Programs Table -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title mb-3">Senior High Programs</h5>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($seniorHighResult && $seniorHighResult->num_rows > 0): ?>
                        <?php while($row = $seniorHighResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['program_id']; ?></td>
                                <td><?= $row['title']; ?></td>
                                <td><?= htmlspecialchars(substr($row['description'], 0, 25) . '...'); ?></td>
                                <td><img src="img/<?= $row['image_url']; ?>" alt="Program Image" width="100"></td>
                                <td><?= $row['created_at']; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger mt-2" onclick="confirmDeleteProgram(<?= $row['program_id']; ?>)">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No Senior High programs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- College Programs Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">College Programs</h5>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($collegeResult && $collegeResult->num_rows > 0): ?>
                        <?php while($row = $collegeResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['program_id']; ?></td>
                                <td><?= $row['title']; ?></td>
                                <td><?= htmlspecialchars(substr($row['description'], 0, 25) . '...'); ?></td>
                                <td><img src="img/<?= $row['image_url']; ?>" alt="Program Image" width="100"></td>
                                <td><?= $row['created_at']; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger mt-2" onclick="confirmDeleteProgram(<?= $row['program_id']; ?>)">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No College programs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDeleteProgram(programId) {
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
            inputId.value = programId;
            form.appendChild(inputId);

            const inputDelete = document.createElement('input');
            inputDelete.type = 'hidden';
            inputDelete.name = 'delete_program';
            inputDelete.value = '1';
            form.appendChild(inputDelete);

            document.body.appendChild(form);
            form.submit();
        }
    })
}
</script>
