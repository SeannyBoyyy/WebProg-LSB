<?php
include('../config/config.php');

// Merch post
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

    // Check if the merchandise id is set
    if (isset($_GET['merch_id'])) {
        $merch_id = $_GET['merch_id'];

        // Update the merch record in the database
        mysqli_query($conn, "UPDATE merch SET 
            name = '$newName', 
            description = '$newDescription', 
            price = '$newPrice', 
            stock_quantity = '$newStockQuantity' 
            WHERE merch_id = $merch_id");

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
                mysqli_query($conn, "UPDATE merch SET image_url = '$newImageName' WHERE merch_id = $merch_id");
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid Image. Please upload a valid image file (jpg, jpeg, or png) with size up to 1MB.',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'index.php?active=merch';
                    });
                </script>";
                exit();
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="middle mt-5">
        <div class="container-fluid w-50" style="margin-top: 90px;">
            <div class="col-md-6 container-fluid text-center">
                <div class="container-fluid">
                    <h2>Edit Merchandise</h2>
                </div>
            </div>
        </div>
        <div class="container-sm d-flex align-items-center mt-5 border rounded-5 p-3 bg-white shadow box-area p-5">
            <!-- Edit Form -->
            <form action="" method="post" enctype="multipart/form-data" class="w-100 g-3">
                <div class="mb-3">
                    <label for="merchName" class="form-label">Merchandise Name:</label>
                    <input type="text" class="form-control" id="merchName" name="new_name" value="<?php echo $record['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="merchDescription" class="form-label">Description:</label>
                    <textarea class="form-control" id="merchDescription" name="new_description" rows="3" required><?php echo $record['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="merchPrice" class="form-label">Price:</label>
                    <input type="number" class="form-control" id="merchPrice" name="new_price" value="<?php echo $record['price']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="merchStock" class="form-label">Stock Quantity:</label>
                    <input type="number" class="form-control" id="merchStock" name="new_stock_quantity" value="<?php echo $record['stock_quantity']; ?>" required>
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
