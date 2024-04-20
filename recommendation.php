<?php
// Include config file
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('./config.php');
?>

<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <!-- Side Navigation Bar -->
     <?php require_once('inc/navigation.php') ?>
     <!-- End Side Navigation Bar -->

     <!-- Doctor List Table -->
     <div class="content-wrapper pt-3" style="min-height: 567.854px;">
        <div class="container-fluid">
            <div class="doctor-table">
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="30%">
                        <col width="15%">
                    </colgroup>
                    <tbody>
                        <?php
                        // Include config file
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        require_once('./config.php');
                        // Include config file
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        require_once('./config.php');
                        
                        // Constants for pagination
                        $recordsPerPage = 10;
                        $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($pageNumber - 1) * $recordsPerPage;
                        
                        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        
                        try {
                        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                        
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        // Prepare the SQL query to count total doctors by city
                        $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM doctors WHERE city = ?");
                        $countStmt->bind_param("s", $city);
                        $countStmt->execute();
                        $countResult = $countStmt->get_result();
                        $totalDoctors = $countResult->fetch_assoc()['total']; // Assign the total count to $totalDoctors

                        // Calculate total pages
                        $totalPages = ceil($totalDoctors / $recordsPerPage);
                        
                        // Ensure the page number is within bounds
                        $pageNumber = max(min($pageNumber, $totalPages), 1);
                        
                        // Prepare the SQL query to select doctors by city, order by rating descending, and apply pagination
                        $stmt = $conn->prepare("SELECT * FROM doctors WHERE city = ? ORDER BY rating DESC LIMIT ?, ?");
                        $stmt->bind_param("sii", $city, $offset, $recordsPerPage);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            // Start styling for the table
                            echo '<style>
                            table {
                                margin: 0 auto;
                                width: 100%;
                            }
                            th, td {
                                padding: 10px;
                                text-align: center;
                                font-size: 18px;
                            }
                            th {
                                background-color: #007bff; /* Blue background color */
                                color: #fff; /* White text color */
                            }
                            tr:nth-child(even) {
                                background-color: #f2f2f2; /* Alternate row color */
                            }
                            .btn {
                                padding: 6px 12px;
                                font-size: 14px;
                                border-radius: 4px;
                            }
                            </style>';
                    
                            // Start the HTML table
                            echo '<div class="card card-outline card-primary rounded-0 shadow">';
                            echo '<div class="card-header">';
                            echo '<h1 class="card-title">List of Doctors</h1>';
                            echo '<table class="table table-bordered table-hover table-striped">';
                            echo '<colgroup>';
                            echo '<col width="5%">';
                            echo '<col width="30%">';
                            echo '<col width="15%">';
                            echo '</colgroup>';
                            echo '<thead>';
                            echo '<tr class="bg-gradient-primary text-light">';
                            echo '<th>Sno.</th>';
                            echo '<th>Doctor Name</th>';
                            echo '<th>Rating</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                    
                            $i = ($pageNumber - 1) * $recordsPerPage + 1;
                            while ($row = $result->fetch_assoc()) {
                                // Output doctor details in table rows
                                echo '<tr>';
                                echo '<td>' . $i++ . '</td>';
                                echo '<td>' . $row['name'] . '</td>';
                                echo '<td>' . $row['rating'] . '</td>';
                                echo '</tr>';
                            }
                    
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                    
                            // Display pagination controls
                            echo '<div class="pagination">';
                            echo '<ul class="pagination justify-content-center">';
                    
                            if ($pageNumber > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($pageNumber - 1) . '">Previous</a></li>';
                            }
                    
                            for ($i = 1; $i <= $totalPages; $i++) {
                                $activeClass = ($pageNumber == $i) ? 'active' : '';
                                echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                    
                            if ($pageNumber < $totalPages) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($pageNumber + 1) . '">Next</a></li>';
                            }
                    
                            echo '</ul>';
                            echo '</div>';
                        } else {
                            echo "No doctors found in the specified city.";
                        }
                    
                        $stmt->close();
                        $conn->close();
                    } catch (mysqli_sql_exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
     </div>
     <!-- End Doctor List Table -->

     <div class="modal fade" id="confirm_modal" role='dialog'>
        <!-- Modal content goes here -->
     </div>

     <div class="modal fade rounded-0" id="uni_modal" role='dialog'>
        <!-- Modal content goes here -->
     </div>

     <div class="modal fade rounded-0" id="uni_modal_right" role='dialog'>
        <!-- Modal content goes here -->
     </div>

     <div class="modal fade rounded-0" id="viewer_modal" role='dialog'>
        <!-- Modal content goes here -->
     </div>

     <?php require_once('inc/footer.php') ?>
    </div>

    <!-- Bootstrap and Custom CSS -->
    <style>
        .doctor-table {
            width: 80%;
            margin: 50px auto;
        }

        .doctor-table th,
        .doctor-table td {
            padding: 5px;
            text-align: center;
            font-size: 18px;
        }

        .bg-gradient-primary {
            background-color: #007bff !important;
            color: #fff;
        }

        .bg-gradient-primary th {
            background-color: #007bff !important;
            color: #fff;
        }

        .bg-gradient-primary tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
    </style>

    <!-- Bootstrap JS and other scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Your additional scripts can go here
    </script>
  </body>
</html>