<?php
include('config.php');

if (isset($_POST['service_id'])) {
    $service_id = $_POST['service_id'];
    $query = "SELECT service_category_id, service_category_name 
              FROM service_category WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $query);

    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    echo json_encode($categories);
}
