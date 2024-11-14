    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    include('../config/config.php');

    // Handle form submission for adding merchandise
    if (isset($_POST['upload_merch'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);  // Capture the category

        // Image upload logic
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $tmpName = $_FILES['image']['tmp_name'];

            $validImageExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validate image extension
            if (!in_array($imageExtension, $validImageExtensions)) {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid image extension!',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'index.php?active=merch';
                    });
                </script>";
                exit();
            }

            // Validate image size (e.g., max 10MB)
            if ($fileSize > 10000000) {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Image size is too large!',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'index.php?active=merch';
                    });
                </script>";
                exit();
            }

            // Generate a unique image name and move the file to the target directory
            $newImageName = uniqid() . '.' . $imageExtension;
            $uploadPath = 'img/' . $newImageName;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                // Insert merch details into the database
                $query = "INSERT INTO merch (name, description, price, stock_quantity, image_url, category, created_at) 
                  VALUES ('$name', '$description', '$price', '$stock_quantity', '$newImageName', '$category', NOW())";
                if (mysqli_query($conn, $query)) {
                    echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Merchandise uploaded successfully!',
                            icon: 'success'
                        }).then(function() {
                            window.location = 'index.php?active=merch';
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to upload merchandise.',
                            icon: 'error'
                        }).then(function() {
                            window.location = 'index.php?active=merch';
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
                        window.location = 'index.php?active=merch';
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
                    window.location = 'index.php?active=merch';
                });
            </script>";
        }
    }

    // Retrieve all merchandise records from the database
    $query = "SELECT * FROM merch ORDER BY merch_id DESC";
    $result = mysqli_query($conn, $query);
    ?>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Manage Merchandise</h2>

        <!-- Add Merchandise Form -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h5 class="card-title">Add New Merchandise</h5>
                <form method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Merchandise Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter merchandise name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="Enter price" required>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Enter description" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" placeholder="Enter stock quantity" required>
                        </div>
                        <div class="col-md-6">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="regular">Regular</option>
                                <option value="featured">Featured</option>
                            </select>
                        </div>
                        <div class="col-md-12 d-flex align-items-end">
                            <button type="submit" name="upload_merch" class="btn btn-primary w-100">Add Merchandise</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Merchandise List Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Merchandise List</h5>
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $counter = 1; // Initialize the counter ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $counter++; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['description']; ?></td>
                                    <td><?= number_format($row['price'], 2); ?></td>
                                    <td><?= $row['stock_quantity']; ?></td>
                                    <td>
                                        <img src="img/<?= $row['image_url']; ?>" alt="<?= $row['name']; ?>" class="img-thumbnail" style="width: 60px; height: 60px;">
                                    </td>
                                    <td><?= ucfirst($row['category']); ?></td>
                                    <td><?= date('F j, Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <!-- CRUD Operations Form -->
                                        <form action="crud.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['merch_id']; ?>">
                                            
                                            <!-- Edit Button -->
                                            <button type="submit" class="btn btn-sm btn-outline-primary mt-2" name="merch_edit">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            
                                            <!-- Read Button -->
                                            <button type="submit" class="btn btn-sm btn-outline-info mt-2" name="merch_read">
                                                <i class="bi bi-eye"></i> Read
                                            </button>
                                            
                                            <!-- Delete Button with SweetAlert -->
                                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="confirmDeleteMerch(<?php echo $row['merch_id']; ?>)">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">No merchandise available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    function confirmDeleteMerch(merchId) {
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
                inputId.value = merchId;
                form.appendChild(inputId);
                
                // Create an input for the delete action
                const inputDelete = document.createElement('input');
                inputDelete.type = 'hidden';
                inputDelete.name = 'merch_delete';
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
