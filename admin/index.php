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
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Oswald:wght@500&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Navbar */
        .header {
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .navbar-dark .navbar-nav .nav-link {
            color: white;
            transition: color 0.3s ease;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffdd57;
        }
        .navbar-dark .navbar-nav .nav-link.active {
            color: #ffdd57;
            font-weight: bold;
            border-bottom: 2px solid #ffdd57;
        }
        .navbar-brand, .nav-link {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
        }
        /* Sidebar */
        #sidebar .nav-link {
            color: white;
            transition: all 0.3s ease;
        }
        #sidebar .nav-link:hover {
            background-color: #495057;
            color: #ffdd57;
        }
        #sidebar .nav-link.active {
            background-color: #495057;
            color: #ffdd57;
        }
        #sidebar {
            padding-top: 20px;
            padding-bottom: 20px;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <header id="navbar" class="header py-3" style="background-color: #301934;">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="../index.php">Lyceum of Subic Bay</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#programs">Programs</a></li>
                        <li class="nav-item"><a class="nav-link" href="../news.php">Spotlight</a></li>
                        <li class="nav-item"><a class="nav-link" href="../news.php">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="../merch.php">Merchandise</a></li>
                        <li class="nav-item"><a class="nav-link" href="../events.php">Events</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4 col-sm-12 p-4 bg-dark" id="sidebar">
                <div class="text-center mb-3">
                    <img src="../img/Lsb_logo.jpg" alt="Admin Icon" class="img-fluid img-thumbnail rounded-circle" style="height: 150px; width:150px;">
                    <h1 class="text-white pt-2" style="font-family: 'Oswald', sans-serif; text-transform: uppercase;">___Admin Panel___</h1>
                </div>

                <!-- Sidebar Menu -->
                <div class="nav flex-column nav-pills">
                    <button class="nav-link <?php echo isActive('dashboard', $activePage); ?>" data-bs-toggle="pill" data-bs-target="#v-pills-home">
                        <i class="bi bi-house-door-fill me-2"></i>Dashboard
                    </button>
                    <button class="nav-link <?php echo isActive('programs', $activePage); ?>" data-bs-toggle="pill" data-bs-target="#v-pills-programs">
                        <i class="bi bi-gear-fill me-2"></i>Manage Programs
                    </button>
                    <button class="nav-link <?php echo isActive('spotlight', $activePage); ?>" data-bs-toggle="pill" data-bs-target="#v-pills-spotlight">
                        <i class="bi bi-star-fill me-2"></i>Manage Spotlight
                    </button>
                    <button class="nav-link <?php echo isActive('news', $activePage); ?>" data-bs-toggle="pill" data-bs-target="#v-pills-news">
                        <i class="bi bi-newspaper me-2"></i>Manage News
                    </button>
                    <button class="nav-link <?php echo isActive('events', $activePage); ?>" data-bs-toggle="pill" data-bs-target="#v-pills-events">
                        <i class="bi bi-calendar-event me-2"></i>Manage Events
                    </button>
                    <button class="nav-link <?php echo isActive('merch', $activePage); ?>" data-bs-toggle="pill" data-bs-target="#v-pills-merch">
                        <i class="bi bi-basket-fill me-2"></i> Manage Merchandise
                    </button>
                    <button class="nav-link <?php echo isActive('messages', $activePage); ?>" data-bs-toggle="pill" data-bs-target="#v-pills-messages">
                        <i class="bi bi-chat-left-text-fill me-2"></i>Messages
                    </button>
                    <button class="nav-link">
                        <a class="text-white" style="text-decoration: none;" href="./logout.php">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </button>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9 col-md-8 col-sm-12" id="main-content" style="background-color: whitesmoke;">
                <div class="tab-content">
                    <div class="tab-pane <?php echo isShowActive('dashboard', $activePage); ?>" id="v-pills-home">
                        <div class="container my-4">
                            <?php include('dashboard.php'); ?>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo isShowActive('programs', $activePage); ?>" id="v-pills-programs">
                        <div class="container my-4">
                            <?php include('manage_programs.php'); ?>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo isShowActive('spotlight', $activePage); ?>" id="v-pills-spotlight">
                        <div class="container my-4">
                            <?php include('manage_spotlight.php'); ?>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo isShowActive('news', $activePage); ?>" id="v-pills-news">
                        <div class="container my-4">
                            <?php include('manage_news.php'); ?>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo isShowActive('events', $activePage); ?>" id="v-pills-events">
                        <div class="container my-4">
                            <?php include('manage_events.php'); ?>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo isShowActive('merch', $activePage); ?>" id="v-pills-merch">
                        <div class="container my-4">
                            <?php include('manage_merch.php'); ?>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo isShowActive('messages', $activePage); ?>" id="v-pills-messages">
                        <div class="container my-4">
                            <?php include('manage_messages.php'); ?>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
