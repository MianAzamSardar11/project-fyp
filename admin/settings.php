<?php
include("auth.php");
include("config.php");

// Utility functions
function executeQuery($conn, $query, $params = [])
{
    $stmt = mysqli_prepare($conn, $query);
    if ($params) {
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function fetchRow($conn, $query, $params = [])
{
    $result = executeQuery($conn, $query, $params);
    return mysqli_fetch_assoc($result);
}

function modifyData($conn, $query, $params = [])
{
    $stmt = mysqli_prepare($conn, $query);
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}
function fetchAllRows($conn, $query, $params = [])
{
    $stmt = mysqli_prepare($conn, $query);
    if ($params) {
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $id = $_POST['id'];

    $primaryKeys = [
        'counter' => 'counter_id',
        'contact_info' => 'contact_info_id',
        'social_links' => 'social_links_id',
        'logo' => 'logo_id',
    ];

    if (!isset($primaryKeys[$type])) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid table type.'];
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }

    $primaryKey = $primaryKeys[$type];

    if ($type === 'logo') {
        $uploadDir = 'uploads/logo/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $currentLogos = fetchRow($conn, "SELECT main_logo, second_logo FROM logo WHERE $primaryKey = ?", [$id]);

        $mainLogoPath = $_FILES['main_logo']['name']
            ? $uploadDir . time() . "_" . basename($_FILES['main_logo']['name'])
            : $currentLogos['main_logo'];

        $secondLogoPath = $_FILES['second_logo']['name']
            ? $uploadDir . time() . "_" . basename($_FILES['second_logo']['name'])
            : $currentLogos['second_logo'];

        if ($_FILES['main_logo']['name'] && move_uploaded_file($_FILES['main_logo']['tmp_name'], $mainLogoPath)) {
            if ($currentLogos['main_logo'] && file_exists($currentLogos['main_logo'])) {
                unlink($currentLogos['main_logo']);
            }
        }

        if ($_FILES['second_logo']['name'] && move_uploaded_file($_FILES['second_logo']['tmp_name'], $secondLogoPath)) {
            if ($currentLogos['second_logo'] && file_exists($currentLogos['second_logo'])) {
                unlink($currentLogos['second_logo']);
            }
        }

        $query = "UPDATE logo SET site_name = ?, main_logo = ?, second_logo = ? WHERE $primaryKey = ?";
        $success = modifyData($conn, $query, [
            $_POST['site_name'],
            $mainLogoPath,
            $secondLogoPath,
            $id,
        ]);
    } else {
        $fields = array_diff_key($_POST, ['type' => '', 'id' => '']);
        $setQuery = implode(', ', array_map(fn($key) => "$key = ?", array_keys($fields)));
        $values = array_values($fields);
        $values[] = $id;

        $query = "UPDATE $type SET $setQuery WHERE $primaryKey = ?";
        $success = modifyData($conn, $query, $values);
    }

    $_SESSION['alert'] = $success
        ? ['type' => 'success', 'message' => ucfirst($type) . ' updated successfully.']
        : ['type' => 'danger', 'message' => 'Failed to update ' . ucfirst($type) . '.'];

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <?php include("includes/css-links.php") ?>
</head>

<body>
    <div id="app">
        <?php include("includes/sidebar.php") ?>
        <div id="main">
            <?php include("includes/navbar.php") ?>

            <div class="main-content container-fluid">
                <section class="section">
                    <?php if (isset($_SESSION['alert']['message'])): ?>
                        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                            <?= $_SESSION['alert']['message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['alert']); ?>
                    <?php endif; ?>

                    <?php
                    $sections = [
                        'counter' => ['clients' => 'Clients', 'projects' => 'Projects', 'team' => 'Team', 'hours_support' => 'Hours Support'],
                        'contact_info' => ['contact_mobile' => 'Mobile', 'contact_email' => 'Email', 'contact_address' => 'Address'],
                        'social_links' => ['facebook' => 'Facebook', 'whatsapp' => 'WhatsApp', 'instagram' => 'Instagram', 'youtube' => 'YouTube'],
                        'logo' => ['site_name' => 'Site Name', 'main_logo' => 'Main Logo', 'second_logo' => 'Second Logo'],
                    ];

                    foreach ($sections as $type => $fields) {
                        echo "<div class='card'>
            <div class='card-header d-flex justify-content-between'>
                <h4>" . ucfirst($type) . "</h4>
            </div>
            <div class='card-body'>
                <table class='table table-sm table-bordered text-center'>";

                        // Fetch rows and dynamically render table
                        $rows = fetchAllRows($conn, "SELECT * FROM {$type}");
                        if (!empty($rows)) {
                            // Render table headers dynamically
                            echo "<tr class='table-primary'>";
                            foreach (array_keys($rows[0]) as $column) {
                                if (strpos($column, '_id') !== false) continue; // Skip ID columns

                                echo "<td>" . ucfirst(str_replace('_', ' ', $column)) . "</td>";
                            }
                            echo "<td>Action</td>";
                            echo "</tr>";

                            // Render table rows dynamically
                            echo "<tbody>";
                            foreach ($rows as $row) {
                                echo "<tr>";
                                foreach ($row as $column => $value) {
                                    if (strpos($column, '_id') !== false) continue; // Skip ID columns

                                    if ($type === 'logo' && ($column === 'main_logo' || $column === 'second_logo')) {
                                        // Display image for logo fields
                                        echo "<td>";
                                        if ($value) {
                                            echo "<img src='{$value}' alt='{$column}' style='width: 50px; height: auto;'>";
                                        } else {
                                            echo "No Image";
                                        }
                                        echo "</td>";
                                    } else {
                                        // Display normal values for other fields
                                        echo "<td>" . htmlspecialchars($value) . "</td>";
                                    }
                                }
                                $json_data = htmlspecialchars(json_encode($row));
                                echo "<td>
                    <button class='btn btn-orange btn-sm edit-btn' data-bs-toggle='modal' 
                            data-bs-target='#editModal' data-type='{$type}' data-record='{$json_data}'>
                             Edit
                    </button>
                  </td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                        } else {
                            // Display message if no records exist
                            echo "<tr><td colspan='" . (count($fields) + 1) . "'>No records found</td></tr>";
                        }

                        echo "</table>
        </div>
    </div>";
                    }
                    ?>

                </section>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" method="post" id="editForm" enctype="multipart/form-data">
                    <input type="hidden" name="type" id="modalType">
                    <input type="hidden" name="id" id="modalId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modalBody">
                            <!-- Fields will be dynamically generated here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-orange">Save Changes</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <?php include("includes/javascript-links.php") ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const editButtons = document.querySelectorAll('.edit-btn');
                const modalType = document.getElementById('modalType');
                const modalId = document.getElementById('modalId');
                const modalBody = document.getElementById('modalBody');

                editButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const record = JSON.parse(button.dataset.record);
                        const type = button.dataset.type;

                        modalType.value = type;
                        modalId.value = record[type + '_id'];

                        modalBody.innerHTML = '';
                        Object.entries(record).forEach(([key, value]) => {
                            if (key.endsWith('_id')) return;

                            if (type === 'logo' && (key === 'main_logo' || key === 'second_logo')) {
                                modalBody.innerHTML += `
                        <div class="mb-3">
                            <label for="${key}" class="form-label">${key.replace(/_/g, ' ').toUpperCase()}</label>
                            <input type="file" class="form-control" id="${key}" name="${key}">
                            <small>Current: ${value ? `<a href="${value}" target="_blank">View</a>` : 'None'}</small>
                        </div>
                    `;
                            } else {
                                modalBody.innerHTML += `
                        <div class="mb-3">
                            <label for="${key}" class="form-label">${key.replace(/_/g, ' ').toUpperCase()}</label>
                            <input type="text" class="form-control" id="${key}" name="${key}" value="${value}" required>
                        </div>
                    `;
                            }
                        });
                    });
                });
            });
        </script>
</body>

</html>