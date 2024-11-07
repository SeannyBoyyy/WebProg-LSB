<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include('../config/config.php');

// Handle form submission for adding spotlight
if (isset($_POST['upload_spotlight'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle image upload
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === 0) {
        $imageName = $_FILES['featured_image']['name'];
        $imageTmpName = $_FILES['featured_image']['tmp_name'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        
        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($imageExtension, $validImageExtensions)) {
            $newImageName = uniqid() . '.' . $imageExtension;
            $imageUploadPath = 'img/' . $newImageName;
            move_uploaded_file($imageTmpName, $imageUploadPath);
        } else {
            echo "<script>Swal.fire('Error!', 'Invalid image format!', 'error');</script>";
            exit();
        }
    }

    // Handle video upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
        $videoName = $_FILES['video']['name'];
        $videoTmpName = $_FILES['video']['tmp_name'];
        $videoExtension = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));

        if ($videoExtension === 'mp4') {
            $newVideoName = uniqid() . '.mp4';
            $videoUploadPath = 'vid/' . $newVideoName;
            move_uploaded_file($videoTmpName, $videoUploadPath);
        } else {
            echo "<script>Swal.fire('Error!', 'Only .mp4 videos allowed!', 'error');</script>";
            exit();
        }
    }

    $query = "INSERT INTO spotlight (title, description, featured_image_url, video_url, created_at) 
              VALUES ('$title', '$description', '$newImageName', '$newVideoName', NOW())";
    if (mysqli_query($conn, $query)) {
        echo "<script>Swal.fire('Success!', 'Spotlight added successfully!', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error!', 'Failed to add spotlight.', 'error');</script>";
    }
}

// Fetch spotlight data
$query = "SELECT * FROM spotlight";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Spotlight</h2>

    <!-- Add Spotlight Form -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title">Add New Spotlight</h5>
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
                    <label for="featured_image" class="form-label">Upload Image</label>
                    <input type="file" name="featured_image" id="featured_image" class="form-control" accept=".jpg,.jpeg,.png" required>
                </div>
                <div class="mb-3">
                    <label for="video" class="form-label">Upload Video (MP4)</label>
                    <input type="file" name="video" id="video" class="form-control" accept=".mp4" required>
                </div>
                <button type="submit" name="upload_spotlight" class="btn btn-primary">Add Spotlight</button>
            </form>
        </div>
    </div>

    <!-- Spotlight List Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Spotlight List</h5>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Video</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $num_rows['spotlight_id']; ?></td>
                                <td><?= htmlspecialchars($row['title']); ?></td>
                                <td><?= htmlspecialchars(substr($row['description'], 0, 25) . '...'); ?></td>
                                <td><img src="img/<?= $row['featured_image_url']; ?>" width="50" alt="Image"></td>
                                <td><a href="vid/<?= $row['video_url']; ?>" target="_blank">View Video</a></td>
                                <td>
                                    
                                    <form action="crud.php" method="post">

                                        <input type="hidden" name="id" value="<?= $row['spotlight_id']; ?>">
                                        
                                        <!-- Edit Button -->
                                        <button type="submit" class="btn btn-sm btn-outline-primary mt-2" name="spotlight_edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Read Button -->
                                        <button type="submit" class="btn btn-sm btn-outline-info mt-2" name="spotlight_read">
                                            <i class="bi bi-eye"></i> Read
                                        </button>

                                        <!-- Delete Button with SweetAlert -->
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="confirmDelete(<?= $row['spotlight_id']; ?>)">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No spotlight entries available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the spotlight entry.",
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

            const inputDelete = document.createElement('input');
            inputDelete.type = 'hidden';
            inputDelete.name = 'spotlight_delete';
            inputDelete.value = id;
            form.appendChild(inputDelete);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

<?php $conn->close(); ?>
