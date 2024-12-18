<?php include('./config/config.php'); 

// Query to retrieve merchandise items
$merch_sql = "SELECT * FROM merch ORDER BY merch_id DESC";
$merch_result = $conn->query($merch_sql);

// Fetch the event
$events_query = "SELECT event_id, title, description, event_date, location, image_url, created_at FROM events ORDER BY event_id DESC LIMIT 4";
$events_result = mysqli_query($conn, $events_query);

// Fetch the featured event
$query = "SELECT * FROM events WHERE category = 1 LIMIT 1";
$featured_result = mysqli_query($conn, $query);
$featured_event = mysqli_fetch_assoc($featured_result);

// Fetch latest news from the database
$sqlNews = "SELECT * FROM news WHERE category = 'General' ORDER BY news_id DESC LIMIT 4";
$resultNews = $conn->query($sqlNews);

// Query to retrieve College programs
$sqlCollege = "SELECT program_id, title, description, image_url, created_at, category FROM programs WHERE category = 'College' ORDER BY program_id DESC LIMIT 3";
$resultCollege = $conn->query($sqlCollege);

// Query to retrieve Senior High programs
$sqlSeniorHigh = "SELECT program_id, title, description, image_url, created_at, category FROM programs WHERE category = 'Senior High' ORDER BY program_id DESC LIMIT 3";
$resultSeniorHigh = $conn->query($sqlSeniorHigh);
// Contact Us
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $sent_at = date('Y-m-d H:i:s');

    // Insert message into the database
    $sql = "INSERT INTO messages (name, email, subject, message, sent_at) VALUES ('$name', '$email', '$subject', '$message', '$sent_at')";
    
    if (mysqli_query($conn, $sql)) {
        // Success: Show SweetAlert
        echo "
        ...
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Your message has been sent successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'index.php';
            });
        </script>";
    } else {
        echo "...
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        // Error: Show SweetAlert
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'There was an error sending your message. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'index.php';
            });
        </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSB School & E-SPORTS</title>
    <!-- Logo CSS -->
    <link rel="icon" type="image/x-icon" href="img/lsb_png.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Oswald:wght@500&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    

    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand, .nav-link, h1, h2, h3, h5 {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
        }
        .section-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
        }

        .btn-primary:hover {
            background-color: #004494;
        }

        /* Navbar */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            transition: background-color 0.3s ease;
            z-index: 1000;
        }

        .header.scrolled {
            background-color: #301934; /* Your desired background color */
        }

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

        /* Section Title */
        /* HR Design */
        .section-title {
            font-weight: bold;
            margin-bottom: 0.5rem; /* Adjust the spacing between the title and the line */
        }

        .section-title-hr {
            border-bottom: 5px solid #ffdd57; /* Optional: Add an underline for active state */
            width: 100px; /* Adjust the width of the HR line */
            margin: 0 auto; /* Center the HR below the title */
            margin-bottom: 25px;
        }

        /* About Me */
        /* CSS for the Sponsor Hover Effect */
        .sponsor-logo {
            width: 100%;
            max-width: 100px;
            filter: grayscale(100%);
            transition: filter 0.3s ease;
        }

        .sponsor-logo:hover {
            filter: grayscale(0%);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/valo_bg.png') no-repeat center center/cover;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 20px auto;
        }

        .hero .btn {
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 1rem;
        }

        /* Card Styles */
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        /* Carousel Styles */
        .spotlight-carousel img {
            max-height: 350px;
            object-fit: cover;
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.6);
            padding: 10px;
            border-radius: 10px;
        }

        /* Testimonial */
        .testimonial-item {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .stars {
            color: #f39c12;
        }

        /* Show dropdown on hover */
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Add a smooth transition for dropdown appearance */
        .dropdown-menu {
            transition: all 0.3s ease;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }

    </style>
</head>
<body>
    <!-- Header -->
    <header id="navbar" class="header py-3">
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
                            <a class="nav-link dropdown-toggle" href="#programs" id="programsDropdown" role="button" aria-expanded="false">
                                Programs
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="programsDropdown">
                                <li><a class="dropdown-item" href="overview.php">Overview</a></li>
                                <li><a class="dropdown-item" href="senior_high.php">Senior High</a></li>
                                <li><a class="dropdown-item" href="college.php">College</a></li>
                            </ul>
                        </li>
                        <!-- Other Navbar Items -->
                        <li class="nav-item"><a class="nav-link" href="#news">News & Spotlight</a></li>
                        <li class="nav-item"><a class="nav-link" href="#merchandise">Merchandise</a></li>
                        <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>


    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Discover the Highlights of <br> Lyceum of Subic Bay</h1>
            <p>Stay updated with the latest news, events, and achievements from across our campus, including esports and other school activities.</p>
            <a href="#programs" class="btn btn-primary">Explore Now</a>
        </div>
    </section>


    <!-- About Section -->
    <section class="" id="about" style="background: #e9ecef;">
        <div class="container py-5">
            <h2 class="text-center section-title">About LSB Esports</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <p class="text-center mb-5">
                Lyceum of Subic Bay is dedicated to advancing esports, showcasing the achievements and talents of our players through competitions and events.
            </p>

            <div class="row align-items-center">
                <!-- Mission and Vision Section -->
                <div class="col-md-6 p-5">
                    <h5>Our Mission</h5>
                    <p>
                        To empower the Lyceum of Subic Bay's esports community by providing an engaging and informative online platform that showcases our achievements, promotes our 
                        programs, and connects students, alumni, and sponsors. We strive to enhance awareness of esports as a vital part of student life and to foster a supportive 
                        environment for aspiring players.
                    </p>
                    <h5>Our Vision</h5>
                    <p>
                        To be the leading esports marketing platform for educational institutions, recognized for our commitment to excellence in promoting student achievements, 
                        fostering community engagement, and inspiring future generations of esports athletes. We envision a vibrant community where every player has the opportunity 
                        to shine and contribute to the dynamic world of esports.
                    </p>
                    <div class="mt-4">
                        <a href="#" class="btn btn-primary">Learn More</a>
                    </div>
                </div>

                <!-- Image Section -->
                <div class="col-md-6">
                    <img src="img/valo_bg.png" alt="LSB Esports" class="img-fluid rounded">
                </div>
            </div>

            <!-- Sponsors Section -->
            <div class="text-center mt-5">
                <h6>Our Sponsors</h6>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <img src="img/acad_logo.png" alt="Sponsor 1" class="sponsor-logo">
                    <img src="img/lsb_png.png" alt="Sponsor 2" class="sponsor-logo">
                    <img src="img/prc_logo.png" alt="Sponsor 3" class="sponsor-logo">
                    <img src="img/vortex_logo.jpg" alt="Sponsor 4" class="sponsor-logo">
                    <img src="img/Lsb_logo.jpg" alt="Sponsor 5" class="sponsor-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="" id="programs" style="background: #f3f4f6;">
        <div class="container py-5">
            <!-- Introduction -->
            <h2 class="section-title d-flex align-items-center justify-content-between" style="font-size: 2.5rem; font-weight: bold;">
                School Related Programs
                <a href="overview.php" class="see-more-link text-primary text-decoration-none" style="font-size: 1rem; font-weight: normal;">See More →</a>
            </h2>
            <p class="mb-5" style="font-size: 1.2rem;">
                Discover a variety of academic and extracurricular programs at LSB that empower students to excel both in the classroom and beyond. From cutting-edge courses to engaging student activities, there's something for everyone!
            </p>

            <!-- College Programs -->
            <h3 class="text-center section-title mt-5 mb-4">College Programs</h3>
            <div class="section-title-hr"></div>

            <div class="row">
                <?php
                if ($resultCollege->num_rows > 0) {
                    while ($row = $resultCollege->fetch_assoc()) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="./admin/img/<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                <div class="card-body">
                                    <span class="badge bg-primary">College</span>
                                    <h5 class="card-title mt-2"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($row['description'], 0, 135)) . '...'; ?>
                                    <button type="button" class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#programModal<?php echo $row['program_id']; ?>">
                                        Read More
                                    </button>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for program details -->
                        <div class="modal fade" id="programModal<?php echo $row['program_id']; ?>" tabindex="-1" aria-labelledby="programModalLabel<?php echo $row['program_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="programModalLabel<?php echo $row['program_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="./admin/img/<?php echo $row['image_url']; ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                        <div>    
                                            <span class="badge bg-primary">College</span>
                                        </div>
                                        <p class="mt-3"><?php echo htmlspecialchars($row['description']); ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No college programs available.</p>";
                }
                ?>
            </div>

            <!-- Senior High Programs -->
            <h3 class="text-center section-title mt-5 mb-4">Senior High Programs</h3>
            <div class="section-title-hr"></div>

            <div class="row">
                <?php
                if ($resultSeniorHigh->num_rows > 0) {
                    while ($row = $resultSeniorHigh->fetch_assoc()) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="./admin/img/<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                <div class="card-body">
                                    <span class="badge bg-secondary">Senior High</span>
                                    <h5 class="card-title mt-2"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($row['description'], 0, 135)) . '...'; ?>
                                    <button type="button" class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#programModal<?php echo $row['program_id']; ?>">
                                        Read More
                                    </button>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for program details -->
                        <div class="modal fade" id="programModal<?php echo $row['program_id']; ?>" tabindex="-1" aria-labelledby="programModalLabel<?php echo $row['program_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="programModalLabel<?php echo $row['program_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="./admin/img/<?php echo $row['image_url']; ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                        <div>
                                            <span class="badge bg-secondary">Senior High</span>
                                        </div>
                                        <p class="mt-3"><?php echo htmlspecialchars($row['description']); ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No senior high programs available.</p>";
                }
                ?>
            </div>
            <!-- View All Programs Button -->
            <p class="text-center mt-3">To View All The Programs - Read All The Programs </p>
            <div class="text-center">
                <a href="overview.php" class="btn btn-secondary">View All Programs</a>
            </div>
        </div>
    </section>



    <!-- Spotlight --> 
    <!-- Testimonial Video Carousel Section -->
    <section class="" id="news" style="background: #fff;">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-5"></div> <!-- Empty column for spacing -->
                <div class="col-md-7 d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title mb-0">Spotlights</h2> <!-- Remove extra margin from h2 -->
                    <h2 class="section-title">
                        <a href="news.php" class="see-more-link text-primary text-decoration-none" style="font-size: 1rem; font-weight: normal;">See More →</a>
                    </h2>
                </div>
                
                <div class="col-12">
                    <div class="section-title-hr"><!-- Underline --></div>
                </div>
            </div>
            <p class="text-center" style="max-width: 700px; margin: 0 auto; color: #555;">
                Discover the journeys and achievements of our standout students. These videos showcase the passion, dedication, and success stories of our students, providing a glimpse into their inspiring academic and personal accomplishments.
            </p>
            
            <div class="position-relative mt-4">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        
                        <?php
                        // Fetch spotlight records from the database
                        $resultSpotlight = mysqli_query($conn, "SELECT title, description, video_url FROM spotlight ORDER BY spotlight_id DESC");
                        $isActive = true; // Flag to set the first carousel item as active
                        
                        while ($row = mysqli_fetch_assoc($resultSpotlight)) {
                            $activeClass = $isActive ? 'active' : ''; // Add 'active' class only for the first item
                            $isActive = false; // Set flag to false after first item
                        ?>
                        
                        <!-- Spotlight Video Item -->
                        <div class="carousel-item <?php echo $activeClass; ?>">
                            <div class="d-flex justify-content-center">
                                <video class="w-75" controls>
                                    <source src="./admin/vid/<?php echo htmlspecialchars($row['video_url']); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="text-center mt-3">
                                <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p style="color: #555; max-width: 600px; margin: 0 auto;">
                                    <?php echo htmlspecialchars($row['description']); ?>
                                </p>
                            </div>
                        </div>
                        
                        <?php } ?>
                        
                    </div>
                    
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev position-absolute start-0 top-50 translate-middle-y bg-black" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev" style="transform: translateX(-50%);">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next position-absolute end-0 top-50 translate-middle-y bg-black" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next" style="transform: translateX(50%);">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!-- News & Stories Section -->
    <section class="" id="news" style="background: #eaeaea;">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4"></div> <!-- Empty column for spacing -->
                <div class="col-md-8 d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title mb-0">Latest News And Stories</h2> <!-- Remove extra margin from h2 -->
                    <h2 class="section-title">
                        <a href="news.php" class="see-more-link text-primary text-decoration-none" style="font-size: 1rem; font-weight: normal;">See More →</a>
                    </h2>
                </div>
                
                <div class="col-12">
                    <div class="section-title-hr"><!-- Underline --></div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-md-12">
                    <div class="card">
                        <img src="img/valo_bg.png" class="img-fluid" alt="News 1" style="height: 700px;">
                        <div class="card-body">
                            <h5 class="card-title">Latest News and Stories</h5>
                            <p class="card-text">Welcome to the Latest News and Stories section, where we bring you the most exciting updates from the Lyceum of Subic Bay's 
                                esports community! Here, you will find the latest achievements, event highlights, and inspiring stories from our talented players, alumni, and coaches. 
                                Stay informed about upcoming tournaments, program developments, and community initiatives that celebrate our esports journey. Whether you’re a current 
                                student, an alumnus, or an esports enthusiast, our stories aim to inspire, engage, and connect you with the vibrant world of esports at LSB. Join us as 
                                we showcase the dedication and passion of our players and the milestones that make our community truly exceptional!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-5">
                <div class="row latest-news">
                    <?php
                    if ($resultNews->num_rows > 0) {
                        // Output each news item
                        while ($row = $resultNews->fetch_assoc()) {
                            // Construct the image path
                            $image_path = $row['image_url'] ? './admin/img/' . $row['image_url'] : 'https://via.placeholder.com/150';
                            $title = htmlspecialchars($row['title']);
                            $author = htmlspecialchars($row['author']);
                            $published_date = htmlspecialchars($row['published_date']);
                            $category = htmlspecialchars($row['category']);
                            $content = htmlspecialchars($row['content']);
                            $full_content = htmlspecialchars($row['content']); // Full content for modal

                            // Generate a unique ID for each modal
                            $modal_id = "newsModal" . $row['news_id'];
                    ?>
                            <!-- News Card -->
                            <div class="col-md-3 mb-3">
                                <div class="card h-100" style="border: none;">
                                    <img src="<?php echo $image_path; ?>" class="card-img-top" alt="News Image" style="object-fit: cover; height: 200px;">
                                    <div class="card-body d-flex flex-column">
                                        <p class="text-muted"><?php echo $author; ?> • <?php echo $published_date; ?></p>
                                        <h5 class="card-title"><?php echo $title; ?></h5>
                                        <p class="text-muted"><?php echo $category; ?> • <?php echo substr($content, 0, 45); ?>
                                        <a type="button" class="btn-link" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>">See more...</a> </p><!-- See more button to trigger modal -->
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for displaying full news content -->
                            <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="<?php echo $modal_id; ?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="<?php echo $modal_id; ?>Label"><?php echo $title; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php echo $image_path; ?>" class="img-fluid mb-3" alt="News Image" style="object-fit: cover; width: 100%; height: 300px;">
                                            <p><strong>Author:</strong> <?php echo $author; ?></p>
                                            <p><strong>Published:</strong> <?php echo $published_date; ?></p>
                                            <p><strong>Category:</strong> <?php echo $category; ?></p>
                                            <p><strong>Content:</strong> <?php echo $full_content; ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>No news available.</p>";
                    }
                    ?>
                </div>
            </div>

            <p class="text-center mt-3">To View All The News, Stories and Spotlight - Read All The News, Stories, Spotlight and Participate</p>
            <div class="text-center">
                <a href="events.php" class="btn btn-secondary">View All Events</a>
            </div>
        </div>
    </section>

    <!-- Merchandise Section -->
    <section class="" id="merchandise" style="background: #fff;">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4"></div> <!-- Empty column for spacing -->
                <div class="col-md-8 d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title mb-0">LSB Esports Merchandise</h2> <!-- Remove extra margin from h2 -->
                    <h2 class="section-title">
                        <a href="merch.php" class="see-more-link text-primary text-decoration-none" style="font-size: 1rem; font-weight: normal;">See More →</a>
                    </h2>
                </div>
                
                <div class="col-12">
                    <div class="section-title-hr"><!-- Underline --></div>
                </div>
            </div>
            
            <div class="row my-5">
                <div class="col-md-12">
                    <div class="card">
                        <img src="img/merch_prev.jpg" class="img-fluid" alt="Jersey">
                        <div class="card-body">
                            <h5 class="card-title">MERCH SALE!!!</h5>
                            <p class="card-text">Level up your esports game with LSB Sharks Unlimited's exclusive 2023 merch drop! Elevate your style in our top-tier Jersey priced 
                                at just 700 PHP, or make a splash with the LSB Lanyard for only 150 PHP. But wait, there's more! Seize the ultimate power play by grabbing the 
                                unbeatable package – a premium membership, our coveted Jersey, and the stylish Lanyard for an unbeatable 850 PHP! Gear up, game on, and make every 
                                match a victory with LSB Sharks Unlimited! Don't miss out, it's time to conquer the gaming world!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <?php
                if ($merch_result->num_rows > 0) {
                    // Loop through each item
                    while ($row = $merch_result->fetch_assoc()) {
                        // Display card for each item
                        echo '
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="./admin/img/' . $row['image_url'] . '" class="card-img-top" alt="' . $row['name'] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row['name'] . '</h5>
                                    <p class="card-text">Price: ₱' . $row['price'] . '</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itemModal' . $row['merch_id'] . '">View Details</button>
                                </div>
                            </div>
                        </div>';

                        // Modal for each item
                        echo '
                        <div class="modal fade" id="itemModal' . $row['merch_id'] . '" tabindex="-1" aria-labelledby="itemModalLabel' . $row['merch_id'] . '" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="itemModalLabel' . $row['merch_id'] . '">' . $row['name'] . '</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="./admin/img/' . $row['image_url'] . '" class="img-fluid mb-3" alt="' . $row['name'] . '">
                                        <p><strong>Description:</strong> ' . $row['description'] . '</p>
                                        <p><strong>Price:</strong> ₱' . $row['price'] . '</p>
                                        <p><strong>Stock Available:</strong> ' . $row['stock_quantity'] . '</p>
                                        <p class="card-text"><small class="text-muted">Posted on: ' . date("F j, Y", strtotime($row['created_at'])) . '</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p class="text-center">No merchandise items available at the moment.</p>';
                }
                ?>
            <p class="text-center mt-3">Promotional Purposes Only - No Online Transactions</p>
            <div class="text-center">
                <a href="merch.php" class="btn btn-secondary">View All Merchandise</a>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="" id="events" style="background: #f9f9f9;">
        <div class="container py-5">
        <!-- Introduction -->
        <h2 class="section-title d-flex align-items-center justify-content-between" style="font-size: 2.5rem; font-weight: bold;">
            Upcoming Events
            <a href="events.php" class="see-more-link text-primary text-decoration-none" style="font-size: 1rem; font-weight: normal;">See More →</a>
        </h2>
        <p class="mb-5" style="font-size: 1.2rem;">
            Join us for exciting events showcasing incredible talents, inspiring experiences, and opportunities to connect. Explore our featured and upcoming events below, and don’t miss out on a chance to participate!
        </p>

            <div class="row">
                <!-- Featured Event Column -->
                <div class="col-lg-6 mb-4">
                    <h3 class="section-title text-center">Featured</h3>
                    <div class="section-title-hr"></div>
                    <?php if ($featured_event): ?>
                        <div class="bg-dark text-white p-4 rounded">
                            <h2 style="font-size: 2rem; font-weight: bold;"><?php echo htmlspecialchars($featured_event['title']); ?></h2>
                            <p class="text-uppercase mb-4" style="color: #a0c334;">Now You Can Watch the Talent</p>
                            <div id="countdown" class="fs-1 mb-3" style="font-weight: bold;"></div>
                            <a href="#featured-event" class="btn btn-success btn-lg mb-4" style="background-color: #a0c334; border-color: #a0c334;">Start In</a>
                            <p><strong>Date:</strong> <?php echo date('F j - F j, Y', strtotime($featured_event['event_date'])); ?></p>
                            <p><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($featured_event['location']); ?></p>
                            <img src="./admin/img/<?php echo $featured_event['image_url']; ?>" class="img-fluid img-thumbnail mb-3" alt="Featured Image" style="max-width: 100%;">
                        </div>
                    <?php else: ?>
                        <p>No featured event at the moment.</p>
                    <?php endif; ?>
                </div>

                <!-- Other Events Column -->
                <div class="col-lg-6">
                    <h3 class="section-title text-center">Others</h3>
                    <div class="section-title-hr"></div>
                    <div class="row">
                        <?php while ($event = mysqli_fetch_assoc($events_result)) : ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <img src="./admin/img/<?php echo htmlspecialchars($event['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                                    <p class="card-text">
                                        <?php 
                                            $description = htmlspecialchars($event['description']);
                                            $truncatedDescription = (strlen($description) > 70) ? substr($description, 0, 70) . '...' : $description;
                                        ?>
                                        <span class="short-text"><?php echo $truncatedDescription; ?></span>
                                        <span class="full-text d-none"><?php echo $description; ?></span>
                                        <?php if (strlen($description) > 60) : ?>
                                            <a class="see-more text-secondary text-decoration-none"></a>
                                        <?php endif; ?>
                                    </p>
                                    <p class="card-text"><small class="text-muted">Date: <?php echo htmlspecialchars($event['event_date']); ?></small></p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal<?php echo $event['event_id']; ?>">View Details</button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for each event -->
                        <div class="modal fade" id="eventModal<?php echo $event['event_id']; ?>" tabindex="-1" aria-labelledby="eventModalLabel<?php echo $event['event_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="eventModalLabel<?php echo $event['event_id']; ?>"><?php echo htmlspecialchars($event['title']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="./admin/img/<?php echo htmlspecialchars($event['image_url']); ?>" class="img-fluid mb-3" alt="Event Image">
                                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                                        <p><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
                                        <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                                        <p><small class="text-muted"><strong>Posted on:</strong> <?php echo htmlspecialchars(date("F j, Y", strtotime($event['created_at']))); ?></small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <!-- View All Events Button -->
            <p class="text-center mt-3">To View All The Event - Read All The Event and Participate</p>
            <div class="text-center">
                <a href="events.php" class="btn btn-secondary">View All Events</a>
            </div>
        </div>
    </section>


    <!-- Contact Section -->
    <section class="" id="contact" style="background: #e9ecef;">
        <div class="container py-5">
            <h2 class="text-center mb-4 section-title">Contact Us</h2>
            <div class="section-title-hr"></div>
            <div class="row text-center mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-geo-alt fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Address</h5>
                            <p class="card-text">73 Rizal Hwy, Central Business District, Subic Bay Freeport Zone, Zambales</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-telephone fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Call Us</h5>
                            <p class="card-text">(047) 252 5940 , <br> 09285020242
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-envelope fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Email Us</h5>
                            <p class="card-text">lyceumsubicbay@lsb.edu.ph , <br> info@lsb.edu.ph</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <iframe 
                            src="https://maps.google.com/maps?q=lyceum%20of%20subic%20bay&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                            width="100%" 
                            height="400" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" name="message" id="message" rows="4" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section light-background py-5">
        <!-- Section Title -->
        <div class="container text-center" data-aos="fade-up">
            <h2 class="mb-4 section-title">Messages</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <p class="mb-5">The message of executives is for all students who have a dream.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": "auto",
                    "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                    },
                    "breakpoints": {
                        "320": {
                        "slidesPerView": 1,
                        "spaceBetween": 40
                        },
                        "768": {
                        "slidesPerView": 2,
                        "spaceBetween": 20
                        },
                        "1200": {
                        "slidesPerView": 3,
                        "spaceBetween": 30
                        }
                    }
                    }
                </script>
                <div class="swiper-wrapper pb-5">

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                Master in Public Mgmt. (ip)<br>
                                Bachelor of Laws<br>
                                Bachelor in Political Science
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/randy.jpg" class="testimonial-img mb-3" alt="">
                                <h3>Mr. Randy L. Baguling</h3>
                                <h4 class="text-muted">Asst. Research Director</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                It is with pride, that I congratulate the men and women behind the “debut” publication of the Lyceum of Subic Bay Inc. (LSBI)’s Research Journal. With Mr. Roel B. Dimalanta as Research Director, in his concurrent position as Head of the Office of Student Affairs and Services (OSAS) on the lead, this accomplishment is no mean feat. A major development, the Journal shall now provide a venue for both the faculty members and students’ research outputs.
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/vp.jpg" class="testimonial-img mb-3" alt="">
                                <h3>DR. DIENA B. OROCEO</h3>
                                <h4 class="text-muted">VP for Academic Affairs</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                It is a fact that progress and development in the various fields of endeavor, came about because of studies and research conducted by concerned individuals. Higher Education Institutions (HEIs), like Lyceum of Subic Bay, Inc. (LSBI) therefore, is duty-bound to hone their students’ knowledge, skills and abilities to search and discover answers to certain unknowns. Through this maiden issue of the school’s publication of the Online Research Journal, interested Lyceans will now be able to put to use their writing and investigative skills, to find something new to innovative or improve on something already existing.
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/ceo.jpg" class="testimonial-img mb-3" alt="">
                                <h3>ALFONSO E. BORDA</h3>
                                <h4 class="text-muted">President/CEO</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                Doctor in Philosophy major in Educational Mgmt.(ip)<br>
                                MA major in Educational Administration<br>
                                BA major in English
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/roel.jpg" class="testimonial-img mb-3" alt="">
                                <h3>Mr. Roel B. Dimalanta</h3>
                                <h4 class="text-muted">Research Director</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                • Engineering Programs • Architecture<br>
                                • Business Administration • Information Technology<br>
                                • Accountancy • Customs Administration <br>
                                • Hospitality Management • Tourism<br>
                                • Psychology • Criminology<br>
                                <br>
                                • College Librarian • MIS Coordinator<br>
                                • Guidance Counselor • Asst. to the HR Manager
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/2.png" class="testimonial-img mb-3" alt="">
                                <h3>Representatives</h3>
                                <h4 class="text-muted">Department &amp Secretariat</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section><!-- /Testimonials Section -->
    
    <!-- Chatbot Section -->
    <script>
        window.embeddedChatbotConfig = {
        chatbotId: "U5QHg3tK3ESsfMbpbLEWt",
        domain: "www.chatbase.co"
        }
        </script>
        <script
        src="https://www.chatbase.co/embed.min.js"
        chatbotId="U5QHg3tK3ESsfMbpbLEWt"
        domain="www.chatbase.co"
        defer>
    </script><!-- /Chatbot Section -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($featured_event): ?>
                const eventDate = new Date("<?php echo $featured_event['event_date']; ?>").getTime();

                function updateCountdown() {
                    const now = new Date().getTime();
                    const timeLeft = eventDate - now;

                    if (timeLeft > 0) {
                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        document.getElementById("countdown").innerHTML =
                            `${days} Days : ${hours} Hours : ${minutes} Minutes : ${seconds} Seconds`;
                    } else {
                        document.getElementById("countdown").innerHTML = "Event has started!";
                    }
                }

                setInterval(updateCountdown, 1000);
            <?php endif; ?>
        });
    </script>

    <?php include('./footer/homepage_footer.php'); ?> 
    
</body>
</html>
