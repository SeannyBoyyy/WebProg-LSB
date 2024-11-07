<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include('../config/config.php'); 

include 'auth.php'; // Check if admin is logged in

// Retrieve active page from query parameter
$activePage = isset($_GET['active']) ? $_GET['active'] : '';

// Define function to add 'active' class to the button
function isActive($page, $activePage) {
    return $page === $activePage ? 'active' : '';
}

// Retrieve active page from query parameter
$activePage = isset($_GET['active']) ? $_GET['active'] : '';

// Define function to add 'active' class to the button
function isShowActive($page, $activePage) {
        return $page === $activePage ? 'show active' : '';
}

?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LSB Esports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: #f4f7fa;
        }
        .sidebar {
            background: #343a40;
            min-height: 100vh;
            padding: 20px;
        }
        .sidebar .nav-link {
            color: #ffffff;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: #495057;
            border-radius: 5px;
        }
        .navbar-custom {
            background: #007bff;
        }
        .navbar-brand {
            color: #ffffff;
        }
        .card-custom {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="d-flex">
        <div class="sidebar">
            <h2 class="text-white">Admin Panel</h2>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('dashboard', $activePage); ?>" data-bs-toggle="pill" href="#dashboard">
                        <i class="bi bi-house-door-fill me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('programs', $activePage); ?>" data-bs-toggle="pill" href="#programs">
                        <i class="bi bi-gear-fill me-2"></i>Manage Programs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('spotlight', $activePage); ?>" data-bs-toggle="pill" href="#spotlight">
                        <i class="bi bi-star-fill me-2"></i>Manage Spotlight
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('news', $activePage); ?>" data-bs-toggle="pill" href="#news">
                        <i class="bi bi-newspaper me-2"></i>Manage News
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('merch', $activePage); ?>" data-bs-toggle="pill" href="#merch">
                        <i class="bi bi-basket-fill me-2"></i>Manage Merchandise
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('events', $activePage); ?>" data-bs-toggle="pill" href="#events">
                        <i class="bi bi-calendar-event me-2"></i>Manage Events
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('messages', $activePage); ?>" data-bs-toggle="pill" href="#messages">
                        <i class="bi bi-chat-left-text-fill me-2"></i>Messages
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-custom">
                <div class="container-fluid">
                    <a class="navbar-brand" href="../index.php">LSB Esports Admin</a>
                </div>
            </nav>

            <!-- Tab Content -->
            <div class="container mt-4">
                <div class="tab-content">
                    <!-- Dashboard Tab -->
                    <div id="dashboard" class="tab-pane fade <?php echo isShowActive('dashboard', $activePage); ?>">
                        <?php include('./dashboard.php');?>
                    </div>

                    <!-- Manage Programs Tab -->
                    <div id="programs" class="tab-pane fade <?php echo isShowActive('programs', $activePage); ?>">
                        <div class="container mt-4">
                            <?php include('./manage_programs.php');?>
                        </div>
                    </div>

                    <!-- Manage Spotlight Tab -->
                    <div id="spotlight" class="tab-pane fade <?php echo isShowActive('spotlight', $activePage); ?>">
                        <div class="container mt-4">
                            <?php include('./manage_spotlight.php');?>
                        </div>
                    </div>

                    <!-- Manage News Tab -->
                    <div id="news" class="tab-pane fade <?php echo isShowActive('news', $activePage); ?>">
                        <div class="container mt-4">
                            <?php include('./manage_news.php');?>
                        </div>
                    </div>

                    <!-- Manage Merchandise Tab -->
                    <div id="merch" class="tab-pane fade <?php echo isShowActive('merch', $activePage); ?>">
                        <div class="container mt-4">
                            <?php include('./manage_merch.php');?>
                        </div>
                    </div>

                    <!-- Manage Events Tab -->
                    <div id="events" class="tab-pane fade <?php echo isShowActive('events', $activePage); ?>">
                        <div class="container mt-4">
                            <?php include('./manage_events.php');?>
                        </div>
                    </div>

                    <!-- Messages Tab -->
                    <div id="messages" class="tab-pane fade <?php echo isShowActive('messages', $activePage); ?>">
                        <div class="container mt-4">
                            <?php include('./manage_messages.php');?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
