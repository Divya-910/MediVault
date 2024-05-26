<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include config file
require_once('./config.php');



// Fetch test names from the database
$sql_city = "SELECT DISTINCT city FROM doctors";
$result_city = mysqli_query($conn, $sql_city);

// Check if query executed successfully
if (!$result_city) {
    die("Error in querying cities: " . mysqli_error($conn));
}

// Fetch specialties from the database
$sql_specialty = "SELECT DISTINCT speciality FROM doctors";
$result_specialty = mysqli_query($conn, $sql_specialty);

// Check if query executed successfully
if (!$result_specialty) {
    die("Error in querying specialties: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Recommendation Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        select,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #1a75ff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: ##1a75ff;
        }
    </style>
</head>
<body>
    <!-- Your HTML body content -->
    <div class="container">
        <h1>Recommend Doctors</h1>
        <form action="recommendation.php" method="POST">
            <label for="city">City:</label>
            <select id="city" name="city" required>
                <option value="">Select City</option>
                <?php
                // Fetch cities dynamically
                while ($row_city = mysqli_fetch_assoc($result_city)) {
                    echo "<option value='" . $row_city['city'] . "'>" . $row_city['city'] . "</option>";
                }
                ?>
            </select>

            <label for="speciality">Speciality:</label>
            <select id="speciality" name="speciality" required>
                <option value="">Select Specialty</option>
                <?php
                // Fetch specialties dynamically
                while ($row_specialty = mysqli_fetch_assoc($result_specialty)) {
                    echo "<option value='" . $row_specialty['speciality'] . "'>" . $row_specialty['speciality'] . "</option>";
                }
                ?>
            </select>

            <button type="submit">Find Doctors</button>
        </form>
    </div>
</body>

</html>