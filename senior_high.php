<?php include('./config/config.php'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch programs from the database where the category is 'senior_high'
$sql = "SELECT * FROM programs WHERE category = 'Senior High' ORDER BY program_id DESC";
$result = $conn->query($sql);

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
    <title>Senior High Program</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/college_grad.jpg') no-repeat center center/cover;
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
                            <a class="nav-link dropdown-toggle active" href="#" id="programsDropdown" role="button" aria-expanded="false">
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
            <h1>Explore the Senior High Programs of <br> Lyceum of Subic Bay</h1>
            <p>Discover a range of academic programs at LSB designed to prepare students for a successful future, with various strands to choose from in Senior High.</p>
            <a href="#programs" class="btn btn-primary">Explore Senior High Programs</a>
        </div>
    </section>


    <!-- College Programs Section -->
    <div class="container my-5">
        <h4><i class="bi bi-info-circle"></i> Learn more</h4>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Senior High Programs</h5>
                <p class="card-text">
                    The <strong>Senior High programs</strong> at Lyceum of Subic Bay are designed to provide students with the knowledge and skills needed to excel in their chosen fields, offering various academic tracks.
                </p>
            </div>
        </div>

        <div class="accordion mt-3" id="programAccordion">
            <?php
            // Check if any programs were returned from the database
            if ($result->num_rows > 0) {
                // Loop through each program and generate accordion items
                $accordionIndex = 0;
                while($row = $result->fetch_assoc()) {
                    $accordionIndex++;
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $accordionIndex; ?>">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $accordionIndex; ?>" aria-expanded="true" aria-controls="collapse<?php echo $accordionIndex; ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $accordionIndex; ?>" class="accordion-collapse collapse <?php echo $accordionIndex == 1 ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $accordionIndex; ?>" data-bs-parent="#programAccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-8">
                                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                                    </div>
                                    <div class="col-4">
                                    <img src="./admin/img/<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                    </div>
                                </div>
                                
                            
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No programs found for the College category.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Requirements & Enrollment Procedures Section -->
    <section class="requirements-enrollment" style="background: #fff;">
        <div class="container py-5">
            <h1 class="text-center mb-4 section-title">Enrollment Requirements & Procedures</h1>
            <div class="section-title-hr"></div>

            <div class="row">
                <!-- Left Column - Requirements -->
                <div class="col-lg-6">
                    <h3 class="my-4">Requirements</h3>
                    <div class="accordion" id="requirementsAccordion">
                        <!-- New Students -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="newStudents">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNewStudents" aria-expanded="true" aria-controls="collapseNewStudents">
                                    New Students
                                </button>
                            </h2>
                            <div id="collapseNewStudents" class="accordion-collapse collapse show" aria-labelledby="newStudents">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Form 138 / Report Card & Form 137A / Permanent Card</li>
                                        <li>Certificate of Good Moral Character issued by the high school</li>
                                        <li>Four (4) pcs. 2x2 colored pictures</li>
                                        <li>Birth certificate (photocopy)</li>
                                        <li>Long brown envelopes (2 pcs.)</li>
                                        <li>Medical certificate for healthcare services and HRM enrollees</li>
                                        <li>National Career Aptitude Exam (NCAE) results</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Transferees -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="transferees">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTransferees" aria-expanded="false" aria-controls="collapseTransferees">
                                    Transferees
                                </button>
                            </h2>
                            <div id="collapseTransferees" class="accordion-collapse collapse" aria-labelledby="transferees">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Transcript of Records</li>
                                        <li>Honorable Dismissal</li>
                                        <li>Certificate of Good Moral Character</li>
                                        <li>Four (4) pcs. 2x2 pictures</li>
                                        <li>Long brown envelopes (2 pcs.)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Old Students as Returnees -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="oldStudents">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOldStudents" aria-expanded="false" aria-controls="collapseOldStudents">
                                    Old Students as Returnees
                                </button>
                            </h2>
                            <div id="collapseOldStudents" class="accordion-collapse collapse" aria-labelledby="oldStudents">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Copy of grades and curricular checklist</li>
                                        <li>Interview with the Dean and Guidance Counselor (if academic delinquency exists)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Cross-Enrollees -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="crossEnrollees">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCrossEnrollees" aria-expanded="false" aria-controls="collapseCrossEnrollees">
                                    Cross-Enrollees
                                </button>
                            </h2>
                            <div id="collapseCrossEnrollees" class="accordion-collapse collapse" aria-labelledby="crossEnrollees">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Permit to cross enroll from the Registrar</li>
                                        <li>Two (2) pcs. 2x2 colored pictures</li>
                                        <li>Certificate of Good Moral Character from the mother school</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- College Graduates -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="collegeGraduates">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCollegeGraduates" aria-expanded="false" aria-controls="collapseCollegeGraduates">
                                    College Graduates (Second Course/Unit Earners)
                                </button>
                            </h2>
                            <div id="collapseCollegeGraduates" class="accordion-collapse collapse" aria-labelledby="collegeGraduates">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Official transcript of records (Original and Photocopy)</li>
                                        <li>Copy of the Diploma</li>
                                        <li>Two (2) pcs. 2x2 colored pictures</li>
                                        <li>Certificate of Good Moral Character from previous school or present employer</li>
                                        <li>Interview with the Head, Academic Department</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Special Non-Credit -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="specialNonCredit">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSpecialNonCredit" aria-expanded="false" aria-controls="collapseSpecialNonCredit">
                                    Special Non-Credit
                                </button>
                            </h2>
                            <div id="collapseSpecialNonCredit" class="accordion-collapse collapse" aria-labelledby="specialNonCredit">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Letter of Intent to study without credit</li>
                                        <li>Resume</li>
                                        <li>Previous scholastic records</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Foreign Students -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="foreignStudents">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForeignStudents" aria-expanded="false" aria-controls="collapseForeignStudents">
                                    Foreign Students
                                </button>
                            </h2>
                            <div id="collapseForeignStudents" class="accordion-collapse collapse" aria-labelledby="foreignStudents">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Credentials indicating secondary school graduation or equivalent</li>
                                        <li>Student Visa or Special Study Permit issued by the Bureau of Immigration (BI)</li>
                                        <li>Photocopy of passport</li>
                                        <li>Birth certificate</li>
                                        <li>Two (2) pcs. 2x2 colored pictures</li>
                                        <li>Medical certificate</li>
                                        <li>Long brown envelopes (2 pcs.)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Enrollment Procedures -->
                <div class="col-lg-6">
                    <h3 class="my-4">Enrollment Procedures</h3>
                    <div class="accordion" id="proceduresAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="procedureStep1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProcedureStep1" aria-expanded="true" aria-controls="collapseProcedureStep1">
                                    Step 1: Admission Requirements Validation
                                </button>
                            </h2>
                            <div id="collapseProcedureStep1" class="accordion-collapse collapse show" aria-labelledby="procedureStep1">
                                <div class="accordion-body">
                                    Bring the admission requirements for validation at the Registrar’s Office and get the curriculum for the chosen course.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="procedureStep2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProcedureStep2" aria-expanded="false" aria-controls="collapseProcedureStep2">
                                    Step 2: Evaluation by Department Head
                                </button>
                            </h2>
                            <div id="collapseProcedureStep2" class="accordion-collapse collapse" aria-labelledby="procedureStep2">
                                <div class="accordion-body">
                                    Proceed to the Department Head of the course for evaluation of subjects taken.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="procedureStep3">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProcedureStep3" aria-expanded="false" aria-controls="collapseProcedureStep3">
                                    Step 3: Pre-Registration
                                </button>
                            </h2>
                            <div id="collapseProcedureStep3" class="accordion-collapse collapse" aria-labelledby="procedureStep3">
                                <div class="accordion-body">
                                    Pay for your Pre-Registration form at the Cashier’s Office and submit it to the Registrar’s Office.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="procedureStep4">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProcedureStep4" aria-expanded="false" aria-controls="collapseProcedureStep4">
                                    Step 4: Course Registration
                                </button>
                            </h2>
                            <div id="collapseProcedureStep4" class="accordion-collapse collapse" aria-labelledby="procedureStep4">
                                <div class="accordion-body">
                                    Register for your subjects at the Registrar’s Office.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="procedureStep5">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProcedureStep5" aria-expanded="false" aria-controls="collapseProcedureStep5">
                                    Step 5: Payment of Fees
                                </button>
                            </h2>
                            <div id="collapseProcedureStep5" class="accordion-collapse collapse" aria-labelledby="procedureStep5">
                                <div class="accordion-body">
                                    Pay your tuition fees at the Cashier’s Office, then submit the payment receipt to the Registrar’s Office.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="procedureStep6">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProcedureStep6" aria-expanded="false" aria-controls="collapseProcedureStep6">
                                    Step 6: Release of Registration Form
                                </button>
                            </h2>
                            <div id="collapseProcedureStep6" class="accordion-collapse collapse" aria-labelledby="procedureStep6">
                                <div class="accordion-body">
                                    After completing the registration, the Registrar’s Office will release the official registration form and materials.
                                </div>
                            </div>
                        </div>
                    </div>
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

<?php
$conn->close();
?>