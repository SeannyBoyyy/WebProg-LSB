<?php
include('../config/config.php'); // Database connection
?>

<style>
    /* Dashboard Styles */
    .card-custom {
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    /* Header Styles */
    .card-header-custom {
        background: rgba(0, 0, 0, 0.1);
        color: #fff;
        padding: 1rem;
        display: flex;
        align-items: center;
    }

    .card-header-custom .icon {
        font-size: 2.5rem;
        margin-right: 0.75rem;
    }

    /* Footer Styles */
    .card-footer-custom {
        background: rgba(0, 0, 0, 0.05);
        text-align: center;
        font-size: 0.9rem;
        padding: 0.75rem;
    }

    .card-footer-custom a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    /* Colors */
    .card-blue {
        background-color: #007bff;
        color: #fff;
    }

    .card-green {
        background-color: #28a745;
        color: #fff;
    }

    .card-yellow {
        background-color: #ffc107;
        color: #343a40;
    }

    .card-red {
        background-color: #dc3545;
        color: #fff;
    }

    .dashboard-title {
        font-size: 3rem;
        font-weight: bold;
        color: #343a40;
    }

    .row {
        justify-content: center;
    }
</style>
    
<div class="container my-5">
    <h2 class="mb-4 text-center dashboard-title">Dashboard</h2>

    <div class="row">
        <!-- Total Programs Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-custom card-blue">
                <div class="card-header-custom">
                    <i class="fas fa-book icon"></i>
                    <h5 class="m-0">Total Programs</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="totalPrograms">0</h2>
                </div>
                <div class="card-footer-custom">
                    <a href="index.php?active=programs">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Spotlight Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-custom card-green">
                <div class="card-header-custom">
                    <i class="fas fa-star icon"></i>
                    <h5 class="m-0">Total Spotlight</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="totalSpotlight">0</h2>
                </div>
                <div class="card-footer-custom">
                    <a href="index.php?active=spotlight">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Total News Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-custom card-yellow">
                <div class="card-header-custom">
                    <i class="fas fa-newspaper icon"></i>
                    <h5 class="m-0">Total News</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="totalNews">0</h2>
                </div>
                <div class="card-footer-custom">
                    <a href="index.php?active=news">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Merchandise Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-custom card-red">
                <div class="card-header-custom">
                    <i class="fas fa-shopping-bag icon"></i>
                    <h5 class="m-0">Total Merchandise</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="totalMerchandise">0</h2>
                </div>
                <div class="card-footer-custom">
                    <a href="index.php?active=merch">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Events Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-custom card-blue">
                <div class="card-header-custom">
                    <i class="fas fa-calendar-alt icon"></i>
                    <h5 class="m-0">Total Events</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="totalEvents">0</h2>
                </div>
                <div class="card-footer-custom">
                    <a href="index.php?active=events">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-custom card-green">
                <div class="card-header-custom">
                    <i class="fas fa-clock icon"></i>
                    <h5 class="m-0">Upcoming Events</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="upcomingEvents">0</h2>
                </div>
                <div class="card-footer-custom">
                    <a href="index.php?active=events">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Messages Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-custom card-yellow">
                <div class="card-header-custom">
                    <i class="fas fa-envelope icon"></i>
                    <h5 class="m-0">Total Messages</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="totalMessages">0</h2>
                </div>
                <div class="card-footer-custom">
                    <a href="index.php?active=messages">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Registered Users Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-custom card-red">
                <div class="card-header-custom">
                    <i class="fas fa-users icon"></i>
                    <h5 class="m-0">Registered Users</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="registeredUsers">0</h2>
                </div>
                <div class="card-footer-custom">
                    <a href="index.php?active=admins">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Fetch data every 10 seconds and update the dashboard
function fetchDashboardData() {
    fetch('fetch_dashboard_data.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalPrograms').innerText = data.totalPrograms;
            document.getElementById('totalSpotlight').innerText = data.totalSpotlight;
            document.getElementById('totalNews').innerText = data.totalNews;
            document.getElementById('totalMerchandise').innerText = data.totalMerchandise;
            document.getElementById('totalEvents').innerText = data.totalEvents;
            document.getElementById('upcomingEvents').innerText = data.upcomingEvents;
            document.getElementById('totalMessages').innerText = data.totalMessages;
            document.getElementById('registeredUsers').innerText = data.registeredUsers;
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Call fetchDashboardData initially and then every 10 seconds
fetchDashboardData();
setInterval(fetchDashboardData, 10000);
</script>
