<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sociavo - Digital Marketing Agency">

    <!-- ========== Page Title ========== -->
    <title>Sociavo - About Us</title>
    <!-- css links -->
    <?php include('./includes/css-links.php') ?>

</head>

<body>

    <!-- header include -->
    <?php include('./includes/header.php') ?>

    <!-- Start Breadcrumb 
    ============================================= -->
    <div class="breadcrumb-area text-center bg-dark" style="background-image: url(assets/img/shape/breadcrumb.png);">

        <div class="container">

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h1 class="text-white">About Us</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start About 
    ============================================= -->
    <div class="about-area circle-shape-right-bottom p-5">
        <div class="shape-right-center" style="background-image: url(assets/img/shape/20.png);"></div>
        <div class="container">
            <div class="row align-center">

                <div class="col-lg-6 pr-70 pr-md-15 pr-xs-15">
                    <div class="about-style-two">
                        <div class="thumb">
                            <img class="wow fadeInLeft" src="assets/img/about-img.jpg?v=<?= time(); ?>" alt="Image not found">
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


    <!-- Start Team Area 
    ============================================= -->
    <?php

    // Fetch team members from the database
    $query = "SELECT `team_member_id`, `team_member_name`, `team_member_image`, `team_member_profession`, `team_member_status` FROM `team`";
    $result = mysqli_query($conn, $query);
    ?>

    <div class="team-style-one-area text-center bg-gray default-padding bottom-less">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h4 class="sub-title">Team members</h4>
                        <h2 class="title">Expert Team Members</h2>
                        <div class="devider"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row align-center">
                <div class="col-lg-12">
                    <div class="row">
                        <?php
                        // Check if there are team members in the database
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through each team member and display their details
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <!-- Single Item -->
                                <div class="team-style-one col-xl-3 col-lg-6 col-md-6">
                                    <div class="team-style-one-item" style="background-image: url(assets/img/shape/11.png);">
                                        <div class="thumb">
                                            <img src="admin/<?= htmlspecialchars($row['team_member_image']); ?>" alt="<?= htmlspecialchars($row['team_member_name']); ?> Image">

                                        </div>
                                        <div class="info">
                                            <h4><a href="team-details.php?id=<?= htmlspecialchars($row['team_member_id']); ?>"><?= htmlspecialchars($row['team_member_name']); ?></a></h4>
                                            <span><?= htmlspecialchars($row['team_member_profession']); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Item -->
                        <?php
                            }
                        } else {
                            echo "<p>No team members found.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Team Area -->



    <!-- Start Why Choose us 
    ============================================= -->
    <div class="choose-us-area default-padding">
        <div class="container">
            <div class="row align-center">

                <div class="col-lg-6">
                    <div class="choose-us-style-one">
                        <div class="animate-illustration">
                            <img src="assets/img/illustration/v.png" alt="illustration">
                            <div class="sub-item">
                                <img class="wow pulse" src="assets/img/illustration/v8.png" alt="illustration">
                                <img class="wow fadeInLeft" data-wow-delay="300ms" src="assets/img/illustration/s5.png" alt="illustration">
                                <img class="wow fadeInUp" src="assets/img/illustration/v1.png" alt="illustration">
                                <img class="wow fadeInDown" data-wow-delay="400ms" src="assets/img/illustration/v5.png" alt="illustration">
                                <img class="wow fadeIn" data-wow-delay="500ms" src="assets/img/illustration/v6.png" alt="illustration">
                                <img src="assets/img/illustration/v3.png" alt="illustration">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 pl-50 pl-md-15 pl-xs-15">
                    <div class="choose-us-style-one">
                        <h4 class="sub-heading">Why Choose Us</h4>
                        <h2 class="heading">Increase your client for <br> better position of Business</h2>
                        <p>
                            With many years of experience and expertise, I have been recognized through the awards achieved, I am able to customize solutions to meet your specific needs regardless of size or industry. From small businesses to Fortune 1000 – hundreds of companies rely on Boseo to help grow their revenue through
                        </p>
                        <ul>
                            <li>
                                <div class="list-item">
                                    <div class="item">
                                        <h5>Global Reach </h5>
                                        <span>Upto 100% </span>
                                    </div>
                                    <div class="item">
                                        <h5>Convenience </h5>
                                        <span>To reach your target and get more traffict increment</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="progressbar">
                                    <div class="circle" data-percent="83">
                                        <strong></strong>
                                    </div>
                                    <h4>Business Growth</h4>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Why Choose Us -->



    <!-- footer include -->
    <?php include('./includes/footer.php') ?>

    <!-- js links -->
    <?php include('./includes/js-links.php') ?>

</body>

</html>