<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sociavo - Digital Marketing Agency">

    <!-- ========== Page Title ========== -->
    <title>Sociavo - Contact Us</title>
    <!-- CSS Links -->
    <?php include('./includes/css-links.php'); ?>
</head>

<body>

    <!-- Header Include -->
    <?php include('./includes/header.php'); ?>

    <!-- Start Breadcrumb -->
    <div class="breadcrumb-area text-center bg-dark" style="background-image: url(assets/img/shape/breadcrumb.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h1 class="text-white">Contact Us</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Contact Us -->
    <div class="contact-area p-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 pr-60 pr-md-15 pr-xs-15">
                    <div class="contact-style-one-info">
                        <h2>Contact Information</h2>
                        <p>Plan upon yet way get cold spot its week. Almost do am or limits hearts. Resolve parties but why she shewing.</p>
                        <ul>
                            <?php
                            include('./admin/config.php');
                            $get_contacts = mysqli_query($conn, "SELECT * FROM contact_info");
                            $contacts = mysqli_fetch_assoc($get_contacts);
                            ?>
                            <li>
                                <div class="icon"><i class="fas fa-phone-alt"></i></div>
                                <div class="content">
                                    <h4>Call on:</h4>
                                    <p><?= htmlspecialchars($contacts['contact_mobile']); ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="info">
                                    <h4>Our Location</h4>
                                    <p><?= htmlspecialchars($contacts['contact_address']); ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="icon"><i class="fas fa-envelope-open-text"></i></div>
                                <div class="info">
                                    <h4>Official Email</h4>
                                    <p><?= htmlspecialchars($contacts['contact_email']); ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-form-style-one">
                        <h4 class="sub-heading">Have Questions?</h4>
                        <h2 class="heading">Send us a Message</h2>
                        <form id="contactForm" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" name="name" placeholder="Name" type="text" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" name="email" placeholder="Email*" type="email" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" name="phone" placeholder="Phone" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" placeholder="Tell Us About Project *" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" id="submit">
                                        <i class="fa fa-paper-plane"></i> Get in Touch
                                    </button>
                                    <!-- Bootstrap Alert Placeholder -->
                                    <div id="alertPlaceholder" class="container mt-4"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact -->

    <!-- Footer Include -->
    <?php include('./includes/footer.php'); ?>

    <!-- JS Links -->
    <?php include('./includes/js-links.php'); ?>

    <!-- AJAX Script -->
    <script>
        $(document).ready(function() {
            $("#contactForm").on("submit", function(e) {
                e.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = $(this).serialize();

                // Send the data using $.ajax
                $.ajax({
                    url: "submit_message", // Server-side script to handle the form
                    type: "POST", // HTTP method
                    data: formData, // Form data
                    dataType: "json", // Expect a JSON response
                    success: function(response) {
                        // Handle success response
                        const alertPlaceholder = $("#alertPlaceholder");
                        alertPlaceholder.empty(); // Clear any previous alerts

                        // Add new alert message
                        const alertClass = response.type === "success" ? "alert-success" : "alert-danger";
                        const alertMessage = `<div class="alert ${alertClass}">${response.message}</div>`;
                        alertPlaceholder.append(alertMessage);

                        console.log(response);
                        // return 0;
                        // Clear the form if success
                        if (response.type == "success") {
                            $("#contactForm")[0].reset();
                        }

                        // Remove alert after 3 seconds
                        setTimeout(() => alertPlaceholder.empty(), 3000);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error("AJAX Error:", error);
                        $("#alertPlaceholder").html(`<div class="alert alert-danger">An error occurred while processing your request. Please try again later.</div>`);
                    }
                });
            });
        });
    </script>

</body>

</html>