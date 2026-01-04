<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <?php include('./includes/css-links.php') ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include('./includes/header.php') ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-area text-center bg-dark" style="background-image: url(assets/img/shape/breadcrumb.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h1 class="text-white">Our Portfolio</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container my-5">
        <div class="row">
            <!-- Sidebar: Services -->
            <div class="col-md-3 mb-4">
         
                <h2 class="bg-dark text-white px-3 py-2 m-0">Services</h2>
                <div class="card">
                    <ul class="list-group list-group-flush">

                        <?php
                        $services_query = "SELECT s.service_id, s.service_name, COUNT(p.portfolio_id) AS portfolio_count 
                                           FROM services s 
                                           LEFT JOIN portfolio p ON s.service_id = p.service_id 
                                           GROUP BY s.service_id";
                        $services_result = mysqli_query($conn, $services_query);

                        while ($service = mysqli_fetch_assoc($services_result)) : ?>
                            <li class="list-group-item">
                                <a href="#" class="service-link fw-400 " data-service="<?= $service['service_id'] ?>">
                                    <?= htmlspecialchars($service['service_name']) ?>
                                    <span class="badge bg-secondary float-end"><?= $service['portfolio_count'] ?></span>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <!-- Portfolio Section -->
            <div class="col-md-9">
                <div class="row row-cols-1 row-cols-md-3 g-4" id="portfolio-container">
                    <!-- Portfolios will be loaded here via AJAX -->
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center" id="pagination-container">
                        <!-- Pagination will be loaded here via AJAX -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php include('./includes/footer.php') ?>
    <?php include('./includes/js-links.php') ?>

    <script>
        $(document).ready(function() {
            // Initialize variables
            let currentPage = 1;
            let currentService = 0;

            // Load all portfolios on page load
            fetchPortfolios(currentService, currentPage);

            // Fetch portfolios on service link click
            $('.service-link').click(function(e) {
                e.preventDefault();
                currentService = $(this).data('service');
                currentPage = 1; // Reset to first page
                fetchPortfolios(currentService, currentPage);
            });

            // Handle pagination click
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                currentPage = $(this).data('page');
                fetchPortfolios(currentService, currentPage);
            });

            // AJAX function to fetch portfolios
            function fetchPortfolios(serviceId, page) {
                $.ajax({
                    url: 'get-portfolio',
                    type: 'POST',
                    data: {
                        service: serviceId,
                        page: page
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Update portfolios
                        const portfolioContainer = $('#portfolio-container');
                        portfolioContainer.empty();

                        if (response.portfolios.length > 0) {
                            response.portfolios.forEach(portfolio => {
                                const portfolioCard = `
                                    <div class="col">
                                        <div class="project-style-one">
                                            <div class="thumb">
                                                <img src="admin/${portfolio.portfolio_image}" height="300px" width="100%" alt="Portfolio Image">
                                            </div>
                                            <div class="content">
                                                <a class="button" href="${portfolio.portfolio_url}" target="_blank">
                                                    <i class="fas fa-angle-right"></i>
                                                </a>
                                                <h4>
                                                    <a href="${portfolio.portfolio_url}" target="_blank">${portfolio.portfolio_title}</a>
                                                </h4>
                                                <ul>
                                                    <li>${portfolio.service_name}</li>
                                                    <li>${portfolio.service_category_name}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                portfolioContainer.append(portfolioCard);
                            });
                        } else {
                            portfolioContainer.html('<p class="text-center">No portfolios found for this service.</p>');
                        }

                        // Update pagination
                        const paginationContainer = $('#pagination-container');
                        paginationContainer.empty();

                        for (let i = 1; i <= response.total_pages; i++) {
                            const pageItem = `
                                <li class="page-item ${i === page ? 'active' : ''}">
                                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                                </li>
                            `;
                            paginationContainer.append(pageItem);
                        }
                    },
                    error: function() {
                        alert('Failed to fetch portfolios. Please try again.');
                    }
                });
            }
        });
    </script>
</body>

</html>