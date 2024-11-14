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

        // Update the title and description in the spotlight record
        mysqli_query($conn, "UPDATE spotlight SET 
            title = '$newTitle', 
            description = '$newDescription'
            WHERE spotlight_id = $spotlight_id");

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
        <h2 class="text-center">Edit Spotlight</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="spotlightTitle" class="form-label">Title:</label>
                <input type="text" class="form-control" id="spotlightTitle" name="new_title" value="<?php echo htmlspecialchars($record['title']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="spotlightDescription" class="form-label">Description:</label>
                <textarea class="form-control" id="spotlightDescription" name="new_description" rows="5" required><?php echo htmlspecialchars($record['description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="formVideo" class="form-label">New Video (.mp4):</label>
                <input class="form-control" type="file" id="formVideo" name="new_video" accept=".mp4">
            </div>
            <button type="submit" class="btn btn-submit w-100">Save Changes</button>
        </form>
    </div>
</body>
</html>
