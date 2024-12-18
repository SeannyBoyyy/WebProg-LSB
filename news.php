<?php include('./config/config.php'); 

// Regular merchandise
// Query to retrieve merchandise items
$merch_sql = "SELECT * FROM merch WHERE category = 'regular'";
$result = $conn->query($merch_sql);

// Query to get the featured news article
$queryFeaturedNews = "SELECT * FROM news WHERE category = 'Featured' ORDER BY news_id DESC LIMIT 1";
$resultFeaturedNews = mysqli_query($conn, $queryFeaturedNews);
$featuredNews = mysqli_fetch_assoc($resultFeaturedNews);

// Spotlight merchandise
$sqlSpotlight = "SELECT * FROM spotlight";
$resultSpotlight = $conn->query($sqlSpotlight);

// Fetch latest news from the database
$sqlNews = "SELECT * FROM news WHERE category = 'General' ORDER BY news_id DESC";
$resultNews = $conn->query($sqlNews);

// Process the form submission
if (isset($_POST['submit_news'])) {
    $title = mysqli_real_escape_string($conn, $_POST['news_title']);
    $content = mysqli_real_escape_string($conn, $_POST['news_content']);
    $author = mysqli_real_escape_string($conn, $_POST['news_author']);

    // Handle image upload
    if ($_FILES['news_image']['error'] === 0) {
        $fileName = $_FILES['news_image']['name'];
        $fileSize = $_FILES['news_image']['size'];
        $tmpName = $_FILES['news_image']['tmp_name'];
        
        $validExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if (in_array($fileExtension, $validExtensions) && $fileSize <= 1000000) {
            $newImageName = uniqid() . '.' . $fileExtension;
            move_uploaded_file($tmpName, './admin/img/' . $newImageName);
            
            // Insert into the database with category set to pending
            $query = "INSERT INTO news (title, content, author, image_url, created_at, category) 
                      VALUES ('$title', '$content', '$author', '$newImageName', NOW(), 'pending')";
            
            if (mysqli_query($conn, $query)) {
                echo "...
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'News submitted successfully. Awaiting admin approval.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'news.php';
                    });
                </script>";
            } else {
                echo "...
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Error submitting news. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
            }
        } else {
            echo "...
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Invalid Image',
                    text: 'Please upload a JPG or PNG file up to 1MB.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    }
}

// Contact Us
if (isset($_POST['send_message'])) {
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
    <title>LSB News & Spotlight</title>
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
                        <li class="nav-item"><a class="nav-link active" href="news.php">News & Spotlight</a></li>
                        <li class="nav-item"><a class="nav-link" href="merch.php">Merchandise</a></li>
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

    <!-- Header Section -->
    <section class="tagline text-center py-5" style="font-size: 1.2rem; padding: 15px;">
        <div class="container rounded shadow p-5" style="background-color: #e9ecef;">
            <p class="text-muted mb-1">WELCOME TO BULLETIN</p>
            <h2>Craft narratives ✍️ that ignite <span class="text-danger">inspiration💡</span>, <span class="text-primary">knowledge 📚</span>, and <span class="text-warning">entertainment 🎬</span></h2>
        </div>
    </section>


    <!-- Spotlight --> 
    <!-- Testimonial Video Carousel Section -->
    <section class="pb-5" id="spotlight">
        <div class="container">
            <h2 class="text-center section-title">Student Spotlight</h2>
            <div class="section-title-hr"><!-- Underline --></div>
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

    <!-- Featured Article Section -->
    <section class="py-5" style="background: #e9ecef;">
        <div class="container my-5">
            <?php if ($featuredNews): ?>
                <div class="row">
                    <div class="col-md-5">
                        <img src="./admin/img/<?= htmlspecialchars($featuredNews['image_url']); ?>" alt="<?= htmlspecialchars($featuredNews['title']); ?>" class="featured-article" style="width: 100%; border-radius: 10px;">
                    </div>
                    <div class="col-md-7">
                        <p class="text-muted">
                            <span><?= htmlspecialchars($featuredNews['author']); ?></span> • 
                            <?= date('F j, Y', strtotime($featuredNews['published_date'])); ?>
                        </p>
                        <h3><?= htmlspecialchars($featuredNews['title']); ?></h3>
                        <p><?= htmlspecialchars($featuredNews['content']) . '...'; ?></p>
                        <p class="text-danger">News <span class="text-muted"> • <?= htmlspecialchars($featuredNews['category']); ?></span> </p>
                    </div>
                </div>
            <?php else: ?>
                <p>No featured news available at the moment.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-5" style="background: #f3f4f6;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Latest News</h4>
            </div>
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
    </section>

    <!-- Upload News Section -->
    <section class="py-5" id="upload_news" style="background: #fff;">
        <div class="container">
            <h2 class="text-center section-title">Submit News</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <p class="text-center text-muted">Share news with the community. All submissions are pending approval.</p>
            
            <div class="row mt-4">
                <!-- Share Your Stories Section -->
                <div class="col-lg-6 mb-4">
                    <div class="p-4 shadow-sm" style="background-color: #f8f9fa; border-radius: 8px;">
                        <h3>Share Your Stories</h3>
                        <p class="text-muted">
                            We believe in the power of stories to connect, inspire, and empower our community. If you have a story that sheds light on exciting developments, inspiring achievements, or impactful community moments, we’d love to hear from you.
                        </p>
                        <p>
                            Your submission helps bring our community together by sharing unique perspectives and experiences. Feel free to include images, quotes, and other relevant details to make your news submission even more engaging.
                        </p>
                        <div class="d-flex justify-content-center mt-3">
                            <img src="img/merch_prev.jpg" alt="Share Your Story" class="img-fluid" style="border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <!-- Upload News Form Section -->
                <div class="col-lg-6">
                    <form action="news.php" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm" style="background-color: #f8f9fa; border-radius: 8px;">
                        <h3 class="mb-3">Upload Your Stories</h3>
                        <div class="mb-3">
                            <label for="news_title" class="form-label">News Title:</label>
                            <input type="text" class="form-control" id="news_title" name="news_title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="news_content" class="form-label">Content:</label>
                            <textarea class="form-control" id="news_content" name="news_content" rows="5" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="news_author" class="form-label">Author:</label>
                            <input type="text" class="form-control" id="news_author" name="news_author" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="news_image" class="form-label">Upload Image:</label>
                            <input type="file" class="form-control" id="news_image" name="news_image" accept=".jpg, .jpeg, .png" required>
                        </div>
                        
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100" name="submit_news">Submit News</button>
                        </div>
                    </form>
                </div>
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
                        <button type="submit" class="btn btn-primary" name="send_message">Send Message</button>
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
