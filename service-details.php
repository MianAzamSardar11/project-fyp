<?php
include('admin/config.php');

// Validate and sanitize the 'id' parameter
$get_service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($get_service_id <= 0) {
    echo "<p>Invalid service ID.</p>";
    exit;
}

// Query to fetch service details
$query = "SELECT `service_id`, `service_name`, `service_icon`, `service_image`, `service_details`, `service_status` 
          FROM `services` WHERE `service_status` = 1 AND `service_id` = $get_service_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

// Fetch the service details
$service = mysqli_fetch_assoc($result);

if (!$service) {
    echo "<p>Service not found.</p>";
    exit;
}

// Safely assign values
$service_name = isset($service['service_name']) ? htmlspecialchars($service['service_name']) : "Unknown Service";
$service_image = isset($service['service_image']) ? htmlspecialchars($service['service_image']) : "default-image.jpg";
$service_details = isset($service['service_details']) ? $service['service_details'] : "No details available.";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sociavo - Digital Marketing Agency">

    <title>Sociavo - <?= $service_name; ?></title>

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
                    <h1 class="text-white"><?= $service_name; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Project Details Area -->
    <div class="project-details-area p-5">
        <div class="container">
            <h2 class="fs-1 fw-bold mb-3"><?= $service_name; ?></h2>
            <hr>
 
            <div class="project-details-items my-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row g-3">
                            <!-- Fetch categories for the service -->
                            <?php
                            $get_service_categories = "SELECT 
                                                        sc.service_category_name, 
                                                        sc.service_category_price, 
                                                        sc.service_category_status
                                                    FROM 
                                                        service_category sc
                                                    JOIN 
                                                        services s ON sc.service_id = s.service_id
                                                    WHERE 
                                                        sc.service_category_status = 1 AND s.service_id = '$get_service_id'";

                            $categories_result = mysqli_query($conn, $get_service_categories);
                            if (!$categories_result) {
                                die("Query Failed: " . mysqli_error($conn));
                            }

                            // Loop through categories and display in cards
                            while ($category_name = mysqli_fetch_assoc($categories_result)) {
                            ?>
                                <div class="col-md-6 mb-3 p-2">
                                    <div class="card text-center py-3 border-0 service-category-card" style='box-shadow:0px 0px 7px 0px #c6c6c6;'>
                                        <h4 class='fw-bold text-warning'><?= htmlspecialchars($category_name['service_category_name']); ?></h4>
                                        <h5>Price: <?= htmlspecialchars($category_name['service_category_price']); ?></h5>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="project-thumb">
                            <img src="admin/<?= $service_image; ?>" class="img-fluid" alt="Service Image">
                        </div>
                    </div>

                    <div class="top-info">
                        <div class="row">
                            <div class="col-xl-12 left-info">
                                <p><?= $service_details; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Project Details Area -->

    <!-- Footer Include -->
    <?php include('./includes/footer.php'); ?>

    <!-- JS Links -->
    <?php include('./includes/js-links.php'); ?>
</body>

</html>