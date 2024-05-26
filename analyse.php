<?php
// Include config file
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('./config.php');

// Initialize variables to hold fetched data
$messages = [];

// Check if testValue array is empty or if any value in the array is empty
if (empty($_POST['testValue']) || in_array('', $_POST['testValue'])) {
    $messages[] = "Please enter a test value.";
    $heading = "Test Range Undefined";
} else {
    $heading = "Report Analysis Results";

    // Fetch test names from the database
    $tests = $conn->query("SELECT * FROM BloodReports ORDER BY ReportName ASC");

    // Fetch test data from the database based on test names submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $testNames = $_POST['testName'] ?? [];
        $testValues = $_POST['testValue'] ?? [];

        // Build the SQL query dynamically
        $placeholders = implode(',', array_fill(0, count($testNames), '?'));
        $query = "SELECT * FROM BloodReports WHERE ReportName IN ($placeholders)";
        $stmt = $conn->prepare($query);

        // Bind parameters and execute the query
        $stmt->bind_param(str_repeat('s', count($testNames)), ...$testNames);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any results were fetched
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $testName = $row['ReportName'];
                $lowerRange = $row['LowerRange'];
                $upperRange = $row['UpperRange'];
                $valueIndex = array_search($testName, $testNames);
                if ($valueIndex !== false && isset($testValues[$valueIndex])) {
                    $value = floatval($testValues[$valueIndex]);
                    if ($value >= $lowerRange && $value <= $upperRange) {
                        $messages[] = "<span style='color: #4CAF50;'>{$testName}: Value is within the normal range.</span>";
                    } else {
                        $messages[] = "<span style='color: #f44336;'>{$testName}: Value is outside the normal range. Medical advice needed.</span>";
                    }
                }
            }
        } else {
            $messages[] = 'No test data found.';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">

<head>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        /* Define the message colors */
        .message-success {
            color: #4CAF50;
        }

        .message-error {
            color: #f44336;
        }

        .container {
            /* display: flex; */
            min-height: 100vh;
            padding: 50px;
            width: 100%;
        }

        .inner-container {
            max-width: 600px;
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(2, 2, 2, 0.1);
            text-align: center;
            padding: 20px;
            margin: auto; /* Center the container horizontally */
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .message {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<?php require_once('inc/header.php') ?>
<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <?php require_once('inc/topBarNav.php') ?>
    <?php require_once('inc/navigation.php') ?>
    <div class="container">
        <div class="inner-container">
            <h1><?php echo $heading ?></h1>
            <!-- Display Messages -->
            <?php foreach ($messages as $message) : ?>
                <div class="message"><?= $message ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php require_once('inc/footer.php') ?>
</body>

</html>
