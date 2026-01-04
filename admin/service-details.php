<?php
include("auth.php");
include("config.php");

// Fetch service details if ID is provided
$service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;
$service_details = [];

if ($service_id > 0) {
    $query = $conn->prepare("SELECT `service_id`, `service_name`, `service_image`, `service_details`, `service_status` FROM `services` WHERE `service_id` = ?");
    $query->bind_param("i", $service_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        $service_details = $result->fetch_assoc();
    }
    $query->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Details</title>
    <?php include("includes/css-links.php") ?>
</head>

<body>
    <div id="app">
        <?php include("./includes/sidebar.php") ?>
        <div id="main">
            <?php include("./includes/navbar.php") ?>
            <div class="main-content container-fluid">
                <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content">
                                    <?php if (!empty($service_details)): ?>
                                        <img class="card-img-top img-fluid" src="<?php echo htmlspecialchars($service_details['service_image']); ?>" alt="<?php echo htmlspecialchars($service_details['service_name']); ?>">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo htmlspecialchars($service_details['service_name']); ?></h4>
                                            <p class="card-text">
                                                <?php echo $service_details['service_details']; ?>
                                            </p>

                                        </div>
                                    <?php else: ?>
                                        <div class="card-body">
                                            <h4 class="card-title">Service Not Found</h4>
                                            <p class="card-text">No service details are available for the provided ID.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php include("./includes/javascript-links.php") ?>
</body>

</html>