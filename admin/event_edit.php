<?php 
include('../config/config.php');

// Event post
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch the record based on the provided id
    $result = mysqli_query($conn, "SELECT * FROM events WHERE event_id = $event_id");
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
    $newDescription = mysqli_real_escape_string($conn, $_POST['new_description']);
    $newDate = mysqli_real_escape_string($conn, $_POST['new_date']);
    $newLocation = mysqli_real_escape_string($conn, $_POST['new_location']);

    // Check if the event id is set
    if (isset($_GET['event_id'])) {
        $event_id = $_GET['event_id'];

        // Update the event record in the database
        mysqli_query($conn, "UPDATE events SET 
            title = '$newTitle', 
            description = '$newDescription', 
            event_date = '$newDate', 
            location = '$newLocation' 
            WHERE event_id = $event_id");

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
                mysqli_query($conn, "UPDATE events SET image_url = '$newImageName' WHERE event_id = $event_id");
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid Image. Please upload a valid image file (jpg, jpeg, or png) with size up to 1MB.',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'index.php?active=events';
                    });
                </script>";
                exit();
            }
        }
    }

    // Redirect after successful update
    header("Location: index.php?active=events");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="middle mt-5">
        <div class="container-fluid w-50" style="margin-top: 90px;">
            <div class="col-md-6 container-fluid text-center">
                <div class="container-fluid">
                    <h2>Edit Event</h2>
                </div>
            </div>
        </div>
        <div class="container-sm d-flex align-items-center mt-5 border rounded-5 p-3 bg-white shadow box-area p-5">
            <!-- Edit Form -->
            <form action="" method="post" enctype="multipart/form-data" class="w-100 g-3">
                <div class="mb-3">
                    <label for="eventTitle" class="form-label">Event Title:</label>
                    <input type="text" class="form-control" id="eventTitle" name="new_title" value="<?php echo $record['title']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="eventDescription" class="form-label">Description:</label>
                    <textarea class="form-control" id="eventDescription" name="new_description" rows="3" required><?php echo $record['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="eventDate" class="form-label">Event Date:</label>
                    <input type="date" class="form-control" id="eventDate" name="new_date" value="<?php echo $record['event_date']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="eventLocation" class="form-label">Location:</label>
                    <input type="text" class="form-control" id="eventLocation" name="new_location" value="<?php echo $record['location']; ?>">
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
