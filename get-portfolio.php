<?php
// Database Connection
include('./admin/config.php');

$service_filter = isset($_POST['service']) ? (int)$_POST['service'] : 0;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 20; // Items per page
$offset = ($page - 1) * $limit;

// Count total portfolios
if ($service_filter > 0) {
    $count_query = "SELECT COUNT(*) as total FROM portfolio WHERE service_id = $service_filter";
} else {
    $count_query = "SELECT COUNT(*) as total FROM portfolio";
}
$count_result = mysqli_fetch_assoc(mysqli_query($conn, $count_query));
$total_portfolios = $count_result['total'];
$total_pages = ceil($total_portfolios / $limit);

// Fetch Portfolios
if ($service_filter > 0) {
    $portfolio_query = "SELECT p.*, s.service_name, c.service_category_name 
                        FROM portfolio p 
                        LEFT JOIN services s ON p.service_id = s.service_id 
                        LEFT JOIN service_category c ON p.service_category_id = c.service_category_id 
                        WHERE p.service_id = $service_filter 
                        LIMIT $limit OFFSET $offset";
} else {
    $portfolio_query = "SELECT p.*, s.service_name, c.service_category_name 
                        FROM portfolio p 
                        LEFT JOIN services s ON p.service_id = s.service_id 
                        LEFT JOIN service_category c ON p.service_category_id = c.service_category_id 
                        LIMIT $limit OFFSET $offset";
}

$portfolio_result = mysqli_query($conn, $portfolio_query);
$portfolios = [];

while ($portfolio = mysqli_fetch_assoc($portfolio_result)) {
    $portfolios[] = $portfolio;
}

echo json_encode([
    'portfolios' => $portfolios,
    'total_pages' => $total_pages,
]);
