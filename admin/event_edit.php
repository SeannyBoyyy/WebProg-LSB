<?php
include('../config/config.php');

// Event edit
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
    $newEventDate = mysqli_real_escape_string($conn, $_POST['new_event_date']);
    $newLocation = mysqli_real_escape_string($conn, $_POST['new_location']);
    $newCategory = mysqli_real_escape_string($conn, $_POST['new_category']);

    // Check if the event id is set
    if (isset($_GET['event_id'])) {
        $event_id = $_GET['event_id'];

        // Update the event fields in the database
        mysqli_query($conn, "UPDATE events SET 
            title = '$newTitle', 
            description = '$newDescription',
            event_date = '$newEventDate',
            location = '$newLocation',
            category = '$newCategory'
            WHERE event_id = $event_id");

        // If the event is set to featured, unset all other featured events
        if ($newCategory == '1') {
            mysqli_query($conn, "UPDATE events SET category = '0' WHERE event_id != $event_id");
        }

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
                mysqli_query($conn, "UPDATE events SET image_url = '$newImageName' WHERE event_id = $event_id");
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
    <script>
        function toggleFeaturedWarning() {
            const categorySelect = document.getElementById("eventCategory");
            const featuredWarning = document.getElementById("featuredWarning");

            categorySelect.addEventListener("change", function() {
                if (categorySelect.value == "1") {
                    featuredWarning.classList.remove("d-none");
                } else {
                    featuredWarning.classList.add("d-none");
                }
            });
        }

        window.onload = toggleFeaturedWarning;
    </script>
</head>
<body>
    <div class="main-container">
        <h2 class="text-center">Edit Event</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="eventTitle" class="form-label">Title:</label>
                <input type="text" class="form-control" id="eventTitle" name="new_title" value="<?php echo htmlspecialchars($record['title']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="eventDescription" class="form-label">Description:</label>
                <textarea class="form-control" id="eventDescription" name="new_description" rows="5" required><?php echo htmlspecialchars($record['description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="eventDate" class="form-label">Event Date:</label>
                <input type="date" class="form-control" id="eventDate" name="new_event_date" value="<?php echo htmlspecialchars($record['event_date']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="eventLocation" class="form-label">Location:</label>
                <input type="text" class="form-control" id="eventLocation" name="new_location" value="<?php echo htmlspecialchars($record['location']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="eventCategory" class="form-label">Category:</label>
                <select class="form-control" id="eventCategory" name="new_category" required>
                    <option value="0" <?php if ($record['category'] == '0') echo 'selected'; ?>>General</option>
                    <option value="1" <?php if ($record['category'] == '1') echo 'selected'; ?>>Featured</option>
                </select>
            </div>
            
            <!-- Warning message for setting the event as featured -->
            <div id="featuredWarning" class="alert alert-warning mt-2 d-none" role="alert">
                Warning: Setting this event as featured will remove the current featured event.
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
