<?php
include('../config/config.php');

// Spotlight edit
if (isset($_GET['spotlight_id'])) {
    $spotlight_id = $_GET['spotlight_id'];

    // Fetch the record based on the provided id
    $result = mysqli_query($conn, "SELECT * FROM spotlight WHERE spotlight_id = $spotlight_id");
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

    // Check if the spotlight id is set
    if (isset($_GET['spotlight_id'])) {
        $spotlight_id = $_GET['spotlight_id'];

        // Update the spotlight record in the database
        mysqli_query($conn, "UPDATE spotlight SET 
            title = '$newTitle', 
            description = '$newDescription'
            WHERE spotlight_id = $spotlight_id");

        // Process image upload if a new image is provided
        if ($_FILES['new_image']['error'] !== 4) {
            $fileName = $_FILES['new_image']['name'];
            $tmpName = $_FILES['new_image']['tmp_name'];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($imageExtension, $validImageExtension) && $_FILES['new_image']['size'] <= 1000000) {
                $newImageName = uniqid() . '.' . $imageExtension;
                move_uploaded_file($tmpName, 'img/' . $newImageName);

                // Update the image URL in the database
                mysqli_query($conn, "UPDATE spotlight SET featured_image_url = '$newImageName' WHERE spotlight_id = $spotlight_id");
            }
        }

        // Process video upload if a new video is provided
        if ($_FILES['new_video']['error'] !== 4) {
            $videoName = $_FILES['new_video']['name'];
            $tmpName = $_FILES['new_video']['tmp_name'];

            $videoExtension = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));

            if ($videoExtension === 'mp4' && $_FILES['new_video']['size'] <= 50000000) {
                $newVideoName = uniqid() . '.mp4';
                move_uploaded_file($tmpName, 'vid/' . $newVideoName);

                // Update the video URL in the database
                mysqli_query($conn, "UPDATE spotlight SET video_url = '$newVideoName' WHERE spotlight_id = $spotlight_id");
            }
        }
    }

    // Redirect after successful update
    header("Location: index.php?active=spotlight");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Spotlight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="middle mt-5">
        <div class="container-fluid w-50" style="margin-top: 90px;">
            <div class="col-md-6 container-fluid text-center">
                <div class="container-fluid">
                    <h2>Edit Spotlight</h2>
                </div>
            </div>
        </div>
        <div class="container-sm d-flex align-items-center mt-5 border rounded-5 p-3 bg-white shadow box-area p-5">
            <!-- Edit Form -->
            <form action="" method="post" enctype="multipart/form-data" class="w-100 g-3">
                <div class="mb-3">
                    <label for="spotlightTitle" class="form-label">Title:</label>
                    <input type="text" class="form-control" id="spotlightTitle" name="new_title" value="<?php echo $record['title']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="spotlightDescription" class="form-label">Description:</label>
                    <textarea class="form-control" id="spotlightDescription" name="new_description" rows="5" required><?php echo $record['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">New Image:</label>
                    <input class="form-control" type="file" id="formFile" name="new_image" accept=".jpg, .jpeg, .png">
                </div>
                <div class="mb-3">
                    <label for="formVideo" class="form-label">New Video (.mp4):</label>
                    <input class="form-control" type="file" id="formVideo" name="new_video" accept=".mp4">
                </div>
                <button type="submit" class="btn w-100 btn-md btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>
