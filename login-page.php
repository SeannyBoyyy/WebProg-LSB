<?php
session_start();
require_once './config/config.php'; // Include your database configuration

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate form inputs
    if (empty($username) || empty($password)) {
        $error = 'Please fill in both fields.';
    } else {
        // Prepare SQL query to fetch admin by username
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Check if status is approved
            if ($admin['status'] !== 'approved') {
                $error = 'Your account is pending approval. Please wait for admin approval.';
            } else {
                // Verify password
                if (password_verify($password, $admin['password_hash'])) {
                    // Password is correct, start session and redirect to dashboard
                    $_SESSION['admin_id'] = $admin['admin_id'];
                    $_SESSION['username'] = $admin['username'];
                    $_SESSION['full_name'] = $admin['full_name'];
                    header('Location: ./admin/index.php?active=dashboard');
                    exit();
                } else {
                    $error = 'Incorrect password.';
                }
            }
        } else {
            $error = 'Admin not found.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Logo CSS -->
    <link rel="icon" type="image/x-icon" href="img/lsb_png.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Oswald:wght@500&display=swap" rel="stylesheet">

    <style>
        /* Navbar */
        .navbar-dark .navbar-nav .nav-link {
            color: white; /* Adjust the color of the links */
            transition: color 0.3s ease;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffdd57; /* Change to your preferred hover color */
        }

        .navbar-dark .navbar-nav .nav-link.active {
            color: #ffdd57; /* Change to your preferred active color */
            font-weight: bold;
            border-bottom: 2px solid #ffdd57; /* Optional: Add an underline for active state */
        }
        
        .navbar-brand, .nav-link {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .login-left {
            background: linear-gradient(135deg, #301934, #5e3b8f);
            color: white;
            padding: 50px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .login-left h1 {
            font-family: 'Oswald', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .login-left p {
            font-size: 1.1rem;
        }
        .login-right {
            padding: 40px 30px;
        }
        .error {
            color: #dc3545;
        }
        .btn-primary {
            background-color: #301934;
            border-color: #301934;
        }
        .btn-primary:hover {
            background-color: #5e3b8f;
            border-color: #5e3b8f;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header id="navbar" class="header py-3" style="background-color: #301934;">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="index.php"><img src="img/lyce_logo_v2.png" style="width: 100%;max-width: 75%;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- Programs Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="programsDropdown" role="button" aria-expanded="false">
                                Programs
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="programsDropdown">
                                <li><a class="dropdown-item" href="overview.php">Overview</a></li>
                                <li><a class="dropdown-item" href="senior_high.php">Senior High</a></li>
                                <li><a class="dropdown-item" href="college.php">College</a></li>
                            </ul>
                        </li>
                        <!-- Other Navbar Items -->
                        <li class="nav-item"><a class="nav-link" href="news.php">News & Spotlight</a></li>
                        <li class="nav-item"><a class="nav-link" href="merch.php">Merchandise</a></li>
                        <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    
    <div class="login-container">
        <div class="login-box row g-0">
            <!-- Left Column -->
            <div class="col-lg-6 login-left">
                <img src="img/lyce_logo_v2.png" alt="Logo" class="img-fluid mb-4" style="max-width: 70%;">
                <h1>Welcome to Admin Portal</h1>
                <p>Manage your website effectively and stay in control of all activities.</p>
            </div>
            <!-- Right Column -->
            <div class="col-lg-6 login-right">
                <h2 class="text-center mb-4">Admin Login</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>

                <form action="login-page.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="mt-3 text-center">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white py-4" style="background: #301934;">
        <div class="container text-center">
            <p>&copy; 2024 Lyceum of Subic Bay. All Rights Reserved.</p>
            <div>
                <a href="#" class="text-white me-3">Facebook</a>
                <a href="#" class="text-white me-3">Twitter</a>
                <a href="#" class="text-white me-3">Instagram</a>
                <a href="./admin/index.php?active=dashboard" class="text-white">Admin</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
