<?php include('./config/config.php'); 

// Regular merchandise
// Query to retrieve merchandise items
$merch_sql = "SELECT * FROM merch WHERE category = 'regular'";
$result = $conn->query($merch_sql);

// Featured merchandise
$queryFeatured = "SELECT * FROM merch WHERE category = 'featured'";
$resultFeatured = mysqli_query($conn, $queryFeatured);


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
                window.location = 'news.php';
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
                window.location = 'news.php';
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
    <title>LSB Merchandise</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/merch_prev.jpg') no-repeat center center/cover;
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
                        <li class="nav-item"><a class="nav-link active" href="merch.php">Merchandise</a></li>
                        <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>


    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Discover the Merchandise of <br> Lyceum of Subic Bay</h1>
            <p>Explore the latest merchandise from LSB, including jerseys, hoodies, caps, and more, designed to keep you connected to the campus spirit. Check out special offers and exclusive bundles for LSB students and fans!</p>
            <a href="#programs" class="btn btn-primary">Explore Now</a>
        </div>
    </section>

    <!-- Features Section - Carousel -->
    <section class="py-5" id="features" style="background: #e9ecef;">
        <div class="container">
            <h2 class="text-center section-title">Featured</h2>
            <div class="section-title-hr mb-4"></div>

            <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner p-5">

                    <?php
                    $isActive = true;
                    while ($row = mysqli_fetch_assoc($resultFeatured)) {
                        $activeClass = $isActive ? 'active' : '';
                        $isActive = false;
                        ?>
                        <div class="carousel-item <?php echo $activeClass; ?>">
                            <div class="row align-items-center">
                                <div class="col-md-6 text-content p-5">
                                    <span class="badge bg-success">Merchandise</span>
                                    <h3 class="fw-bold mt-3"><?php echo htmlspecialchars($row['name']); ?></h3>
                                    <p class="lead"><?php echo htmlspecialchars($row['description']); ?></p>
                                    <div class="additional-info">
                                        <span><i class="bi bi-calendar"></i> <?php echo htmlspecialchars(date('F j, Y', strtotime($row['created_at']))); ?></span>
                                        <br><span><i class="bi bi-bag"></i> <?php echo htmlspecialchars($row['stock_quantity']); ?> in stock</span>
                                        <br><span><i class="bi bi-cash"></i> Price: PHP<?php echo number_format(htmlspecialchars($row['price']), 2); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img src="./admin/img/<?php echo htmlspecialchars($row['image_url']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <?php
                    mysqli_data_seek($resultFeatured, 0);
                    $slideIndex = 0;
                    while ($row = mysqli_fetch_assoc($resultFeatured)) {
                        $activeClass = $slideIndex === 0 ? 'active' : '';
                        ?>
                        <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="<?php echo $slideIndex; ?>" class="<?php echo $activeClass; ?>" aria-label="Slide <?php echo $slideIndex + 1; ?>"></button>
                        <?php
                        $slideIndex++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Indicator styling */
        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            background-color: #6c757d; /* Default color for inactive indicators */
            border-radius: 50%;
            border: none;
            opacity: 0.7;
        }
        .carousel-indicators .active {
            background-color: black; /* Color for active indicator */
        }
    </style>



    <!-- Items Section -->
    <section class="py-5 bg-light" id="items" style="background: #f3f4f6;">
        <div class="container">
            <h2 class="text-center section-title">All Items</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <div class="row my-5">
                <?php
                if ($result->num_rows > 0) {
                    // Loop through each item
                    while ($row = $result->fetch_assoc()) {
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
                            <p class="card-text">73 Rizal Hwy, Central Business District, Subic Bay Freeport Zone, Zambales</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-telephone fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Call Us</h5>
                            <p class="card-text">(047) 252 5940 , 09285020242
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-envelope fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Email Us</h5>
                            <p class="card-text">lyceumsubicbay@lsb.edu.ph</p>
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
            <h2 class="mb-4">Testimonials</h2>
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

    <?php include('./footer/merch_footer.php');?>
    
</body>
</html>
