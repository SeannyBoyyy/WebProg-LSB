<?php
include('../config/config.php'); // Database connection

// Query counts from each table
$totalPrograms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM programs"))['total'];
$totalSpotlight = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM spotlight"))['total'];
$totalNews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM news"))['total'];
$totalMerchandise = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM merch"))['total'];
$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM events"))['total'];
$upcomingEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM events WHERE event_date >= CURDATE()"))['total'];
$totalMessages = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM messages"))['total'];
$registeredUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM admins"))['total'];
?>

    <style>
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .card-custom .card-body {
            text-align: center;
            padding: 2rem;
        }

        .card-title {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .card-text {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0;
        }

        .icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            color: #007bff;
        }

        .row {
            justify-content: center;
        }

        .dashboard-title {
            font-size: 3rem;
            font-weight: bold;
            color: #343a40;
        }
    </style>


    
        <h2 class="mb-4 text-center dashboard-title">Dashboard</h2>

        <div class="row">
            <!-- Total Programs Card -->
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h5 class="card-title">Total Programs</h5>
                        <h2 class="card-text text-primary"><?php echo $totalPrograms; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Total Spotlight Card -->
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h5 class="card-title">Total Spotlight</h5>
                        <h2 class="card-text text-primary"><?php echo $totalSpotlight; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Total News Card -->
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h5 class="card-title">Total News</h5>
                        <h2 class="card-text text-primary"><?php echo $totalNews; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Total Merchandise Card -->
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h5 class="card-title">Total Merchandise</h5>
                        <h2 class="card-text text-primary"><?php echo $totalMerchandise; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Total Events Card -->
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5 class="card-title">Total Events</h5>
                        <h2 class="card-text text-primary"><?php echo $totalEvents; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Card -->
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5 class="card-title">Upcoming Events</h5>
                        <h2 class="card-text text-primary"><?php echo $upcomingEvents; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Registered Users Card -->
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="card-title">Registered Admins</h5>
                        <h2 class="card-text text-primary"><?php echo $registeredUsers; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Total Messages Card -->
            <div class="col-md-4 mb-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="card-title">Total Messages</h5>
                        <h2 class="card-text text-primary"><?php echo $totalMessages; ?></h2>
                    </div>
                </div>
            </div>
        </div>
