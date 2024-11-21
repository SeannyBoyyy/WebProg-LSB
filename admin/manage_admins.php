<?php
include('../config/config.php');

// Handle form submission for approving admins
if (isset($_POST['approve_admin'])) {
    $adminId = intval($_POST['id']);
    $query = "UPDATE admins SET status = 'approved' WHERE admin_id = $adminId";

    if (mysqli_query($conn, $query)) {
        echo "<script>Swal.fire('Success!', 'Admin approved successfully!', 'success').then(function() {window.location = 'index.php?active=admins';});</script>";
    } else {
        echo "<script>Swal.fire('Error!', 'Failed to approve admin.', 'error').then(function() {window.location = 'index.php?active=admins';});</script>";
    }
}

// Retrieve pending and approved admins separately
$pendingAdminsQuery = "SELECT * FROM admins WHERE status = 'pending' ORDER BY admin_id DESC";
$pendingAdminsResult = mysqli_query($conn, $pendingAdminsQuery);

$approvedAdminsQuery = "SELECT * FROM admins WHERE status = 'approved' ORDER BY admin_id DESC";
$approvedAdminsResult = mysqli_query($conn, $approvedAdminsQuery);

// Handle the admin registration form
if (isset($_POST['register_admin'])) {
    // Sanitize and validate inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));
    $email = htmlspecialchars(trim($_POST['email']));
    $full_name = htmlspecialchars(trim($_POST['full_name']));

    // Validate form inputs
    if (empty($username) || empty($password) || empty($confirm_password) || empty($email) || empty($full_name)) {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/', $password)) {
        $error = 'Password must be at least 8 characters long, with at least one uppercase letter, one number, and one special character.';
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $existing = $result->fetch_assoc();
            $error = ($existing['username'] === $username) ? 'Username already exists.' : 'Email is already registered.';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new admin into the database
            $stmt = $conn->prepare("INSERT INTO admins (username, password_hash, email, full_name, created_at, status) VALUES (?, ?, ?, ?, NOW(), 'approved')");
            $stmt->bind_param("ssss", $username, $hashed_password, $email, $full_name);

            if ($stmt->execute()) {
                // Display success message with SweetAlert and redirect
                echo "<script>Swal.fire('Success!', 'Registration successful. You can now login.', 'success').then(function() {window.location = 'index.php?active=admins';});</script>";
            } else {
                $error = 'There was an error during registration. Please try again.';
            }
        }
        $stmt->close();
    }
}

?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Manage Admins</h2>

    <!-- Admin Registration Form -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title mb-3">Register New Admin</h5>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <small class="form-text text-muted">
                        Password must be at least 8 characters long, with at least one uppercase letter, one number, and one special character.
                    </small>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" name="register_admin" class="btn btn-primary w-100">Register</button>
            </form>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3"><?= $error; ?></div>
            <?php elseif (isset($success)): ?>
                <div class="alert alert-success mt-3"><?= $success; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pending Admins Table -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title mb-3">Pending Admins</h5>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pendingAdminsResult && $pendingAdminsResult->num_rows > 0): ?>
                        <?php $counter = 1; // Initialize the counter ?>
                        <?php while($row = $pendingAdminsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= $counter++; ?></td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['full_name']); ?></td>
                                <td>
                                    <form action="" method="post" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $row['admin_id']; ?>">
                                        <button type="submit" name="approve_admin" class="btn btn-sm btn-outline-success">Approve</button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDeleteAdmin(<?= $row['admin_id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No pending admins.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Approved Admins Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Approved Admins</h5>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($approvedAdminsResult && $approvedAdminsResult->num_rows > 0): ?>
                        <?php $counter1 = 1; // Initialize the counter ?>
                        <?php while($row = $approvedAdminsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= $counter1++; ?></td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['full_name']); ?></td>
                                <td><?= $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No approved admins.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
function confirmDeleteAdmin(adminId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
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
            inputId.value = adminId;
            form.appendChild(inputId);

            const inputDelete = document.createElement('input');
            inputDelete.type = 'hidden';
            inputDelete.name = 'admin_delete';
            form.appendChild(inputDelete);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

<?php
$conn->close();
?>
