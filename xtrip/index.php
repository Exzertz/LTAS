<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> Xtrip | Laser Tripwire Alarm System </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <!-- Libraries Stylesheet -->
    <link href="assets/landing-page/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/landing-page/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/landing-page/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/landing-page/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/landing-page/css/style.css" rel="stylesheet">
    <link href="assets/landing-page/css/custom-style.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only"> Loading... </span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-5">

        <div class="row gx-4 d-none d-lg-flex">

            <div class="col-lg-6 text-start">

                <div class="h-100 d-inline-flex align-items-center py-3 me-4">

                    <div class="btn-sm-square rounded-circle bg-primary me-2">
                        <small class="fa fa-map-marker-alt text-white"></small>
                    </div>

                    <small>
                        Rizal St, Iloilo City Proper, Iloilo City, 5000 Iloilo
                    </small>

                </div>

                <div class="h-100 d-inline-flex align-items-center py-3">

                    <div class="btn-sm-square rounded-circle bg-primary me-2">
                        <small class="fa fa-envelope-open text-white"></small>
                    </div>

                    <small>
                        lasertripwire.brb@gmail.com
                    </small>

                </div>

            </div>

            <div class="col-lg-6 text-end">

                <!-- Telephone -->
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">

                    <div class="btn-sm-square rounded-circle bg-primary me-2">
                        <small class="fa fa-phone-alt text-white"></small>
                    </div>

                    <small>
                        (033) 123 4567
                    </small>

                </div>

                <!-- Cellphone -->
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">

                    <div class="btn-sm-square rounded-circle bg-primary me-2">
                        <small class="fa fa-mobile-alt text-white"></small>
                    </div>

                    <small>
                        0912 345 6789
                    </small>

                </div>

            </div>

        </div>

    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 px-4 px-lg-5">

        <a href="index.php" class="navbar-brand d-flex align-items-center">
            <h2 class="m-0 text-danger"> Laser Tripwire Alarm System </h2>
        </a>

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-4 py-lg-0">

                <a href="index.html" class="nav-item nav-link active"> Home </a>

                <a href="#contact-us" class="nav-item nav-link"> Contact Us </a>

                <div class="nav-item dropdown">

                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> Login </a>

                    <div class="dropdown-menu rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#admin-login"> Administrator </a>
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#user-login"> User Account </a>
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-account"> Create Account </a>
                    </div>

                </div>
            </div>

            <div class="h-100 d-lg-inline-flex align-items-center d-none">

                <a class="btn btn-square rounded-circle bg-light text-primary me-2" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a class="btn btn-square rounded-circle bg-light text-primary me-0" href="">
                    <i class="fab fa-instagram"></i>
                </a>

            </div>

        </div>

    </nav>
    <!-- Navbar End -->

    <!-- Carousel Start -->
    <div class="container-fluid p-0 pb-5">
        <div class="owl-carousel header-carousel position-relative">

            <!-- Slide 1 -->
            <div class="owl-carousel-item position-relative">

                <img class="img-fluid" src="assets/landing-page/img/carousel-1.jpg" alt="">

                <div class="carousel-inner">

                    <div class="container">

                        <div class="row justify-content-center">

                            <div class="col-12 col-lg-8 text-center">

                                <h1 class="display-3 text-white animated slideInDown mb-4">
                                    Laser-Precise Perimeter Defense
                                </h1>

                                <p class="fs-5 text-white mb-4 pb-2">
                                    Protect your facility with our cutting-edge lasertripwire system—fast, accurate, and
                                    tamper-resistant.
                                </p>

                                <a href="#contact-us"
                                    class="btn btn-primary rounded-pill py-md-3 px-md-5 me-3 animated slideInLeft">
                                    Contact Us
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Slide 2 -->
            <div class="owl-carousel-item position-relative">

                <img class="img-fluid" src="assets/landing-page/img/carousel-2.jpg" alt="">

                <div class="carousel-inner">

                    <div class="container">

                        <div class="row justify-content-center">

                            <div class="col-12 col-lg-8 text-center">

                                <h1 class="display-3 text-white animated slideInDown mb-4">
                                    Advanced Threat Detection in Real Time
                                </h1>

                                <p class="fs-5 text-white mb-4 pb-2">
                                    Instant alerts, zero blind spots. Monitor yourenvironment with real-time laser
                                    breach detection.
                                </p>

                                <a href="#contact-us"
                                    class="btn btn-primary rounded-pill py-md-3 px-md-5 me-3 animated slideInLeft">
                                    Contact Us
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Slide 3 -->
            <div class="owl-carousel-item position-relative">

                <img class="img-fluid" src="assets/landing-page/img/carousel-3.jpg" alt="">

                <div class="carousel-inner">

                    <div class="container">

                        <div class="row justify-content-center">

                            <div class="col-12 col-lg-8 text-center">

                                <h1 class="display-3 text-white animated slideInDown mb-4">
                                    Smart Security for Critical Infrastructure
                                </h1>

                                <p class="fs-5 fw-medium text-white mb-4 pb-2">
                                    From homes to high-security zones, our laser tripwire system scales with your
                                    security needs.
                                </p>

                                <a href="#contact-us"
                                    class="btn btn-primary rounded-pill py-md-3 px-md-5 me-3 animated slideInLeft">
                                    Contact Us
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- Carousel End -->

    <!-- About Start -->
    <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">

        <div class="container about px-lg-0">
            <div class="row g-0 mx-lg-0">

                <!-- Image -->
                <div class="col-lg-6 ps-lg-0" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="assets/landing-page/img/about.jpg"
                            style="object-fit: cover;" alt="Laser Tripwire System">
                    </div>
                </div>

                <!-- Text Content -->
                <div class="col-lg-6 about-text text-dark py-5 wow fadeIn" data-wow-delay="0.5s">

                    <div class="p-lg-5 pe-lg-0">

                        <div class="bg-primary mb-3" style="width: 60px; height: 2px;"></div>

                        <h1 class="display-5 mb-4"> About Our Project </h1>

                        <p class="mb-4 pb-2">
                            The Laser Tripwire System is our innovative capstone project designed to enhance physical
                            security
                            through motion detection using laser-based sensors. By creating an invisible beam between
                            two points,
                            our system can instantly detect intrusions when the laser is interrupted.
                        </p>

                        <p class="mb-4 pb-2">
                            This project integrates hardware components like laser modules, sensors, and alarms with a
                            microcontroller,
                            offering real-time response capabilities. It is ideal for securing restricted areas,
                            doorways, or
                            high-value zones in both residential and commercial settings.
                        </p>

                        <p class="mb-4 pb-2">
                            Our aim is to deliver a cost-effective, accurate, and scalable security solution that
                            bridges electronics,
                            programming, and innovation—providing a solid foundation for real-world cybersecurity and
                            surveillance systems.
                        </p>

                        <!-- Statistics -->
                        <div class="row g-4 mb-4 mt-2 pb-3">

                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">

                                <div class="d-flex align-items-center">

                                    <div class="btn-square bg-white rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 64px; height: 64px;">
                                        <i class="bi bi-shield-lock-fill text-primary fs-3"></i>
                                    </div>

                                    <div class="ms-4">
                                        <h2 class="mb-1"> 100% </h2>
                                        <p class="fw-medium text-primary mb-0">Intrusion Detection Accuracy </p>
                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="d-flex align-items-center">

                                    <div class="btn-square bg-white rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 64px; height: 64px;">
                                        <i class="bi bi-battery-half text-primary fs-3"></i>
                                    </div>

                                    <div class="ms-4">
                                        <h2 class="mb-1"> Low Voltage </h2>
                                        <p class="fw-medium text-primary mb-0"> Power Efficiency </p>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- About End -->

    <!-- Features Start -->
    <div class="container-xxl py-5">

        <div class="container">

            <div class="text-center">
                <div class="bg-primary mb-3 mx-auto" style="width: 60px; height: 2px;"></div>
                <h1 class="display-5 mb-5"> Key Features </h1>
            </div>

            <div class="row g-0 service-row">

                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">

                    <div class="service-item border h-100 p-5">

                        <div class="btn-square bg-light rounded-circle mb-4 d-flex align-items-center justify-content-center"
                            style="width: 64px; height: 64px;">
                            <i class="bi bi-camera-fill fs-3 text-primary"></i>
                        </div>

                        <h4 class="mb-3">
                            Instant Capture
                        </h4>

                        <p class="mb-0 text-dark">
                            The sensor detects movement and instantly takes a picture for evidence.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">

                    <div class="service-item border h-100 p-5">

                        <div class="btn-square bg-light rounded-circle mb-4 d-flex align-items-center justify-content-center"
                            style="width: 64px; height: 64px;">
                            <i class="bi bi-volume-up-fill fs-3 text-primary"></i>
                        </div>

                        <h4 class="mb-3">
                            Alarm Trigger
                        </h4>

                        <p class="mb-0 text-dark">
                            A loud alarm is activated immediately to deter intruders.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">

                    <div class="service-item border h-100 p-5">

                        <div class="btn-square bg-light rounded-circle mb-4 d-flex align-items-center justify-content-center"
                            style="width: 64px; height: 64px;">
                            <i class="bi bi-bell-fill fs-3 text-primary"></i>
                        </div>

                        <h4 class="mb-3">
                            Real-Time Alerts
                        </h4>

                        <p class="mb-0 text-dark">
                            The system instantly notifies the user upon sensor trigger.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">

                    <div class="service-item border h-100 p-5">

                        <div class="btn-square bg-light rounded-circle mb-4 d-flex align-items-center justify-content-center"
                            style="width: 64px; height: 64px;">
                            <i class="bi bi-clock-history fs-3 text-primary"></i>
                        </div>

                        <h4 class="mb-3">
                            Alarm Logs
                        </h4>

                        <p class="mb-0 text-dark">
                            Access and review the most recent alarm events through the website.
                        </p>

                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- Features End -->

    <!-- Why Choose Us Start -->
    <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">

        <div class="container feature px-lg-0">

            <div class="row g-0 mx-lg-0">

                <div class="col-lg-6 feature-text py-5 wow fadeIn" data-wow-delay="0.5s">

                    <div class="p-lg-5 ps-lg-0">

                        <div class="bg-primary mb-3" style="width: 60px; height: 2px;"></div>

                        <h1 class="display-5 mb-5"> Why Choose Us </h1>

                        <p class="mb-4 pb-2 text-dark">
                            The Laser Tripwire System is built for reliability, speed, and intelligent protection. We
                            offer high-level cybersecurity features with ease of use and instant response.
                        </p>

                        <div class="row g-4">

                            <div class="col-6">

                                <div class="d-flex align-items-center">

                                    <div class="btn-square bg-white rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 64px; height: 64px;">
                                        <i class="bi bi-shield-lock-fill fs-3 text-primary"></i>
                                    </div>

                                    <div class="ms-4">

                                        <p class="text-primary mb-2"> Trusted </p>
                                        <h5 class="mb-0"> Security </h5>

                                    </div>
                                </div>
                            </div>

                            <div class="col-6">

                                <div class="d-flex align-items-center">
                                    <div class="btn-square bg-white rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 64px; height: 64px;">
                                        <i class="bi bi-check-circle-fill fs-3 text-primary"></i>
                                    </div>

                                    <div class="ms-4">

                                        <p class="text-primary mb-2"> Quality </p>
                                        <h5 class="mb-0"> Services </h5>

                                    </div>

                                </div>
                            </div>

                            <div class="col-6">

                                <div class="d-flex align-items-center">

                                    <div class="btn-square bg-white rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 64px; height: 64px;">
                                        <i class="bi bi-cpu-fill fs-3 text-primary"></i>
                                    </div>

                                    <div class="ms-4">

                                        <p class="text-primary mb-2"> Smart </p>
                                        <h5 class="mb-0"> Systems </h5>

                                    </div>
                                </div>

                            </div>

                            <div class="col-6">


                                <div class="d-flex align-items-center">
                                    <div class="btn-square bg-white rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 64px; height: 64px;">
                                        <i class="bi bi-headset fs-3 text-primary"></i>
                                    </div>

                                    <div class="ms-4">

                                        <p class="text-primary mb-2"> 24/7 Hours </p>
                                        <h5 class="mb-0"> Support </h5>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6 pe-lg-0" style="min-height: 400px;">

                    <div class="position-relative h-100">

                        <img class="position-absolute img-fluid w-100 h-100" src="assets/landing-page/img/feature.jpg"
                            style="object-fit: cover;" alt="">
                    </div>

                </div>
            </div>

        </div>

    </div>
    <!-- Why Choose Us End -->

    <!-- Contact Us Start -->
    <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0" id="contact-us">

        <div class="container quote px-lg-0">

            <div class="row g-0 mx-lg-0">

                <div class="col-lg-6 ps-lg-0" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100"
                            src="assets/landing-page/img/contact-us.jpg" style="object-fit: cover;" alt="">
                    </div>
                </div>

                <div class="col-lg-6 quote-text py-5 wow fadeIn" data-wow-delay="0.5s">

                    <div class="p-lg-5 pe-lg-0">

                        <div class="bg-primary mb-3" style="width: 60px; height: 2px;"></div>

                        <h1 class="display-5 mb-5">Contact Us</h1>

                        <p class="mb-4 pb-2 text-dark">
                            Need help with installation, system repairs, or want to place an order? Our team is ready to
                            assist you!
                            Reach out today for inquiries, service scheduling, or custom security solutions. We're here
                            to support your safety—every step of the way.
                        </p>

                        <form action="process/send-inquiry.php" method="POST" autocomplete="off">

                            <div class="row g-3">

                                <div class="col-12 col-sm-6 text-dark">
                                    <input type="text" class="form-control border-0 text-dark" name="full-name" placeholder="Full Name"
                                        style="height: 55px;" required>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="email" class="form-control border-0 text-dark" name="email-address"
                                        placeholder="Email Address" style="height: 55px;" required>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control border-0 text-dark"
                                        name="phone-number"
                                        pattern="^(\+639|09)\d{9}$"
                                        title="Must start with +639 or 09 followed by 9 digits"
                                        placeholder="Phone Number" style="height: 55px;" required>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <select class="form-select border-0 text-dark" name="service-type" style="height: 55px;">
                                        <option selected disabled> Select A Service </option>
                                        <option value="Order and Install"> Order and Install </option>
                                        <option value="Maintenance"> Maintenance </option>
                                        <option value="Repair"> Repair </option>
                                    </select>
                                </div>

                                <div class="col-12 text-dark">
                                    <input type="text" class="form-control border-0 text-dark" name="address" placeholder="Address"
                                        style="height: 55px;" required>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit" name="submit-inquiry"> Contact Us </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- Contact Us End -->

    <!-- Team Start -->
    <div class="container-xxl py-5">

        <div class="container">

            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-primary mb-3 mx-auto" style="width: 60px; height: 2px;"></div>
                <h1 class="display-5 mb-5"> Project Team Members </h1>
            </div>

            <div class="row g-4">

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">

                    <div class="team-item">

                        <div class="overflow-hidden position-relative">

                            <img class="img-fluid" src="assets/landing-page/img/member-1.jpg" alt="Member 1">

                            <div class="team-social">
                                <a class="btn btn-square btn-dark rounded-circle m-1" href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </div>

                        </div>

                        <div class="text-center p-4">
                            <h5 class="mb-0"> Julian Jacob Casemero </h5>
                            <span class="text-primary"> Programmer </span>
                        </div>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">

                    <div class="team-item">

                        <div class="overflow-hidden position-relative">

                            <img class="img-fluid" src="assets/landing-page/img/member-2.jpg" alt="Member 2">

                            <div class="team-social">
                                <a class="btn btn-square btn-dark rounded-circle m-1" href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </div>

                        </div>

                        <div class="text-center p-4">
                            <h5 class="mb-0"> Dan Rytchy Magneser </h5>
                            <span class="text-primary"> UI/UX Designer </span>
                        </div>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">

                    <div class="team-item">

                        <div class="overflow-hidden position-relative">

                            <img class="img-fluid" src="assets/landing-page/img/member-3.jpg" alt="Member 3">

                            <div class="team-social">
                                <a class="btn btn-square btn-dark rounded-circle m-1" href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </div>

                        </div>

                        <div class="text-center p-4">
                            <h5 class="mb-0"> Ma. Luzel Ambugana </h5>
                            <span class="text-primary"> Documenter </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- Team End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">

        <div class="container py-5">

            <div class="row g-5">

                <!-- Contact Info -->
                <div class="col-lg-5 col-md-6">
                    <h5 class="text-primary mb-4"> Get in Touch </h5>

                    <p class="mb-3">
                        <i class="fa fa-map-marker-alt me-3"></i>Rizal St, Iloilo City Proper, Iloilo City, 5000
                    </p>

                    <p class="mb-3">
                        <i class="fa fa-phone-alt me-3"></i>(033) 123 4567
                    </p>

                    <p class="mb-3">
                        <i class="fa fa-mobile-alt me-3"></i>0912 345 6789
                    </p>

                    <p class="mb-3">
                        <i class="fa fa-envelope me-3"></i>lasertripwire.brb@gmail.com
                    </p>

                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social rounded-circle me-2" href="#">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a class="btn btn-outline-light btn-social rounded-circle me-2" href="#">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>

                </div>

                <!-- Brand Info -->
                <div class="col-lg-7 col-md-6 text-lg-end text-md-start">
                    <h5 class="text-primary mb-4"> About LTAX </h5>
                    <p class="text-white">
                        LTAX (Laser Tripwire Alarm System) provides 24/7 intelligent motion detection with instant
                        alerts and remote web monitoring. Protect what matters most—secure your home or business today.
                    </p>
                </div>

            </div>

            <!-- Footer Bottom -->
            <div class="row mt-5 pt-4 border-top border-secondary">

                <div class="col-md-6 text-center text-md-start">
                    &copy; <a class="text-primary border-bottom" href="#">LTAX</a>, All Rights Reserved.
                </div>

                <div class="col-md-6 text-center text-md-end">
                    Designed by <a class="text-primary border-bottom" href="#"> Team BRB </a>
                </div>

            </div>

        </div>

    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- Login as Admin Modal -->
    <div class="modal fade" id="admin-login" tabindex="-1" aria-labelledby="adminLoginModal" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="adminModalLabel"> Login as Administrator </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="process/admin/admin-auth.php" method="POST" autocomplete="off" class="text-dark">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="admin_email" class="mb-1"> Email Address: </label>

                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-at-fill"></i>
                                </span>

                                <input type="email" class="form-control" placeholder="Email Address" id="admin_email" name="email-address" required>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="admin_pword" class="mb-1"> Password: </label>

                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="bi bi-key-fill"></i>
                                </span>

                                <input type="password" class="form-control admin-password" placeholder="Password" id="admin_pword" name="password" required>
                            </div>

                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="toggleAdminPassword" onclick="togglePasswords('admin-password')">
                                <label class="form-check-label" for="toggleAdminPassword">
                                    Show Password
                                </label>
                            </div>

                            <a href="#" class="custom-href" data-bs-target="#forgot-admin-password" data-bs-toggle="modal" data-bs-dismiss="modal"> Forgot Password? </a>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close </button>
                        <button type="submit" name="admin-login" class="btn custom-confirm-button"> Login </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- Login as Admin Modal -->

    <!-- Forgot Admin Password -->
    <div class="modal fade" id="forgot-admin-password" aria-hidden="true" aria-labelledby="forgotAdminPasswordModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="forgotAdminPasswordLabel"> Forgot Admin Password? </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="process/admin/admin-auth.php" method="POST" autocomplete="off">

                    <div class="modal-body">
                        <p>
                            Please enter your <b>Email Address</b> to continue.
                        </p>

                        <div class="mb-3">
                            <label for="forgot_admin_email" class="mb-1"> Email Address: </label>

                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-at-fill"></i>
                                </span>

                                <input type="email" class="form-control" placeholder="Email Address" id="forgot_admin_email" name="email-address" required>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#admin-login" data-bs-toggle="modal" data-bs-dismiss="modal"> Back </button>
                        <button type="submit" name="verify-admin-account" class="btn custom-confirm-button"> Verify Account </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- Forgot Admin Password -->

    <!-- Login as User Modal -->
    <div class="modal fade" id="user-login" tabindex="-1" aria-labelledby="userLoginModal" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="userModalLabel"> Login as User </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="process/users/user-auth.php" method="POST" autocomplete="off" class="text-dark">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="user_email" class="mb-1"> Email Address: </label>

                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-at-fill"></i>
                                </span>

                                <input type="email" class="form-control" placeholder="Email Address" id="user_email" name="email-address" required>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="user_pword" class="mb-1"> Password: </label>

                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="bi bi-key-fill"></i>
                                </span>

                                <input type="password" class="form-control user-password" placeholder="Password" id="user_pword" name="password" required>
                            </div>

                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="toggleUserPassword" onclick="togglePasswords('user-password')">
                                <label class="form-check-label" for="toggleUserPassword">
                                    Show Password
                                </label>
                            </div>

                            <a href="#" class="custom-href" data-bs-target="#forgot-user-password" data-bs-toggle="modal" data-bs-dismiss="modal"> Forgot Password? </a>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close </button>
                        <button type="submit" name="user-login" class="btn custom-confirm-button"> Login </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- Login as User Modal -->

    <!-- Forgot User Password -->
    <div class="modal fade" id="forgot-user-password" aria-hidden="true" aria-labelledby="forgotUserPasswordModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="forgotUserPasswordLabel"> Forgot User Password? </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="process/users/user-auth.php" method="POST" autocomplete="off">

                    <div class="modal-body">
                        <p>
                            Please enter your <b>Email Address</b> to continue.
                        </p>

                        <div class="mb-3">
                            <label for="forgot_user_email" class="mb-1"> Email Address: </label>

                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-at-fill"></i>
                                </span>

                                <input type="email" class="form-control" placeholder="Email Address" id="forgot_user_email" name="email-address" required>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#user-login" data-bs-toggle="modal" data-bs-dismiss="modal"> Back </button>
                        <button type="submit" name="verify-user-account" class="btn custom-confirm-button"> Verify Account </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- Forgot User Password -->

    <!-- Create Account Modal -->
    <div class="modal fade" id="create-account" tabindex="-1" aria-labelledby="createAccountModal" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-xl">

            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createAccountLabel"> Create User Account </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="process/users/user-auth.php" method="POST" autocomplete="off" class="text-dark">

                    <div class="modal-body">

                        <div class="row mb-2">

                            <h5 class="fs-5 mb-2"> Basic Information: </h5>

                            <div class="col-lg-4 col-md-12">
                                <label for="f_name" class="mb-1"> First Name: </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-fill"></i>
                                    </span>

                                    <input type="text" class="form-control" placeholder="First Name" id="f_name" name="first-name" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <label for="m_name" class="mb-1"> Middle Name(Optional): </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>

                                    <input type="text" class="form-control" placeholder="Middle Name(Optional)" id="m_name" name="middle-name">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <label for="l_name" class="mb-1"> Last Name: </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-fill"></i>
                                    </span>

                                    <input type="text" class="form-control" placeholder="Last Name" id="l_name" name="last-name" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <label for="user_gender" class="mb-1"> Gender: </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-gender-ambiguous"></i>
                                    </span>

                                    <select class="form-select" aria-label="Select Gender" id="user_gender" name="gender" required>
                                        <option selected disabled> SELECT GENDER </option>
                                        <option value="Male"> Male </option>
                                        <option value="Female"> Female </option>
                                        <option value="Others"> Others </option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <label for="civil_status" class="mb-1"> Civil Status: </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-heart-fill"></i>
                                    </span>

                                    <select class="form-select" aria-label="Select Marital Status" id="civil_status" name="civil-status" required>
                                        <option selected disabled> SELECT CIVIL STATUS </option>
                                        <option value="Single"> Single </option>
                                        <option value="Married"> Married </option>
                                        <option value="Divorced"> Divorced </option>
                                        <option value="Widowed"> Widowed </option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <label for="user_occupation" class="mb-1"> Occupation: </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-briefcase-fill"></i>
                                    </span>

                                    <select class="form-select" aria-label="Select Occupation" id="user_occupation" name="occupation" required>
                                        <option selected disabled> SELECT OCCUPATION </option>
                                        <option value="Employed"> Employed </option>
                                        <option value="Self-Employed"> Self-Employed </option>
                                        <option value="Student"> Student </option>
                                        <option value="Unemployed"> Unemployed </option>
                                        <option value="Others"> Others </option>
                                    </select>

                                </div>
                            </div>

                        </div>

                        <div class="row mb-2">

                            <h5 class="fs-5 mb-2"> Contact Information: </h5>

                            <!-- Cellphone Number -->
                            <div class="col-lg-4 col-md-12">
                                <label for="phone_number" class="mb-1"> Cellphone Number: </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-phone-fill"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Phone Number" id="phone_number" name="phone-number"
                                        pattern="^(\+639|09)\d{9}$"
                                        title="Must start with +639 or 09 followed by 9 digits"
                                        required>
                                </div>
                            </div>

                            <!-- Telephone Number (Optional) -->
                            <div class="col-lg-4 col-md-12">
                                <label for="user_telephone" class="mb-1"> Telephone Number (Optional): </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Telephone Number (Optional)" id="user_telephone" name="telephone-number"
                                        pattern="^(\d{7}|0\d{9})?$"
                                        title="Must be a 7-digit number or include area code (e.g., 0331234567)">
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-12">
                                <label for="user_address" class="mb-1"> Complete Address: </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </span>

                                    <input type="text" class="form-control" placeholder="Complete Address" id="user_address" name="address" required>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-1">

                            <h5 class="fs-5 mb-2"> Login Credentials: </h5>

                            <div class="col-lg-4 col-md-12">
                                <label for="user_email" class="mb-1"> Email Address: </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope-at-fill"></i>
                                    </span>

                                    <input type="email" class="form-control" placeholder="Email Address" id="user_email" name="email-address" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <label for="reg_password" class="mb-1"> Password: </label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-key-fill"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control registration-password"
                                        placeholder="Password"
                                        id="reg_password"
                                        name="password"
                                        required
                                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,16}$"
                                        title="Password must be 8–16 characters long, and include at least 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.">
                                </div>

                            </div>

                            <div class="col-lg-4 col-md-12">
                                <label for="reg_confirm_password" class="mb-1"> Confirm Password: </label>

                                <div class="input-group mb-1">
                                    <span class="input-group-text">
                                        <i class="bi bi-key"></i>
                                    </span>

                                    <input type="password" class="form-control registration-password" placeholder="Confirm Password" id="reg_confirm_password" name="confirm-password" required>
                                </div>
                            </div>

                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="show_passwords" onclick="togglePasswords('registration-password')">
                            <label class="form-check-label" for="show_passwords">
                                Show Password
                            </label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close </button>
                        <button type="submit" name="create-account" class="btn custom-confirm-button"> Create Account </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- Create Account Modal -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="assets/landing-page/lib/wow/wow.min.js"></script>
    <script src="assets/landing-page/lib/easing/easing.min.js"></script>
    <script src="assets/landing-page/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/landing-page/lib/counterup/counterup.min.js"></script>
    <script src="assets/landing-page/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/landing-page/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="assets/landing-page/lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/landing-page/js/main.js"></script>
    <script src="assets/global/js/passwords.js"></script>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION["alert-status"]) && $_SESSION["alert-status"] !== ""): ?>
        <script>
            const notification = <?php echo $_SESSION["alert-status"]; ?>;
            Swal.fire({
                icon: notification.icon || 'info',
                title: notification.title || '',
                text: notification.text || '',
                showConfirmButton: false,
                timer: 3000
            });
        </script>

        <?php unset($_SESSION["alert-status"]); ?>
    <?php endif; ?>
</body>

</html>