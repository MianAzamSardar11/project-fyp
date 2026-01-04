<?php
include('admin/config.php');
$get_logo = mysqli_query($conn, "SELECT * FROM logo");
$logo = mysqli_fetch_assoc($get_logo);
?>

<!-- Start Preloader ============================================= -->
<div id="preloader">
    <div id="ambrox-preloader" class="ambrox-preloader">
        <div class="animation-preloader">
            <div class="spinner"></div>
            <div class="txt-loading">
                <span data-text-preloader="S" class="letters-loading">S</span>
                <span data-text-preloader="O" class="letters-loading">O</span>
                <span data-text-preloader="C" class="letters-loading">C</span>
                <span data-text-preloader="I" class="letters-loading">I</span>
                <span data-text-preloader="A" class="letters-loading">A</span>
                <span data-text-preloader="V" class="letters-loading">V</span>
                <span data-text-preloader="O" class="letters-loading">O</span>
            </div>
        </div>
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Preloader -->

<!-- Header ============================================= -->
<header>
    <!-- Start Navigation -->
    <nav class="navbar mobile-sidenav navbar-sticky navbar-default validnavs navbar-fixed white no-background">

        <div class="container d-flex justify-content-between align-items-center">
            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="./admin/<?= $logo['main_logo'] ?>" class="logo logo-display" alt="Logo">
                    <img src="./admin/<?= $logo['second_logo'] ?>" class="logo logo-scrolled" alt="Logo">
                </a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-center d-md-flex gap-3 flex-md-row" data-in="fadeInDown" data-out="fadeOutUp">
                    <li><a href="index.php" class="fs-5">Home</a></li>
                    <li><a href="about-us.php" class="fs-5">About</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle fs-5" data-toggle="dropdown">Services</a>
                        <ul class="dropdown-menu">
                            <?php
                            // Fetch services from the database
                            $query = "SELECT `service_id`, `service_name` FROM `services` WHERE `service_status` = 1";
                            $result = mysqli_query($conn, $query);

                            // Loop through the services and display each one
                            if (mysqli_num_rows($result) > 0) {
                                while ($service = mysqli_fetch_assoc($result)) {
                                    echo "<li><a href='service-details.php?id=" . $service['service_id'] . "'>" . htmlspecialchars($service['service_name']) . "</a></li>";
                                }
                                mysqli_data_seek($result, 0);
                            } else {
                                echo "<li><a href='#'>No Services Available</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a href="portfolio.php" class="fs-5">Portfolio</a></li>
                    <li><a href="contact-us.php" class="fs-5">Contact Us</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->

        </div>
    </nav>
    <!-- End Navigation -->
</header>
<!-- End Header -->

<?php
                                $get_links = mysqli_query($conn, "SELECT * FROM social_links");
                                $links = mysqli_fetch_assoc($get_links);
                                ?>

<div class="contact-icons">
    <a href="https://wa.me/<?= $links['whatsapp'] ?>" target="_blank" class="icon whatsapp" title="Chat on WhatsApp">
        <i class='fab fa-whatsapp'></i>
    </a>
    <a href="tel:<?= $links['whatsapp'] ?>" class="icon call" title="Call Now">
        <i class='fas fa-phone'></i>
    </a>
    <a href="<?= $links['facebook'] ?>" target="_blank" class="icon facebook" title="Visit Facebook Page">
        <i class='fab fa-facebook-f'></i>
    </a>
    <a href="<?= $links['instagram'] ?>" class="icon instagram" title="Visit Instagram Page">
        <i class='fab fa-instagram'></i>
    </a>
  </div>