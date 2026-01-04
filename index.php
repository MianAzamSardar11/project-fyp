<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sociavo - Digital Marketing Agency">

    <title>Sociavo</title>
    <!-- css links -->
    <?php include('./includes/css-links.php') ?>
</head>

<body>
    <!-- header include -->
    <?php include('./includes/header.php') ?>

    <!-- Start Banner Area 
    ============================================= -->
    <div class="banner-style-three-area text-center bg-cover text-light bg-dark pb-4">

        <div class="animate-shape">
            <img src="assets/img/illustration/cloud.png" alt="Image not found">
            <img src="assets/img/illustration/cloud2.png" alt="Image not found">
        </div>

        <!-- Single Item -->
        <div class="banner-style-three">
            <div class="container">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="info">
                                <h2>Grow Your Business online with more Reach, Engagement, & Success</h2>
                                <div class="button mt-40">
                                    <a href="https://www.youtube.com/watch?v=owhuBrGIOsE" class="popup-youtube video-play-button optional light with-text">
                                        <div class="effect"></div>
                                        <span><i class="fas fa-play"></i> WATCH PROCESS</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="shape-bottom-center" style="background-image: url(assets/img/shape/5.png);"></div>
            <div class="shape-top-right" style="background-image: url(assets/img/shape/6.png);"></div>
            <div class="shape-left-top" style="background-image: url(assets/img/shape/7.png);"></div>
        </div>
        <!-- End Single Item -->
    </div>
    <!-- End Banner -->



    <!-- Start Brand
    ============================================= -->
    <div class="brand-style-two-area text-center default-padding">
        <div class="container">
            <div class="brand-style-two">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <div class="brand-heading mb-50">
                            <h2 class="title mb-25">We have many others partners <br> in global clients Here</h2>
                            <h4>Over <strong>150+</strong> client all over the world</h4>
                        </div>

                        <div class="brand4col swiper">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper align-items-center">

                                <?php
                                include('./admin/config.php');

                                $get_clients = mysqli_query($conn, "SELECT * FROM clients WHERE client_status = 1");
                                while ($clients = mysqli_fetch_assoc($get_clients)) {
                                ?>

                                    <!-- Single Item -->
                                    <div class="swiper-slide">
                                        <img src="./admin/<?= htmlspecialchars($clients['client_image']) ?>" height="80px" alt="Thumb">
                                    </div>
                                    <!-- End Single Item -->
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Brand -->
            </div>
        </div>
    </div>
    <!-- End Brand -->

    <!-- Start About 
    ============================================= -->
    <div class="about-area circle-shape-right-bottom p-3">
        <div class="shape-right-center" style="background-image: url(assets/img/shape/20.png);"></div>
        <div class="container">
            <div class="row align-center">

                <div class="col-lg-6 pr-70 pr-md-15 pr-xs-15">
                    <div class="about-style-two">
                        <div class="thumb">
                            <img class="wow fadeInLeft" src="assets/img/about-img.jpg" alt="Image not found">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 pl-60 pl-md-15 pl-xs-15">
                    <div class="about-style-two">
                        <h4 class="sub-heading">Why Choose Us</h4>
                        <h2 class="heading">Increase your client for <br> better position of Business</h2>
                        <div class="item-increase">
                            <h2>50% <i class="fas fa-arrow-up"></i></h2>
                            <h4>More Sales Generated</h4>
                            <p align='justify'>
                                At <strong>Sociavo</strong>, we are passionate about helping businesses thrive in the digital world. As a full-service social media marketing agency, we specialize in building strong online presences for brands of all sizes.
                                Our offerings include social media management, where we create and schedule engaging content while interacting with your audience, and content creation, producing high-quality graphics, videos, and copy that resonate with your brand’s voice.</p>
                        </div>
                        <a href="https://www.youtube.com/watch?v=owhuBrGIOsE" class="mt-25 popup-youtube video-play-button with-text">
                            <div class="effect"></div>
                            <span><i class="fas fa-play"></i> OUR STORY</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End About -->

    <!-- Start Brand 
    ============================================= -->
    <div class="brand-area text-light p-5">

        <div class="container">

            <!-- Start Fun Factor -->
            <div class="fun-factor-style-one  ">
                <div class="item-inner">
                    <div class="row">

                        <?php

                        $get_counter = mysqli_query($conn, "SELECT * FROM counter");
                        $counters = mysqli_fetch_assoc($get_counter)
                        ?>

                        <div class="col-lg-3 col-md-6 item">
                            <div class="fun-fact bg-dark">
                                <div class="counter">
                                    <div class="timer" data-to="<?= $counters['projects'] ?>" data-speed="2000"><?= $counters['projects'] ?></div>
                                    <div class="operator"></div>
                                </div>
                                <span class="medium">Projects</span>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 item">
                            <div class="fun-fact bg-dark">
                                <div class="counter">
                                    <div class="timer" data-to="<?= $counters['clients'] ?>" data-speed="2000"><?= $counters['clients'] ?></div>
                                    <div class="operator"></div>
                                </div>
                                <span class="medium">Clients</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 item">
                            <div class="fun-fact bg-dark">
                                <div class="counter">
                                    <div class="timer" data-to="<?= $counters['team'] ?>" data-speed="2000"><?= $counters['team'] ?></div>
                                    <div class="operator"></div>
                                </div>
                                <span class="medium">Team</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 item">
                            <div class="fun-fact bg-dark">
                                <div class="counter">
                                    <div class="timer" data-to="<?= $counters['hours_support'] ?>" data-speed="2000"><?= $counters['hours_support'] ?></div>
                                    <div class="operator">+</div>
                                </div>
                                <span class="medium">Hours of Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Fun Factor -->

        </div>
    </div>
    <!-- End Brand -->

    <!-- Start Services 
    ============================================= -->
    <?php

    // Fetch services from the database
    $query = "SELECT `service_id`, `service_name`, `service_icon`, `service_image`, SUBSTRING(`service_details`, 1, 100) AS preview, `service_status` FROM `services` WHERE `service_status` = 1";
    $result = mysqli_query($conn, $query);
    ?>


    <!-- Start Services Section -->
    <div class="text-center my-5 bg-gray p-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h4 class="sub-title">Our Services</h4>
                        <h2 class="title">Best services & solutions</h2>
                        <div class="devider"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container px-4">
            <div class="row">
                <?php
                // Loop through the services and display each one
                if (mysqli_num_rows($result) > 0) {
                    while ($service = mysqli_fetch_assoc($result)) {
                ?>
                        <!-- Single Service Item -->
                        <div class="col-xl-4 col-md-6 mb-30 ">
                            <div class="bg-white shadow-md round service-card">
                                <div class="icon text-center pt-4 mb-2">
                                    <img src="admin/<?= htmlspecialchars($service['service_icon']); ?>" height="100px" alt="Service Icon">
                                </div>
                                <h4>
                                    <a href="#"><?= htmlspecialchars($service['service_name']); ?></a>
                                </h4>
                                <p class="text-truncate"><?= $service['preview']; ?></p>
                                <a class="btn btn-dark rounded-pill mb-4 p-2" style="width: 200px;" href="service-details.php?id=<?= $service['service_id']  ?>">Read More</a>
                            </div>
                        </div>
                        <!-- End Single Service Item -->
                <?php
                    }
                } else {
                    echo '<p class="text-center">No services available at the moment.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- End Services Section -->

    <!-- End Services -->

    <?php

    // Fetch portfolio items from the database
    $query =  "SELECT p.*, s.service_name, c.service_category_name FROM portfolio p 
                               LEFT JOIN services s ON p.service_id = s.service_id
                               LEFT JOIN service_category c ON p.service_category_id = c.service_category_id";
    $result = mysqli_query($conn, $query);
    ?>

    <!-- Start Projects 
    ============================================= -->
    <!-- Start Projects Section -->
    <div class="project-area default-padding-bottom">
        <!-- Shape -->
        <div class="shape-left-bottom" style="background-image: url(assets/img/shape/21.png);"></div>
        <!-- End Shape -->
        <div class="shape-right-top" style="background-image: url(assets/img/shape/22.png);"></div>
        <!-- End Shape -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h2 class="title">Our Portfolio Projects</h2>
                        <div class="devider"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="projects-box">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <?php
                            // Loop through portfolio items and display them
                            if (mysqli_num_rows($result) > 0) {
                                while ($portfolio = mysqli_fetch_assoc($result)) {
                            ?>
                                    <!-- Single Project Item -->
                                    <div class="col-lg-4 col-md-6 single-item">
                                        <div class="project-style-one">
                                            <div class="thumb">
                                                <img src="admin/<?= htmlspecialchars($portfolio['portfolio_image']); ?>" height="300px" width="100%" alt="Portfolio Image">
                                            </div>
                                            <div class="content">
                                                <a class="button" href="<?= htmlspecialchars($portfolio['portfolio_url']); ?>"><i class="fas fa-angle-right"></i></a>
                                                <h4>
                                                    <a href="<?= htmlspecialchars($portfolio['portfolio_url']); ?>">
                                                        <?= htmlspecialchars($portfolio['portfolio_title']); ?>
                                                    </a>
                                                </h4>
                                                <ul>
                                                    <li><?= htmlspecialchars($portfolio['service_name']); ?></li>
                                                    <li><?= htmlspecialchars($portfolio['service_category_name']); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Project Item -->
                            <?php
                                }
                            } else {
                                echo '<p class="text-center">No projects available at the moment.</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-50 mt-xs-10 mt-md-20">
                        <div class="project-more-info">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <h2>Digal is ready to protect <br> your businesses</h2>
                                </div>
                                <div class="col-xl-5 col-lg-4 pl-35 pl-md-15 pl-xs-15">
                                    <p>
                                        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.
                                    </p>
                                </div>
                                <div class="col-xl-3 col-lg-4">
                                    <a class="btn btn-md btn-gradient animation" href="portfolio.php">View All <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Projects Section -->

    <!-- End Projects -->


    <!-- Start Pricing 
    ============================================= -->
    <!-- Start Pricing Section -->
    <div class="pricing-style-two-area bottom-less">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h4 class="sub-title">Our Packages</h4>
                        <h2 class="title">Select best pricing</h2>
                        <div class="devider"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <?php
                // Fetch pricing details from the database
                $query = "SELECT `pricing_id`, `pricing_feature`, `pricing_category`, `pricing_status` 
                      FROM `pricing` 
                      ORDER BY `pricing_category`";
                $result = mysqli_query($conn, $query);

                // Initialize categories
                $pricing_data = [
                    "Basic" => [],
                    "Standard" => [],
                    "Premium" => []
                ];

                // Group features by category
                while ($row = mysqli_fetch_assoc($result)) {
                    $category = $row['pricing_category'];
                    if (array_key_exists($category, $pricing_data)) {
                        $pricing_data[$category][] = $row;
                    }
                }

                // Pricing Plans Configuration
                $pricing_plans = [
                    "Basic" => [
                        "icon" => "fas fa-rocket",
                        "price" => "Free",
                        "class" => "btn-border-dark"
                    ],
                    "Standard" => [
                        "icon" => "fas fa-crown",
                        "price" => "$58 <sub>/ Monthly</sub>",
                        "class" => "btn-gradient effect active"
                    ],
                    "Premium" => [
                        "icon" => "fas fa-gem",
                        "price" => "$29 <sub>/ Monthly</sub>",
                        "class" => "btn-border-dark"
                    ]
                ];

                // Render Pricing Plans
                foreach ($pricing_data as $category => $features) {
                    $icon = $pricing_plans[$category]['icon'];
                    $price = $pricing_plans[$category]['price'];
                    $btn_class = $pricing_plans[$category]['class'];
                ?>
                    <!-- Single Item -->
                    <div class="col-xl-4 col-md-6 mb-30" style="min-height: 450px;">
                        <div class="pricing-style-two <?php if ($btn_class === 'btn-gradient effect active') echo 'active'; ?>">
                            <div class="pricing-header">
                                <i class="<?= $icon ?>"></i>
                                <h4><?= $category ?></h4>
                            </div>
                            <div class="pricing-content">
                                <ul>
                                    <?php
                                    // Display Features
                                    foreach ($features as $feature) {
                                        if ($feature['pricing_status'] == 1) {
                                            echo '<li><i class="fas fa-check-circle text-success"></i> ' . htmlspecialchars($feature['pricing_feature']) . '</li>';
                                        } else {
                                            echo '<li><i class="fas fa-times-circle text-danger"></i> <del class="text-muted">' . htmlspecialchars($feature['pricing_feature']) . '</del></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                                <div class="price">
                                    <h2><?= $price ?></h2>
                                </div>
                                <a class="btn mt-20 btn-md <?= $btn_class ?> animation circle" href="contact-us.php">Select Plan</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- End Pricing Section -->



    <!-- Start Testimonials 
    ============================================= -->
    <!-- Start Testimonials -->
    <div class="testimonials-area overflow-hidden bg-gray default-padding">
        <div class="shape-animation">
            <img src="assets/img/shape/anim-1.png" alt="Shape Animation">
        </div>
        <div class="container">
            <div class="row align-center">

                <div class="testimonial-style-one pl-65 pl-md-15 pl-xs-15 col-xl-12 col-lg-12">
                    <div class="testimonial-style-one ">
                        <h4 class="sub-heading">Testimonials</h4>
                        <h2 class="heading">What customers feedback about us</h2>
                    </div>
                    <div class="shape-right-bottom">
                        <img src="assets/img/shape/anim-2.png" alt="Shape">
                    </div>

                    <div class="testimonial-style-one-carousel swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <?php

                            // Fetch active testimonials from the database
                            $query = "SELECT `testimonial_id`, `testimonial_client_name`, `testimonial_message`, `testimonial_stars`, `testimonial_client_image`, `testimonial_status` FROM `testimonials` WHERE `testimonial_status` = 1";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($testimonial = mysqli_fetch_assoc($result)) {
                            ?>
                                    <!-- Single item -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-style-one-item">
                                            <div class="quote-icon">
                                                <img src="assets/img/quote.png" alt="Quote">
                                            </div>
                                            <div class="item">
                                                <div class="provider">
                                                    <div class="info">
                                                        <!-- Display Client Image -->
                                                        <img src="admin/<?= htmlspecialchars($testimonial['testimonial_client_image']) ?>" alt="Client Image" class="client-image">
                                                        <h4><?= htmlspecialchars($testimonial['testimonial_client_name']) ?></h4>
                                                        <span>
                                                            <strong>
                                                                <?php
                                                                // Render stars dynamically
                                                                for ($i = 0; $i < intval($testimonial['testimonial_stars']); $i++) {
                                                                    echo '<i class="fas fa-star text-warning"></i>';
                                                                }
                                                                for ($i = intval($testimonial['testimonial_stars']); $i < 5; $i++) {
                                                                    echo '<i class="far fa-star text-warning"></i>';
                                                                }
                                                                ?>
                                                            </strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <p>
                                                        <?= htmlspecialchars($testimonial['testimonial_message']) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single item -->
                            <?php
                                }
                            } else {
                                echo "<p>No testimonials available.</p>";
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials -->

    <!-- Start Faq Area 
    ============================================= -->
    <div class="faq-area bg-gray">
        <!-- Shape -->
        <div class="faq-sahpe">
            <img src="assets/img/illustration/faq1.png" alt="Image Not Found">
            <img src="assets/img/illustration/faq2.png" alt="Image Not Found">
        </div>
        <!-- End Shape -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h4 class="sub-title">Question & Answer</h4>
                        <h2 class="title">Need Quick Support?</h2>
                        <div class="devider"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 faq-style-one">

                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What services do you offer as a social media marketing agency?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        We offer comprehensive social media management, content creation, paid advertising campaigns, audience engagement, and performance tracking on platforms like Facebook, Instagram, Twitter, and LinkedIn. </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How can social media marketing benefit my business?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Social media marketing helps build brand awareness, engage with your target audience, increase website traffic, and drive conversions, all while creating a loyal customer base. </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Which services you provide in Graphic Designing?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        We offer logo design, branding, social media graphics, marketing materials (brochures, flyers), website graphics, and custom illustrations to enhance your visual identity. </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    How do I pay for your service?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Sennings appetite disposed me an at subjects an. To no indulgence diminution so discovered mr apartments. Are off under folly death wrote cause her way spite. Plan upon yet way get cold spot its week. Almost do am or limits hearts. Resolve parties but why she shewing. She sang know now minute exact dear open to reaching out.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Faq Area -->

    <!-- footer include -->
    <?php include('./includes/footer.php') ?>

    <!-- js links -->
    <?php include('./includes/js-links.php') ?>

</body>

</html>