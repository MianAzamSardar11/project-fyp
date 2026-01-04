<?php
include("auth.php");
include("config.php");


// Get the counts from the database
$services_count = mysqli_num_rows(mysqli_query($conn, "SELECT `service_id` FROM `services`"));
$team_count = mysqli_num_rows(mysqli_query($conn, "SELECT `team_member_id` FROM `team`"));
$clients_count = mysqli_num_rows(mysqli_query($conn, "SELECT `client_id` FROM `clients`"));
$projects_count = mysqli_num_rows(mysqli_query($conn, "SELECT `project_id` FROM `projects`"));

// Get today's date
$today_date = date('F j, Y');

// Fetch monthly earnings
$query = "SELECT 
              MONTHNAME(`created_at`) AS `month`, 
              SUM(`project_price`) AS `total_earnings`
          FROM `projects`
          WHERE `project_status` = 'completed'
          GROUP BY MONTH(`created_at`)
          ORDER BY MONTH(`created_at`) ASC";

$result = $conn->query($query);
$monthly_earnings = [];

while ($row = $result->fetch_assoc()) {
    $monthly_earnings[] = [
        'month' => $row['month'],
        'total_earnings' => (float)$row['total_earnings'],
    ];
}

// Fetch last month's earnings
$last_month_query = "SELECT 
                         SUM(`project_price`) AS `last_month_earnings`
                     FROM `projects`
                     WHERE MONTH(`created_at`) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
                     AND `project_status` = 'completed'";

$last_month_result = $conn->query($last_month_query);
$last_month_earnings = $last_month_result->fetch_assoc()['last_month_earnings'] ?? 0;
?>
<script>
    const monthlyEarnings = <?php echo json_encode($monthly_earnings); ?>;
    const lastMonthEarnings = <?php echo $last_month_earnings; ?>;
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard </title>
    <!--====== css links ========-->
    <?php include("includes/css-links.php") ?>

</head>

<body>
    <div id="app">
        <!--========= sidebar ==========-->
        <?php include("./includes/sidebar.php") ?>
        <div id="main">
            <!--============= navbar ===============-->
            <?php include("./includes/navbar.php") ?>

            <div class="main-content container-fluid">
                <div class="page-title mb-3">
                    <h3>Dashboard</h3>
                </div>
                <section class="section">
                    <div class="row mb-2">
                        <div class="col-12 col-md-3">
                            <div class="card bg-orange text-white">
                                <div class="card-body p-0">
                                    <div class='p-3'>
                                        <h3 class='card-title text-white mb-3'>Services</h3>
                                        <div class="card-right d-flex align-items-center justify-content-between">
                                            <p><?php echo $services_count; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="card bg-orange text-white">
                                <div class="card-body p-0">
                                    <div class='p-3'>
                                        <h3 class='card-title text-white mb-3'>Team</h3>
                                        <div class="card-right d-flex align-items-center justify-content-between">
                                            <p><?php echo $team_count; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="card bg-orange text-white">
                                <div class="card-body p-0">
                                    <div class='p-3'>
                                        <h3 class='card-title mb-3 text-white'>Clients</h3>
                                        <div class="card-right d-flex align-items-center justify-content-between">
                                            <p><?php echo $clients_count; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="card bg-orange text-white">
                                <div class="card-body p-0">
                                    <div class='p-3'>
                                        <h3 class='card-title text-white mb-3'>Projects</h3>
                                        <div class="card-right d-flex align-items-center justify-content-between">
                                            <p><?php echo $projects_count; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-body ">
                                    <canvas id="monthlyIncomeChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const ctx = document.getElementById('monthlyIncomeChart').getContext('2d');

                                const labels = monthlyEarnings.map(item => item.month);
                                const data = monthlyEarnings.map(item => item.total_earnings);

                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Monthly Income ($)',
                                            data: data,
                                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            });
                        </script>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div id="radialBars">
                                        <canvas id="lastMonthIncomeChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const ctx = document.getElementById('lastMonthIncomeChart').getContext('2d');

                                new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: ['Last Month Income', 'Remaining'],
                                        datasets: [{
                                            label: 'Last Month Income ($)',
                                            data: [lastMonthEarnings, 100000 - lastMonthEarnings], // Assuming a max scale for the chart
                                            backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(201, 203, 207, 0.4)'],
                                            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(201, 203, 207, 0.8)'],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        return `$${context.raw}`;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>

                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2022 &copy; Voler</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class='text-danger'><i data-feather="heart"></i></span> by <a href="https://saugi.me">Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- js links -->
    <?php include("./includes/javascript-links.php") ?>
</body>

</html>