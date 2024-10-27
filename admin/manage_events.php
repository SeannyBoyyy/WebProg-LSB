<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include('../config/config.php');

if (isset($_POST['upload_event'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    // Image upload logic
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $tmpName = $_FILES['image']['tmp_name'];

        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $validImageExtensions)) {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Invalid image extension!',
                    icon: 'error'
                }).then(function() {
                    window.location = 'index.php?active=events';
                });
            </script>";
            exit();
        }

        if ($fileSize > 10000000) {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Image size is too large!',
                    icon: 'error'
                }).then(function() {
                    window.location = 'index.php?active=events';
                });
            </script>";
            exit();
        }

        $newImageName = uniqid() . '.' . $imageExtension;
        $uploadPath = 'img/' . $newImageName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            $query = "INSERT INTO events (title, description, event_date, location, image_url, created_at) 
                      VALUES ('$title', '$description', '$event_date', '$location', '$newImageName', NOW())";
            if (mysqli_query($conn, $query)) {
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Event uploaded successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location = 'index.php?active=events';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to upload event.',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'index.php?active=events';
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to upload image.',
                    icon: 'error'
                }).then(function() {
                    window.location = 'index.php?active=events';
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Please select an image to upload.',
                icon: 'error'
            }).then(function() {
                window.location = 'index.php?active=events';
            });
        </script>";
    }
}
?>


    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Manage Events</h4>
                </div>
                <div class="card-body">
                    <!-- Add Event Form -->
                    <form method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Event Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter event title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="event_date" class="form-label">Event Date</label>
                                <input type="date" name="event_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="description" class="form-label">Event Description</label>
                                <textarea name="description" class="form-control" placeholder="Enter event description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label">Event Location</label>
                                <input type="text" name="location" class="form-control" placeholder="Enter event location" required>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label">Upload Image</label>
                                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png" required>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" name="upload_event" class="btn btn-primary w-100">
                                    <i class="bi bi-upload"></i> Add Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Event List Table -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Event List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date DESC");
                                if ($result && $result->num_rows > 0): 
                                    while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $row['event_id']; ?></td>
                                            <td><?= htmlspecialchars($row['title']); ?></td>
                                            <td><?= htmlspecialchars($row['description']); ?></td>
                                            <td><?= date('F j, Y', strtotime($row['event_date'])); ?></td>
                                            <td><?= htmlspecialchars($row['location']); ?></td>
                                            <td>
                                                <img src="img/<?= $row['image_url']; ?>" alt="<?= htmlspecialchars($row['title']); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                            </td>
                                            <td><?= date('F j, Y', strtotime($row['created_at'])); ?></td>
                                            <td>
                                                
                                                <!-- CRUD Operations Form -->
                                                <form action="crud.php" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $row['event_id']; ?>">
                                                    
                                                    <!-- Edit Button -->
                                                    <button type="submit" class="btn btn-sm btn-outline-primary mt-2" name="event_edit">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </button>
                                                    
                                                    <!-- Read Button -->
                                                    <button type="submit" class="btn btn-sm btn-outline-info mt-2" name="event_read">
                                                        <i class="bi bi-eye"></i> Read
                                                    </button>
                                                    
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="confirmDeleteEvents(<?php echo $row['event_id']; ?>)">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    <?php endwhile; 
                                else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No events available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
function confirmDeleteEvents(eventId) {
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
            // Create a form programmatically to submit
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'crud.php';
            
            // Create an input for the ID
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = eventId;
            form.appendChild(inputId);
            
            // Create an input for the delete action
            const inputDelete = document.createElement('input');
            inputDelete.type = 'hidden';
            inputDelete.name = 'event_delete';
            form.appendChild(inputDelete);
            
            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

    
<?php
    // Close the database connection
$conn->close();
?>
   