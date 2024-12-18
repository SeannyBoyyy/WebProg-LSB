<?php include('./config/config.php'); 

// Query to retrieve events items
$merch_sql = "SELECT * FROM events";
$result = $conn->query($merch_sql);

// Fetch the featured event
$query = "SELECT * FROM events WHERE category = 1 LIMIT 1";
$featured_result = mysqli_query($conn, $query);
$featured_event = mysqli_fetch_assoc($featured_result);


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
    <title>LSB Events</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/lsbesports_bg.png') no-repeat center center/cover;
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
                        <li class="nav-item"><a class="nav-link" href="merch.php">Merchandise</a></li>
                        <li class="nav-item"><a class="nav-link active" href="events.php">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Explore the Events at <br> Lyceum of Subic Bay</h1>
            <p>Stay updated with the latest events happening at LSB, from esports tournaments to student activities and school-wide celebrations. Don’t miss out on key dates and exciting opportunities to get involved in the campus community!</p>
            <a href="#events" class="btn btn-primary">View Upcoming Events</a>
        </div>
    </section>

    <!-- Countdown Timer Section -->
    <section id="featured-event" class="py-5 text-center" style="background: #e9ecef;">
        <div class="container">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: bold;">Featured</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <?php if ($featured_event): ?>
                <div class="bg-dark container text-white p-5">
                    <h2 class="" style="font-size: 2.5rem; font-weight: bold;"><?php echo htmlspecialchars($featured_event['title']); ?></h2>
                    <p class="text-uppercase mb-4" style="color: #a0c334;">Now You Can Watch the Talent</p>
                    <div id="countdown" class="fs-1 mb-3" style="font-weight: bold;"></div><!-- Countdown -->
                    <a href="#featured-event" class="btn btn-success btn-lg mb-4" style="background-color: #a0c334; border-color: #a0c334;">Start In</a>
                    <p><strong>Date:</strong> <?php echo date('F j - F j, Y', strtotime($featured_event['event_date'])); ?></p>
                    <p><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($featured_event['location']); ?></p>
                    <img src="./admin/img/<?php echo $featured_event['image_url']; ?>" class="img-fluid img-thumbnail mb-3" alt="Featured Image" style="max-width: 50%;">
                </div>
            <?php else: ?>
                <p>No featured event at the moment.</p>
            <?php endif; ?>
        </div>
    </section>


    <!-- Events Section -->
    <section id="events" class="py-5" style="background: #f3f4f6;">
        <div class="container">
            <h2 class="section-title text-center">Upcoming Events</h2>
            <div class="section-title-hr"><!-- Underline --></div>
            <div class="row">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($event = $result->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card event-card">
                                <img src="./admin/img/<?php echo $event['image_url']; ?>" class="card-img-top event-img" alt="Event Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $event['title']; ?></h5>
                                    <p class="card-text"><?php echo substr($event['description'], 0, 100) . '...'; ?></p>
                                    <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['event_date'])); ?></p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal<?php echo $event['event_id']; ?>">
                                        Read More
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Event Modal -->
                        <div class="modal fade" id="eventModal<?php echo $event['event_id']; ?>" tabindex="-1" aria-labelledby="eventModalLabel<?php echo $event['event_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="eventModalLabel<?php echo $event['event_id']; ?>">Event Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="./admin/img/<?php echo $event['image_url']; ?>" class="img-fluid mb-3" alt="Event Image">
                                        <h5><?php echo $event['title']; ?></h5>
                                        <p><?php echo $event['description']; ?></p>
                                        <p><strong>Date:</strong> <?php echo date('l, F j, Y', strtotime($event['event_date'])); ?></p>
                                        <p><strong>Location:</strong> <?php echo $event['location']; ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">No upcoming events at the moment.</p>
                    </div>
                <?php endif; ?>
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


    <?php include('./footer/merch_footer.php');?>
    
</body>
</html>
