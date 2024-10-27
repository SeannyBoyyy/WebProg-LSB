<?php include('./config/config.php'); 

// Query to retrieve merchandise items
$merch_sql = "SELECT * FROM merch";
$merch_result = $conn->query($merch_sql);

$events_query = "SELECT event_id, title, description, event_date, location, image_url, created_at FROM events";
$events_result = mysqli_query($conn, $events_query);


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
    <title>LSB School E-SPORTS</title>
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
            background-color: #343a40; /* Your desired background color */
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

        /* Footer */
        footer {
            background: #333;
        }

        footer p,
        footer a {
            color: #bbb;
        }

        footer a:hover {
            color: #fff;
            text-decoration: none;
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
                <a class="navbar-brand" href="#">Lyceum of Subic Bay</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#programs">Programs</a></li>
                        <li class="nav-item"><a class="nav-link" href="#spotlight">Spotlight</a></li>
                        <li class="nav-item"><a class="nav-link" href="#news">News</a></li>
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
    <section class="py-5" id="about" style="background: #e9ecef;">
        <div class="container">
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
                    <img src="img/valo_bg.png" alt="Sponsor 1" class="sponsor-logo">
                    <img src="img/valo_bg.png" alt="Sponsor 2" class="sponsor-logo">
                    <img src="img/valo_bg.png" alt="Sponsor 3" class="sponsor-logo">
                    <img src="img/valo_bg.png" alt="Sponsor 4" class="sponsor-logo">
                    <img src="img/valo_bg.png" alt="Sponsor 5" class="sponsor-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-5 bg-light" id="programs" style="background: #f3f4f6;">
        <div class="container">
            <h2 class="text-center section-title">Our Programs</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <img src="img/lsbvarsity_top8.jpg" class="img-fluid" alt="Esports Training Camp">
                </div>
                <div class="col-md-6">
                    <h5>Esports Training Camp</h5>
                    <p>Develop your skills with our specialized training programs.</p>
                    <a href="#" class="btn btn-primary">Inquire Now</a>
                </div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-md-6 order-md-2">
                    <img src="img/lsbvarsity_top8.jpg" class="img-fluid" alt="Tournaments">
                </div>
                <div class="col-md-6">
                    <h5>Tournaments</h5>
                    <p>Join our competitive tournaments and showcase your talent.</p>
                    <a href="#" class="btn btn-primary">Inquire Now</a>
                </div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <img src="img/lsbvarsity_top8.jpg" class="img-fluid" alt="Community Engagement">
                </div>
                <div class="col-md-6">
                    <h5>Community Engagement</h5>
                    <p>Be a part of our community events and workshops.</p>
                    <a href="#" class="btn btn-primary">Inquire Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Spotlight --> 
    <!-- Testimonial Video Carousel Section -->
    <section class="py-5" id="spotlight" style="background: #fff;">
        <div class="container">
            <h2 class="text-center section-title">Student Spotlight</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <p class="text-center" style="max-width: 700px; margin: 0 auto; color: #555;">
                Discover the journeys and achievements of our standout students. These videos showcase the passion, dedication, and success stories of our students, providing a glimpse into their inspiring academic and personal accomplishments.
            </p>
            <div class="position-relative mt-4">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        <!-- First Video Item -->
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-center">
                                <video class="w-75" controls>
                                    <source src="vid/bsba.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="text-center mt-3">
                                <h5>John Doe - BSBA Journey</h5>
                                <p style="color: #555; max-width: 600px; margin: 0 auto;">
                                    John shares his experiences as a Business Administration student, highlighting the challenges and rewards of his academic journey.
                                </p>
                            </div>
                        </div>
                        <!-- Second Video Item -->
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center">
                                <video class="w-75" controls>
                                    <source src="vid/bsba.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="text-center mt-3">
                                <h5>Jane Smith - Computer Science Achievements</h5>
                                <p style="color: #555; max-width: 600px; margin: 0 auto;">
                                    Jane discusses her journey in Computer Science, her achievements in programming, and her aspirations for the future.
                                </p>
                            </div>
                        </div>
                        <!-- Add more carousel items as needed -->
                    </div>
                    
                    <!-- Controls positioned outside the carousel items -->
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
    <section class="py-5 bg-light" id="news" style="background: #eaeaea;">
        <div class="container">
            <h2 class="text-center section-title">Latest News & Stories</h2>
            <div class="section-title-hr"><!-- Underline --></div>
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
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/lsbvarsity_top8.jpg" class="card-img-top" alt="News 1">
                        <div class="card-body">
                            <h5 class="card-title">LSB Wins Regional Championship</h5>
                            <p class="card-text">Our team made a remarkable achievement in the recent championship...</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/lsbvarsity_top8.jpg" class="card-img-top" alt="News 2">
                        <div class="card-body">
                            <h5 class="card-title">Interview with the Coach</h5>
                            <p class="card-text">We sat down with Coach Alex to discuss strategies for the upcoming season...</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/lsbvarsity_top8.jpg" class="card-img-top" alt="News 3">
                        <div class="card-body">
                            <h5 class="card-title">Top 8 and rising! LSB Sharks Delta is making waves in the PCC Tournament. Let's keep the momentum going!
                                </h5>
                            <p class="card-text">
                                To catch up on the latest happenings, updates, and tournaments of LSB Sharks Esports, please follow, like, and share the page.
                                #LSBSharksUnlimited #BeaLycean #NotJustPlay #MLBB #PCC</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Merchandise Section -->
    <section class="py-5" id="merchandise" style="background: #fff;">
        <div class="container">
            <h2 class="text-center section-title">LSB Esports Merchandise</h2>
            <div class="section-title-hr"><!-- Underline --></div>
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
                <a href="merch.php" class="btn btn-primary">View All Merchandise</a>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="py-5 bg-light" id="events" style="background: #f9f9f9;">
        <div class="container">
            <h2 class="text-center section-title">Upcoming Events</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <div class="text-center mb-4">
                <div class="bg-dark text-white py-3 px-4 rounded">
                    <h3>Countdown to LSB Esports Tournament</h3>
                    <p id="countdown" class="fs-3">10 Days, 5 Hours</p>
                    <img src="img/lsbvarsity_top8.jpg" class="img-fluid rounded" alt="LSB Esports Tournament" style="max-width: 100%; height: auto;">
                </div>
            </div>
            <div class="text-center mb-4">
                <a href="#" class="btn btn-primary">View Event Details</a>
            </div>   

            <h3 class="text-center mb-4">Other Events</h3>
            <div class="row">
                <?php while ($event = mysqli_fetch_assoc($events_result)) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./admin/img/<?php echo htmlspecialchars($event['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
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

            <!-- View All Events Button -->
            <div class="text-center mt-4">
                <a href="events.php" class="btn btn-secondary">View All Events</a>
            </div>

        </div>
    </section>


    <!-- Contact Section -->
    <section class="py-5" id="contact" style="background: #e9ecef;">
        <div class="container">
            <h2 class="text-center mb-4 section-title">Contact Us</h2>
            <div class="section-title-hr"></div>
            <div class="row text-center mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-geo-alt fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Address</h5>
                            <p class="card-text">Lyceum of Subic Bay, Zambales, Philippines</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-telephone fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Call Us</h5>
                            <p class="card-text">(+63) 123-456-7890</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-envelope fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Email Us</h5>
                            <p class="card-text">info@lsbesports.ph</p>
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
            <h2 class="mb-4 section-title">Testimonials</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <p class="mb-5">Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
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
                                Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/valo_bg.png" class="testimonial-img mb-3" alt="">
                                <h3>Saul Goodman</h3>
                                <h4 class="text-muted">Ceo &amp; Founder</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/valo_bg.png" class="testimonial-img mb-3" alt="">
                                <h3>Sara Wilsson</h3>
                                <h4 class="text-muted">Designer</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/valo_bg.png" class="testimonial-img mb-3" alt="">
                                <h3>Jena Karlis</h3>
                                <h4 class="text-muted">Store Owner</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/valo_bg.png" class="testimonial-img mb-3" alt="">
                                <h3>Matt Brandon</h3>
                                <h4 class="text-muted">Freelancer</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item border rounded p-4 shadow-sm">
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-3">
                                Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                            </p>
                            <div class="profile mt-auto text-center">
                                <img src="img/valo_bg.png" class="testimonial-img mb-3" alt="">
                                <h3>John Larson</h3>
                                <h4 class="text-muted">Entrepreneur</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section><!-- /Testimonials Section -->

    <?php include('./footer/homepage_footer.php'); ?> 
    
</body>
</html>
