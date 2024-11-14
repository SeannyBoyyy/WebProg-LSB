<?php
include('../config/config.php');

// Merch edit
if (isset($_GET['merch_id'])) {
    $merch_id = $_GET['merch_id'];

    // Fetch the record based on the provided id
    $result = mysqli_query($conn, "SELECT * FROM merch WHERE merch_id = $merch_id");
    $record = mysqli_fetch_assoc($result);

    if (!$record) {
        echo "Record not found.";
        exit();
    }
}

// Process the form submission for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process the submitted data
    $newName = mysqli_real_escape_string($conn, $_POST['new_name']);
    $newDescription = mysqli_real_escape_string($conn, $_POST['new_description']);
    $newPrice = mysqli_real_escape_string($conn, $_POST['new_price']);
    $newStockQuantity = mysqli_real_escape_string($conn, $_POST['new_stock_quantity']);
    $newCategory = mysqli_real_escape_string($conn, $_POST['new_category']);

    // Check if the merch id is set
    if (isset($_GET['merch_id'])) {
        $merch_id = $_GET['merch_id'];

        // Update the merch fields in the database
        mysqli_query($conn, "UPDATE merch SET 
            name = '$newName', 
            description = '$newDescription',
            price = '$newPrice',
            stock_quantity = '$newStockQuantity',
            category = '$newCategory'
            WHERE merch_id = $merch_id");

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
                mysqli_query($conn, "UPDATE merch SET image_url = '$newImageName' WHERE merch_id = $merch_id");
            }
        }
    }

    // Redirect after successful update
    header("Location: index.php?active=merch");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Merchandise</title>
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
        <h2 class="text-center">Edit Merchandise</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="merchName" class="form-label">Name:</label>
                <input type="text" class="form-control" id="merchName" name="new_name" value="<?php echo htmlspecialchars($record['name']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="merchDescription" class="form-label">Description:</label>
                <textarea class="form-control" id="merchDescription" name="new_description" rows="5" required><?php echo htmlspecialchars($record['description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="merchPrice" class="form-label">Price:</label>
                <input type="number" step="0.01" class="form-control" id="merchPrice" name="new_price" value="<?php echo htmlspecialchars($record['price']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="merchStock" class="form-label">Stock Quantity:</label>
                <input type="number" class="form-control" id="merchStock" name="new_stock_quantity" value="<?php echo htmlspecialchars($record['stock_quantity']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="merchCategory" class="form-label">Category:</label>
                <select class="form-control" id="eventCategory" name="new_category" required>
                    <option value="featured" <?php if ($record['category'] == 'featured') echo 'selected'; ?>>Featured</option>
                    <option value="regular" <?php if ($record['category'] == 'regular') echo 'selected'; ?>>Regular</option>
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
