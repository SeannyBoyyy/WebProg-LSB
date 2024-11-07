<?php include('./config/config.php'); 

// Regular merchandise
// Query to retrieve merchandise items
$merch_sql = "SELECT * FROM merch WHERE category = 'regular'";
$result = $conn->query($merch_sql);

// Query to get the featured news article
$queryFeaturedNews = "SELECT * FROM news WHERE category = 'Featured' ORDER BY published_date DESC LIMIT 1";
$resultFeaturedNews = mysqli_query($conn, $queryFeaturedNews);
$featuredNews = mysqli_fetch_assoc($resultFeaturedNews);

// Spotlight merchandise
$sqlSpotlight = "SELECT * FROM spotlight";
$resultSpotlight = $conn->query($sqlSpotlight);

// Fetch latest news from the database
$sqlNews = "SELECT * FROM news WHERE category = 'General' ORDER BY published_date DESC LIMIT 4";
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
                echo "<script>
                    alert('News submitted successfully. Awaiting admin approval.');
                    window.location.href = 'news.php';
                </script>";
            } else {
                echo "<script>alert('Error submitting news. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Invalid image. Please upload a JPG or PNG file up to 1MB.');</script>";
        }
    }
}

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
                <a class="navbar-brand" href="index.php">Lyceum of Subic Bay</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#programs">Programs</a></li>
                        <li class="nav-item"><a class="nav-link active" href="news.php">Spotlight</a></li>
                        <li class="nav-item"><a class="nav-link active" href="news.php">News</a></li>
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
    <section class="tagline text-center" style="font-size: 1.2rem; padding: 15px;">
        <div class="container rounded shadow p-5" style="background-color: #e9ecef;">
            <p class="text-muted mb-1">WELCOME TO BULLETIN</p>
            <h2>Craft narratives ✍️ that ignite <span class="text-danger">inspiration💡</span>, <span class="text-primary">knowledge 📚</span>, and <span class="text-warning">entertainment 🎬</span></h2>
        </div>
    </section>

    <!-- Featured Article Section -->
    <section class="container my-5 p-5">
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
    </section>

    <!-- Latest News Section -->
    <section class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Latest News</h4>
            <a href="#" class="text-decoration-none">See all →</a>
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
    </section>


    <!-- Features Section - Carousel -->
    <section class="py-5" id="features" style="background: #e9ecef;">
        
    </section>


    <!-- News Section -->
    <section class="py-5 bg-light" id="news" style="background: #f3f4f6;">
       
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

                        <?php if ($resultSpotlight->num_rows > 0): ?>
                            <?php $isActive = true; ?>
                            <?php while ($row = $resultSpotlight->fetch_assoc()): ?>
                                <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>" style="height: 700px;"> <!-- Fixed height for carousel item -->
                                    <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                        <div class="video-container" style="width: 75%; height: auto;">
                                            <!-- Thumbnail Image with Play Button -->
                                            <div class="video-thumbnail" onclick="playVideo('<?php echo $row['spotlight_id']; ?>')" style="cursor: pointer; position: relative; height: auto; overflow: hidden;">
                                                <img src="<?php echo './admin/img/' . $row['featured_image_url']; ?>" class="img-fluid" alt="Play Video" style="width: 100%; height: auto; object-fit: cover;">
                                                <!-- Overlay Play Icon -->
                                                <span class="position-absolute top-50 start-50 translate-middle" style="font-size: 3em; color: white;">
                                                    <i class="bi bi-play"></i>
                                                </span>
                                            </div>
                                            <!-- Video Element, Initially Hidden -->
                                            <video id="video-<?php echo $row['spotlight_id']; ?>" class="w-100" controls style="display: none; height: auto;">
                                                <source src="<?php echo './admin/vid/' . $row['video_url']; ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <div class="text-center mt-3">
                                            <h5><?php echo $row['title']; ?></h5>
                                            <p style="color: #555; max-width: 600px; margin: 0 auto;">
                                                <?php echo $row['description']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php $isActive = false; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-center">No spotlight videos available.</p>
                        <?php endif; ?>
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


    <script>
    function playVideo(spotlightId) {
        // Hide the thumbnail image
        const thumbnail = document.querySelector(`#video-${spotlightId}`).previousElementSibling;
        thumbnail.style.display = 'none';

        // Display the video and play it
        const video = document.getElementById(`video-${spotlightId}`);
        video.style.display = 'block';
        video.play();
    }
    </script>




    <!-- News & Stories Section -->
    <section class="py-5 bg-light" id="news" style="background: #eaeaea;">
        
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


    <!-- Events Section -->
    <section class="py-5 bg-light" id="events" style="background: #f9f9f9;">
        
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

    <!-- Chatbot Section -->
    <script>
    window.embeddedChatbotConfig = {
    chatbotId: "n6QilLoDecBUhKqbS5JPL",
    domain: "www.chatbase.co"
    }
    </script>
    <script
    src="https://www.chatbase.co/embed.min.js"
    chatbotId="n6QilLoDecBUhKqbS5JPL"
    domain="www.chatbase.co"
    defer>
    </script><!-- /Chatbot Section -->

    <?php include('./footer/merch_footer.php');?>
    
</body>
</html>
