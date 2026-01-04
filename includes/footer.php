    <?php
    include('admin/config.php');
    $get_logo = mysqli_query($conn, "SELECT * FROM logo");
    $logo = mysqli_fetch_assoc($get_logo);
    ?>

    <!-- Start Footer 
    ============================================= -->
    <footer class="bg-dark text-light" style="background-image: url(assets/img/shape/35.png);">
        <div class="container">
            <div class="f-items default-padding">
                <div class="row">
                    <div class="col-lg-5 col-md-6 footer-item pr-50 pr-xs-15 pr-md-15">
                        <div class="about">
                            <img class="logo" src="admin/<?= $logo['main_logo'] ?>" alt="Logo">
                            <p>
                                Excellence decisively nay man per impression maximum contrasted remarkably is perfect point. uncommonly solicitude inhabiting projection.
                            </p>
                            <ul class="footer-social">

                                <?php
                                $get_links = mysqli_query($conn, "SELECT * FROM social_links");
                                $links = mysqli_fetch_assoc($get_links);
                                ?>

                                <li>
                                    <a href="<?= $links['facebook'] ?>"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="<?= $links['instagram'] ?>"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="<?= $links['linkedin'] ?>"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li>
                                    <a href="<?= $links['youtube'] ?>"><i class="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-item">
                        <div class="link">
                            <h4 class="widget-title">Our Services</h4>
                            <ul>
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
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 footer-item adress-item">
                        <h4 class="widget-title">Official Info</h4>
                        <div class="address">
                            <ul>

                                <?php
                                $get_contacts = mysqli_query($conn, "SELECT * FROM contact_info");
                                $contacts = mysqli_fetch_assoc($get_contacts);
                                ?>

                                <li>
                                    <div class="content">
                                        <strong>Address:</strong>
                                        <?= htmlspecialchars($contacts['contact_address']); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="content">
                                        <strong>Email:</strong>
                                        <?= htmlspecialchars($contacts['contact_email']); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="content">
                                        <strong>Phone:</strong>
                                        <?= htmlspecialchars($contacts['contact_mobile']); ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Start Footer Bottom -->
        <div class="footer-bottom bg-dark-secondary">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <p>&copy; Copyright 2025. All Rights Reserved by <strong>Sociavo</strong></p>
                    </div>
                    <div class="col-lg-6 text-end">
                        <ul>
                            <li>
                                <p>Developed By <strong class="ms-1">Muhammad Azam Sardar</strong></p>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>
    <!-- End Footer -->